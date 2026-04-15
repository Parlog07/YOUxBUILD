<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    @if (session('success'))
                        <p class="text-green-600">{{ session('success') }}</p>
                    @endif

                    @if ($errors->any())
                        <div class="text-red-600">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div>
                        <h3 class="text-2xl font-semibold">{{ $product->name }}</h3>
                        <p class="text-lg font-medium mt-2">${{ number_format($product->price, 2) }}</p>
                    </div>

                    <div>
                        <p><strong>Category:</strong> {{ $product->category?->name ?? 'No category' }}</p>
                        <p><strong>Vendor:</strong> {{ $product->vendor?->user?->full_name ?? $product->vendor?->user?->email ?? 'Unknown vendor' }}</p>
                        <p><strong>Stock Quantity:</strong> {{ $product->stock_quantity }}</p>
                    </div>

                    <div>
                        <h4 class="font-semibold">Description</h4>
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>

                    <form method="POST" action="{{ route('cart.add') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="max-w-xs">
                            <label for="quantity" class="block font-medium text-sm text-gray-700">Quantity</label>
                            <input id="quantity" type="number" name="quantity" value="1" min="1" class="mt-1 block w-full border-gray-300 rounded-md">
                        </div>

                        <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md">
                            Add to Cart
                        </button>
                    </form>

                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">
                        Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
