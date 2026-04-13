<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Product
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="price" class="block font-medium text-sm text-gray-700">Price</label>
                            <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block font-medium text-sm text-gray-700">Category</label>
                            <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 rounded-md">
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock_quantity" class="block font-medium text-sm text-gray-700">Stock Quantity</label>
                            <input id="stock_quantity" name="stock_quantity" type="number" min="0" value="{{ old('stock_quantity', 0) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                            @error('stock_quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="availability_status" class="block font-medium text-sm text-gray-700">Availability Status</label>
                            <input id="availability_status" name="availability_status" type="text" value="{{ old('availability_status', 'in_stock') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                            @error('availability_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="product_type" class="block font-medium text-sm text-gray-700">Product Type</label>
                            <input id="product_type" name="product_type" type="text" value="{{ old('product_type', 'physical') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                            @error('product_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="technical_specs" class="block font-medium text-sm text-gray-700">Technical Specs</label>
                            <textarea id="technical_specs" name="technical_specs" rows="3" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('technical_specs') }}</textarea>
                            @error('technical_specs')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="image_url" class="block font-medium text-sm text-gray-700">Image URL</label>
                            <input id="image_url" name="image_url" type="url" value="{{ old('image_url') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                            @error('image_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md">
                                Save Product
                            </button>

                            <a href="{{ route('products.index') }}" class="text-gray-600 hover:underline">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
