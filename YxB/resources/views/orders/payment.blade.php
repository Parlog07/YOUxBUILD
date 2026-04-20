<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payment
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Order Summary</h3>

                    <div class="space-y-4 mb-6">
                        @foreach ($order->items as $item)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <p class="font-semibold">{{ $item->product->name }}</p>
                                <p>Quantity: {{ $item->quantity }}</p>
                                <p>Unit Price: {{ number_format($item->unit_price, 2) }}</p>
                                <p>Subtotal: {{ number_format($item->subtotal, 2) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <p class="text-lg font-semibold mb-6">
                        Total: {{ number_format($order->total_amount, 2) }}
                    </p>

                    <form method="POST" action="{{ route('payment.confirm') }}">
                        @csrf
                        <button type="submit">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
