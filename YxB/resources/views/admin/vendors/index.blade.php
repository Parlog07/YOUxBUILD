<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vendor Requests
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($vendors->isEmpty())
                        <p>No vendor requests yet.</p>
                    @else
                        @if (session('success'))
                            <p class="mb-4 text-green-600">{{ session('success') }}</p>
                        @endif

                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3">User ID</th>
                                    <th class="text-left py-3">Email</th>
                                    <th class="text-left py-3">Status</th>
                                    <th class="text-left py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vendors as $vendor)
                                    <tr class="border-b">
                                        <td class="py-3">{{ $vendor->vendor_id }}</td>
                                        <td class="py-3">{{ $vendor->user?->email ?? 'N/A' }}</td>
                                        <td class="py-3">{{ ucfirst($vendor->status) }}</td>
                                        <td class="py-3">
                                            @if ($vendor->status === 'pending')
                                                <div class="flex gap-2">
                                                    <form action="{{ route('admin.vendors.approve', $vendor->vendor_id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit">Approve</button>
                                                    </form>

                                                    <form action="{{ route('admin.vendors.reject', $vendor->vendor_id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit">Reject</button>
                                                    </form>
                                                </div>
                                            @else
                                                <span>No actions</span>
                                            @endif
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
