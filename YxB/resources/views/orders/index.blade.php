<h2>My Orders</h2>

@forelse($orders as $order)
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <h4>Order #{{ $order->id }}</h4>
        <p>Status: {{ $order->status }}</p>
        <p>Total: {{ $order->total_price }}</p>

        <h5>Items:</h5>
        <ul>
            @foreach($order->items as $item)
                <li>
                    {{ $item->product->name }} 
                    (x{{ $item->quantity }}) - {{ $item->price }}
                </li>
            @endforeach
        </ul>
    </div>
@empty
    <p>No orders yet</p>
@endforelse
<h2>Vendor Orders</h2>

@forelse($orders as $order)
    <div style="border:1px solid #ccc; margin-bottom:10px; padding:10px;">
        <h4>Order #{{ $order->id }}</h4>

        <ul>
            @foreach($order->items as $item)
                @if($item->product->vendor_profile_id == auth()->user()->vendorProfile->id)
                    <li>
                        {{ $item->product->name }} 
                        x{{ $item->quantity }}
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@empty
    <p>No orders yet</p>
@endforelse