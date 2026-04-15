<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cart
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <p class="mb-4 text-green-600">{{ session('success') }}</p>
                    @endif

                    @if (session('error'))
                        <p class="mb-4 text-red-600">{{ session('error') }}</p>
                    @endif

                    @if($order && $order->items->count())
                        @foreach($order->items as $item)
                            <div class="border border-gray-200 rounded-lg p-4 mb-4">
                                <h4 class="font-semibold">{{ $item->product->name }}</h4>
                                <p>Price: {{ number_format($item->unit_price, 2) }}</p>
                                <p>Quantity: {{ $item->quantity }}</p>
                                <p>Subtotal: {{ number_format($item->subtotal, 2) }}</p>

                                <div class="flex gap-3 mt-3">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1">
                                        <button type="submit">Update</button>
                                    </form>

                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Remove</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        <h3 class="font-semibold mb-4">Total: {{ number_format($order->total_amount, 2) }}</h3>

                        <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf
                            <button type="submit">Checkout</button>
                        </form>
                    @else
                        <p>Your cart is empty.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
