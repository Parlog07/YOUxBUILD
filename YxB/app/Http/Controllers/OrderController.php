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

        $user = auth()->user();
        $order = $this->getOrCreateCart($user);

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

        return response()->json(['message' => 'Product added to cart']);
    }
    public function updateItem(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item = OrderItem::findOrFail($itemId);

        $this->authorize('update', $item->order);

        $item->quantity = $request->quantity;
        $item->save();

        $this->updateTotal($item->order);

        return response()->json(['message' => 'Item updated']);
    }
    public function removeItem($itemId)
    {
        $item = OrderItem::findOrFail($itemId);

        $this->authorize('update', $item->order);

        $order = $item->order;
        $item->delete();

        $this->updateTotal($order);

        return response()->json(['message' => 'Item removed']);
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
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $order->status = 'confirmed';
        $order->save();

        return response()->json(['message' => 'Order confirmed']);
    }
    private function updateTotal($order)
    {
        $total = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $order->total_price = $total;
        $order->save();
    }
}
