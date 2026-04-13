<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $order = Order::with('items.product')
            ->where('client_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        return view('cart', compact('order'));
    }

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
    public function viewCart()
    {
        $order = Order::with('items.product')
            ->where('client_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        return response()->json($order);
    }

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

    private function updateTotal($order)
    {
        $total = $order->items->sum(function ($item) {
            return $item->unit_price * $item->quantity;
        });

        $order->total_amount = $total;
        $order->save();
    }

    public function myOrders()
    {
        $orders = Order::with('items.product')
            ->where('client_id', auth()->id())
            ->where('status', '!=', 'pending')
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }
    public function vendorOrders()
    {
        $vendor = auth()->user()->vendorProfile;

        $orders = Order::whereHas('items.product', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->getKey());
        })
        ->with(['items.product'])
        ->where('status', 'confirmed')
        ->latest()
        ->get();

        return view('orders.index', compact('orders'));
    }

    public function adminOrders()
    {
        $orders = Order::with('items.product.vendor.user')
            ->where('status', 'confirmed')
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }
}
