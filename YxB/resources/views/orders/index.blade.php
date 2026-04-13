<h2>My Orders</h2>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@forelse($orders as $order)
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <h4>Order #{{ $order->id }}</h4>
        <p>Status: {{ $order->status }}</p>
        <p>Total: {{ $order->total_amount }}</p>

        <h5>Items:</h5>
        <ul>
            @foreach($order->items as $item)
                <li>
                    {{ $item->product->name }} 
                    (x{{ $item->quantity }}) - {{ $item->unit_price }}
                </li>
            @endforeach
        </ul>
    </div>
@empty
    <p>No orders yet</p>
@endforelse
