<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Categories
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <p class="mb-4 text-green-600">{{ session('success') }}</p>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 text-red-600">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('categories.store') }}" method="POST" class="flex gap-3 mb-6">
                        @csrf
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Category name"
                            class="flex-1 border-gray-300 rounded-md"
                        >
                        <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md">
                            Add Category
                        </button>
                    </form>

                    @if ($categories->isEmpty())
                        <p>No categories yet.</p>
                    @else
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3">Name</th>
                                    <th class="text-left py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr class="border-b">
                                        <td class="py-3">{{ $category->name }}</td>
                                        <td class="py-3">
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">
                                                    Delete
                                                </button>
                                            </form>
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
