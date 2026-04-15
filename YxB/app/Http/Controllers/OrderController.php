<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private const VENDOR_VISIBLE_STATUSES = ['confirmed', 'shipped', 'delivered', 'cancelled'];

    /**
     * Show the current user's pending cart.
     */
    public function index()
    {
        $order = Order::with('items.product')
            ->where('client_id', auth()->id())
            ->where('status', 'pending')
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
                'status' => 'pending'
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
            ->where('status', 'pending')
            ->first();

        return response()->json($order);
    }

    /**
     * Turn the pending cart into a confirmed order.
     */
    public function checkout()
    {
        $order = Order::where('client_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        if ($order->items->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        $order->status = 'confirmed';
        $order->ordered_at = now();
        $order->save();

        return redirect()->route('orders.index')
            ->with('success', 'Order confirmed');
    }

    /**
     * Recalculate the total amount from the current order items.
     */
    private function updateTotal($order)
    {
        $total = $order->items->sum(function ($item) {
            return $item->unit_price * $item->quantity;
        });

        $order->total_amount = $total;
        $order->save();
    }

    /**
     * Show the authenticated client's completed orders.
     */
    public function myOrders()
    {
        $orders = Order::with('items.product')
            ->where('client_id', auth()->id())
            ->where('status', '!=', 'pending')
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

        if ($order->status !== 'confirmed') {
            return redirect()
                ->route('vendor.orders')
                ->with('error', 'Only confirmed orders can be marked as shipped.');
        }

        $order->update(['status' => 'shipped']);

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

        if ($order->status !== 'shipped') {
            return redirect()
                ->route('vendor.orders')
                ->with('error', 'Only shipped orders can be marked as delivered.');
        }

        $order->update(['status' => 'delivered']);

        return redirect()
            ->route('vendor.orders')
            ->with('success', 'Order marked as delivered.');
    }

    /**
     * Show all non-cart orders in the admin area.
     */
    public function adminOrders()
    {
        $orders = Order::with('items.product.vendor.user')
            ->where('status', '!=', 'pending')
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
            'items' => function ($query) use ($vendorId) {
                $query->whereHas('product', function ($productQuery) use ($vendorId) {
                    $productQuery->where('vendor_id', $vendorId);
                })->with('product');
            },
        ]);
    }
}
