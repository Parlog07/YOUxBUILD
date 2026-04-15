<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Marketplace
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('products.index') }}" class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label for="search" class="block font-medium text-sm text-gray-700">Search</label>
                            <input id="search" name="search" type="text" placeholder="Search products..." value="{{ request('search') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label for="category" class="block font-medium text-sm text-gray-700">Category</label>
                            <select id="category" name="category" class="mt-1 block w-full border-gray-300 rounded-md">
                                <option value="">All categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end gap-3">
                            <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md">
                                Filter
                            </button>

                            <a href="{{ route('products.index') }}" class="text-gray-600 hover:underline">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($products->isEmpty())
                        <p>No products found</p>
                    @else
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($products as $product)
                                <div class="border rounded-lg p-5 space-y-3">
                                    <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                                    <p class="text-gray-600">{{ $product->category?->name ?? 'No category' }}</p>
                                    <p class="font-medium">${{ number_format($product->price, 2) }}</p>
                                    <p class="text-sm text-gray-600">
                                        Sold by: {{ $product->vendor?->user?->full_name ?? $product->vendor?->user?->email ?? 'Unknown vendor' }}
                                    </p>
                                    @auth
                                        <a href="{{ route('products.show', $product->id) }}" class="text-blue-600 hover:underline">
                                            View Details
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                                            Login to view details
                                        </a>
                                    @endauth
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
