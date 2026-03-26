@if($order && $order->items->count())
    @foreach($order->items as $item)
        <div>
            <h4>{{ $item->product->name }}</h4>
            <p>Price: {{ $item->price }}</p>
            <p>Quantity: {{ $item->quantity }}</p>

            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                @csrf
                <input type="number" name="quantity" value="{{ $item->quantity }}">
                <button type="submit">Update</button>
            </form>

            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Remove</button>
            </form>
        </div>
    @endforeach

    <h3>Total: {{ $order->total_price }}</h3>

    <form action="{{ route('cart.checkout') }}" method="POST">
        @csrf
        <button type="submit">Checkout</button>
    </form>
@else
    <p>Your cart is empty</p>
@endif