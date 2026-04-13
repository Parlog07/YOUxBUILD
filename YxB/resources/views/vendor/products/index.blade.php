<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Products
            </h2>

            <a href="{{ route('products.create') }}" class="text-blue-600 hover:underline">
                Add Product
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <p class="mb-4 text-green-600">{{ session('success') }}</p>
                    @endif

                    @if ($products->isEmpty())
                        <p>You have not added any products yet.</p>
                    @else
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-3 text-left">Name</th>
                                    <th class="py-3 text-left">Category</th>
                                    <th class="py-3 text-left">Price</th>
                                    <th class="py-3 text-left">Stock</th>
                                    <th class="py-3 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr class="border-b">
                                        <td class="py-3">{{ $product->name }}</td>
                                        <td class="py-3">{{ $product->category?->name ?? 'No category' }}</td>
                                        <td class="py-3">{{ number_format($product->price, 2) }}</td>
                                        <td class="py-3">{{ $product->stock_quantity }}</td>
                                        <td class="py-3">
                                            <div class="flex gap-3">
                                                <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:underline">
                                                    Edit
                                                </a>

                                                <form action="{{ route('products.destroy', $product) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
