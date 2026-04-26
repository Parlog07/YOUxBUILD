<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private const VENDOR_VISIBLE_STATUSES = [
        OrderStatus::CONFIRMED->value,
        OrderStatus::SHIPPED->value,
        OrderStatus::DELIVERED->value,
        OrderStatus::CANCELLED->value,
    ];

    /**
     * Show the current user's pending cart.
     */
    public function index()
    {
        $order = Order::with('items.product')
            ->where('client_id', auth()->id())
            ->where('status', OrderStatus::PENDING->value)
            ->first();

        return view('cart', compact('order'));
    }

    /**
     * Create the current cart if it does not exist yet.
     */
    private function getOrCreateCart($user)
    {
        return Order::firstOrCreate(
            [
                'client_id' => $user->id,
                'status' => OrderStatus::PENDING->value,
            ],
            [
                'order_reference' => 'ORD-' . strtoupper(uniqid()),
                'total_amount' => 0,
            ]
        );
    }

    /**
     * Add a product to the authenticated user's cart.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $order = $this->getOrCreateCart(auth()->user());
        $product = Product::findOrFail($request->product_id);

        $item = $order->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->quantity += $request->quantity;
            $item->subtotal = $item->unit_price * $item->quantity;
            $item->save();
        } else {
            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'unit_price' => $product->price,
                'subtotal' => $product->price * $request->quantity,
            ]);
        }

        $this->updateTotal($order);

        return redirect()->back()->with('success', 'Product added to cart');
    }

    /**
     * Update one cart item that belongs to the current user.
     */
    public function updateItem(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item = OrderItem::findOrFail($itemId);

        if ($item->order->client_id !== auth()->id()) {
            abort(403);
        }

        $item->quantity = $request->quantity;
        $item->subtotal = $item->unit_price * $item->quantity;
        $item->save();

        $this->updateTotal($item->order);

        return redirect()->back()->with('success', 'Item updated');
    }

    /**
     * Remove one cart item that belongs to the current user.
     */
    public function removeItem($itemId)
    {
        $item = OrderItem::findOrFail($itemId);

        if ($item->order->client_id !== auth()->id()) {
            abort(403);
        }

        $order = $item->order;
        $item->delete();

        $this->updateTotal($order);

        return redirect()->back()->with('success', 'Item removed');
    }

    /**
     * Return the cart as JSON for quick inspection.
     */
    public function viewCart()
    {
        $order = Order::with('items.product')
            ->where('client_id', auth()->id())
            ->where('status', OrderStatus::PENDING->value)
            ->first();

        return response()->json($order);
    }

    /**
     * Turn the pending cart into a confirmed order.
     */
    public function checkout()
    {
        $order = Order::where('client_id', auth()->id())
            ->where('status', OrderStatus::PENDING->value)
            ->firstOrFail();

        if ($order->items->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        $order->status = OrderStatus::CONFIRMED->value;
        $order->ordered_at = now();
        $order->save();

        return redirect()->route('orders.index')
            ->with('success', 'Order confirmed');
    }

    public function payment()
    {
        $preferredAddress = auth()->user()
            ->addresses()
            ->orderByDesc('is_default')
            ->orderByDesc('id')
            ->first();

        $order = Order::where('client_id', auth()->id())
            ->where('status', OrderStatus::PENDING->value)
            ->with(['items.product', 'address'])
            ->firstOrFail();

        return view('orders.payment', compact('order', 'preferredAddress'));
    }

    public function confirmPayment(Request $request)
    {
        $data = $request->validate([
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email'],
        ]);

        $order = Order::where('client_id', auth()->id())
            ->where('status', OrderStatus::PENDING->value)
            ->firstOrFail();

        DB::transaction(function () use ($data, $order): void {
            $address = Address::create([
                'client_id' => auth()->id(),
                'street' => $data['street'],
                'city' => $data['city'],
                'postal_code' => $data['postal_code'],
                'country' => $data['country'],
                'phone_number' => $data['phone_number'],
                'email' => $data['email'],
            ]);

            $order->update([
                'address_id' => $address->id,
                'status' => OrderStatus::CONFIRMED->value,
                'ordered_at' => now(),
            ]);
        });

        return redirect()
            ->route('orders.index')
            ->with('success', 'Payment successful, order confirmed.');
    }

    /**
     * Recalculate the total amount from the current order items.
     */
    private function updateTotal($order)
    {
        $order->syncTotalAmount();
    }

    /**
     * Show the authenticated client's completed orders.
     */
    public function myOrders()
    {
        $orders = Order::with(['items.product', 'client', 'address'])
            ->where('client_id', auth()->id())
            ->where('status', '!=', OrderStatus::PENDING->value)
            ->latest()
            ->get();

        return view('orders.index', [
            'orders' => $orders,
            'pageTitle' => 'My Orders',
        ]);
    }

    /**
     * Show only orders that contain the current vendor's products.
     */
    public function vendorOrders()
    {
        $vendor = auth()->user()->vendorProfile;

        $orders = $this->vendorOrdersQuery($vendor->getKey())
        ->whereIn('status', self::VENDOR_VISIBLE_STATUSES)
        ->latest()
        ->get();

        return view('orders.index', [
            'orders' => $orders,
            'pageTitle' => 'Vendor Orders',
        ]);
    }

    /**
     * Move a vendor-owned order from confirmed to shipped.
     */
    public function markAsShipped($id)
    {
        $order = $this->findVendorOrder($id);

        if ($order->status !== OrderStatus::CONFIRMED->value) {
            return redirect()
                ->route('vendor.orders')
                ->with('error', 'Only confirmed orders can be marked as shipped.');
        }

        $order->update(['status' => OrderStatus::SHIPPED->value]);

        return redirect()
            ->route('vendor.orders')
            ->with('success', 'Order marked as shipped.');
    }

    /**
     * Move a vendor-owned order from shipped to delivered.
     */
    public function markAsDelivered($id)
    {
        $order = $this->findVendorOrder($id);

        if ($order->status !== OrderStatus::SHIPPED->value) {
            return redirect()
                ->route('vendor.orders')
                ->with('error', 'Only shipped orders can be marked as delivered.');
        }

        $order->update(['status' => OrderStatus::DELIVERED->value]);

        return redirect()
            ->route('vendor.orders')
            ->with('success', 'Order marked as delivered.');
    }

    /**
     * Show all non-cart orders in the admin area.
     */
    public function adminOrders()
    {
        $orders = Order::with(['items.product.vendor.user', 'client', 'address'])
            ->where('status', '!=', OrderStatus::PENDING->value)
            ->latest()
            ->get();

        return view('orders.index', [
            'orders' => $orders,
            'pageTitle' => 'All Orders',
        ]);
    }

    /**
     * Fetch one order only if it contains the current vendor's products.
     */
    private function findVendorOrder($id): Order
    {
        $vendor = auth()->user()->vendorProfile;

        return $this->vendorOrdersQuery($vendor->getKey())->findOrFail($id);
    }

    /**
     * Base query used for vendor-owned orders and vendor-owned order items.
     */
    private function vendorOrdersQuery(int $vendorId)
    {
        return Order::whereHas('items.product', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })->with([
            'client',
            'address',
            'items' => function ($query) use ($vendorId) {
                $query->whereHas('product', function ($productQuery) use ($vendorId) {
                    $productQuery->where('vendor_id', $vendorId);
                })->with('product');
            },
        ]);
    }
}
