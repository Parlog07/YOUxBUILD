<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $pageTitle ?? 'Orders' }}
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

                    @forelse($orders as $order)
                        <div class="border border-gray-200 rounded-lg p-4 mb-4">
                            <h4 class="font-semibold">Order #{{ $order->id }}</h4>
                            <p>Status: {{ ucfirst($order->status) }}</p>
                            <p>Total: {{ number_format($order->total_amount, 2) }}</p>

                            <h5 class="mt-3 font-medium">Items</h5>
                            <ul class="list-disc list-inside">
                                @foreach($order->items as $item)
                                    <li>
                                        {{ $item->product->name }}
                                        (x{{ $item->quantity }}) - {{ number_format($item->unit_price, 2) }}
                                    </li>
                                @endforeach
                            </ul>

                            @if (request()->routeIs('vendor.orders'))
                                <div class="flex gap-3 mt-4">
                                    @if ($order->status === 'confirmed')
                                        <form method="POST" action="{{ route('vendor.orders.ship', $order->id) }}">
                                            @csrf
                                            <button type="submit">Mark as Shipped</button>
                                        </form>
                                    @endif

                                    @if ($order->status === 'shipped')
                                        <form method="POST" action="{{ route('vendor.orders.deliver', $order->id) }}">
                                            @csrf
                                            <button type="submit">Mark as Delivered</button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @empty
                        <p>No orders yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
