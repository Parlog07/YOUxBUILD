<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    private function getOrCreateCart($user)
    {
        return Order::firstOrCreate(
            [
                'user_id' => $user->id,
                'status' => 'pending'
            ],
            [
                'total_price' => 0
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
            $item->save();
        } else {
            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price
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

        if ($item->order->user_id !== auth()->id()) {
            abort(403);
        }

        $item->quantity = $request->quantity;
        $item->save();

        $this->updateTotal($item->order);

        return redirect()->back()->with('success', 'Item updated');
    }
    public function removeItem($itemId)
    {
        $item = OrderItem::findOrFail($itemId);

        if ($item->order->user_id !== auth()->id()) {
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
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        return response()->json($order);
    }
    public function checkout()
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        if ($order->items->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        $order->status = 'confirmed';
        $order->save();

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order confirmed');
    }
    private function updateTotal($order)
    {
        $total = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $order->total_price = $total;
        $order->save();
    }
    public function myOrders()
    {
        $orders = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->where('status', '!=', 'pending') // exclude cart
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }
    
}
