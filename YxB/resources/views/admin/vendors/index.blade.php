<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-extrabold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-premium-goldLight to-premium-gold uppercase tracking-widest leading-tight">
            Vendor Administration
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12 relative z-10 w-full">

        <div class="bg-premium-card/60 backdrop-blur-xl shadow-glow-subtle border border-white/5 rounded-3xl overflow-hidden relative">
            <div class="p-8 border-b border-white/5 bg-premium-black/50 relative overflow-hidden">
                <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-premium-silver/50 to-transparent"></div>
                <h1 class="text-xl font-heading font-bold uppercase tracking-widest text-white">Application Review</h1>
                <p class="text-sm font-sans text-premium-gray mt-2">Manage incoming vendor requests and authorization logs.</p>
            </div>

            <div class="p-8">
                @if (session('success'))
                    <div class="mb-8 rounded-xl border border-premium-gold/30 bg-premium-gold/10 p-4 font-sans text-premium-goldLight font-semibold text-sm flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if ($vendors->isEmpty())
                    <div class="py-24 flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mb-6 border border-white/10 shadow-glow-subtle">
                            <svg class="w-8 h-8 text-premium-gray" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="font-heading font-bold text-xl text-white uppercase tracking-widest mb-3">No Pending Profiles</h3>
                        <p class="text-premium-gray font-sans max-w-sm leading-relaxed">There are currently no active vendor applications awaiting administrator review.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left font-sans text-sm">
                            <thead>
                                <tr class="text-premium-silver font-heading font-bold text-xs uppercase tracking-widest border-b border-white/10">
                                    <th class="py-4 pl-4">Network ID</th>
                                    <th class="py-4">User</th>
                                    <th class="py-4">Contact Gateway</th>
                                    <th class="py-4">Store Name</th>
                                    <th class="py-4">Business Address</th>
                                    <th class="py-4">Store Description</th>
                                    <th class="py-4">Clearance Status</th>
                                    <th class="py-4 text-right pr-4">Action Protocols</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach ($vendors as $vendor)
                                    <tr class="hover:bg-white/5 transition-colors group">
                                        <td class="py-4 pl-4 font-mono text-premium-gray group-hover:text-white transition-colors">
                                            #{{ str_pad($vendor->vendor_id, 4, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="py-4 font-medium text-white">
                                            <div>{{ $vendor->user?->full_name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="py-4 font-medium text-white">
                                            {{ $vendor->user?->email ?? 'N/A' }}
                                        </td>
                                        <td class="py-4 text-premium-silver">
                                            {{ $vendor->store_name ?: 'N/A' }}
                                        </td>
                                        <td class="py-4 text-premium-silver">
                                            {{ $vendor->business_address ?: 'N/A' }}
                                        </td>
                                        <td class="py-4 text-premium-silver max-w-xs">
                                            <p class="line-clamp-3">{{ $vendor->store_description ?: 'No description provided.' }}</p>
                                        </td>
                                        <td class="py-4">
                                            @if($vendor->status === 'approved')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-green-500/10 border border-green-500/20 text-xs font-medium text-green-400 font-heading uppercase tracking-wider">
                                                    Active
                                                </span>
                                            @elseif($vendor->status === 'rejected')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-red-500/10 border border-red-500/20 text-xs font-medium text-red-400 font-heading uppercase tracking-wider">
                                                    Denied
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-yellow-500/10 border border-yellow-500/20 text-xs font-medium text-yellow-500 font-heading uppercase tracking-wider">
                                                    Review
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 pr-4">
                                            <div class="bg-premium-black/30 border border-white/10 rounded-xl p-3 mb-3 text-left text-xs font-sans text-premium-silver space-y-1">
                                                <p><span class="text-premium-gray">Name:</span> {{ $vendor->user?->full_name ?? 'N/A' }}</p>
                                                <p><span class="text-premium-gray">Email:</span> {{ $vendor->user?->email ?? 'N/A' }}</p>
                                                <p><span class="text-premium-gray">Store:</span> {{ $vendor->store_name ?: 'N/A' }}</p>
                                                <p><span class="text-premium-gray">Address:</span> {{ $vendor->business_address ?: 'N/A' }}</p>
                                                @if ($vendor->store_description)
                                                    <p><span class="text-premium-gray">Description:</span> {{ $vendor->store_description }}</p>
                                                @endif
                                            </div>
                                            <div class="flex items-center justify-end gap-3">
                                                @if ($vendor->status === 'pending')
                                                    <form action="{{ route('admin.vendors.approve', $vendor->vendor_id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" title="Authorize Vendor" class="text-green-500 bg-green-500/10 hover:bg-green-500 hover:text-black p-2 rounded-lg transition-all border border-green-500/20">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.vendors.reject', $vendor->vendor_id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" title="Deny Authorization" class="text-red-500 bg-red-500/10 hover:bg-red-500 hover:text-black p-2 rounded-lg transition-all border border-red-500/20">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-premium-gray font-mono text-xs">NO ACTIONS</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
