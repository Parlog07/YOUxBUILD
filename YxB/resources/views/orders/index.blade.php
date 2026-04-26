<x-app-layout>
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 py-12 relative z-10 w-full">
        <h2 class="font-heading font-extrabold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-premium-goldLight to-premium-gold uppercase tracking-widest leading-tight mb-8">
            {{ $pageTitle ?? 'Procurement Logs' }}
        </h2>
        <div class="bg-premium-card/60 backdrop-blur-xl shadow-glow-subtle border border-white/5 rounded-3xl overflow-hidden relative">
            <div class="p-8 border-b border-white/5 bg-premium-black/50 relative overflow-hidden">
                <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-premium-silver/50 to-transparent"></div>
                <h1 class="text-xl font-heading font-bold uppercase tracking-widest text-white">Order History</h1>
                <p class="text-sm font-sans text-premium-gray mt-2">Historical procurement network activity.</p>
            </div>

            <div class="p-8">
                @if (session('success'))
                    <div class="mb-8 rounded-xl border border-premium-gold/30 bg-premium-gold/10 p-4 font-sans text-premium-goldLight font-semibold text-sm flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-8 rounded-xl border border-red-500/30 bg-red-500/10 p-4 font-sans text-red-400 text-sm flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('error') }}
                    </div>
                @endif

                @forelse($orders as $order)
                    <div class="border border-white/10 rounded-2xl p-6 bg-white/5 mb-6 hover:border-premium-gold/30 transition-colors group">
                        
                        <div class="flex flex-col md:flex-row justify-between md:items-center border-b border-white/5 pb-4 mb-4 gap-4">
                            <div>
                                <h4 class="font-heading font-bold uppercase tracking-widest text-premium-silver text-xs mb-1">Authorization #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h4>
                                <p class="text-white font-mono text-xl tracking-tight">${{ number_format($order->total_amount, 2) }}</p>
                            </div>
                            
                            <!-- Badges -->
                            <div>
                                @if($order->status === 'confirmed')
                                    <span class="inline-block px-3 py-1 rounded-md bg-yellow-500/10 border border-yellow-500/20 text-xs font-medium text-yellow-500 font-heading uppercase tracking-wider">
                                        Confirmed
                                    </span>
                                @elseif($order->status === 'shipped')
                                    <span class="inline-block px-3 py-1 rounded-md bg-blue-500/10 border border-blue-500/20 text-xs font-medium text-blue-400 font-heading uppercase tracking-wider">
                                        Shipped
                                    </span>
                                @elseif($order->status === 'delivered')
                                    <span class="inline-block px-3 py-1 rounded-md bg-green-500/10 border border-green-500/20 text-xs font-medium text-green-400 font-heading uppercase tracking-wider">
                                        Delivered
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 rounded-md bg-white/5 border border-white/10 text-xs font-medium text-premium-gray font-heading uppercase tracking-wider">
                                        {{ $order->status }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-3">
                            @if (request()->routeIs('vendor.orders'))
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div class="bg-premium-black/30 rounded-xl p-4 border border-white/5">
                                        <h5 class="text-xs font-heading font-bold text-premium-gray uppercase tracking-widest mb-2">Client</h5>
                                        <p class="text-white font-sans font-medium">{{ $order->client?->full_name ?? 'Unknown client' }}</p>
                                        <p class="text-premium-silver text-sm">{{ $order->client?->email ?? 'No email available' }}</p>
                                    </div>
                                    <div class="bg-premium-black/30 rounded-xl p-4 border border-white/5">
                                        <h5 class="text-xs font-heading font-bold text-premium-gray uppercase tracking-widest mb-2">Delivery Address</h5>
                                        @if ($order->address)
                                            <p class="text-white font-sans">{{ $order->address->street }}</p>
                                            <p class="text-premium-silver text-sm">{{ $order->address->city }}, {{ $order->address->postal_code }}</p>
                                            <p class="text-premium-silver text-sm">{{ $order->address->country }}</p>
                                            <p class="text-premium-silver text-sm mt-2">Phone: {{ $order->address->phone_number }}</p>
                                            <p class="text-premium-silver text-sm">Email: {{ $order->address->email }}</p>
                                        @else
                                            <p class="text-premium-gray text-sm">No delivery address attached yet.</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <h5 class="text-xs font-heading font-bold text-premium-gray uppercase tracking-widest">Manifest Loadout</h5>
                            <div class="bg-premium-black/30 rounded-xl p-4 border border-white/5 divide-y divide-white/5 font-sans text-sm">
                                @foreach($order->items as $item)
                                    <div class="flex justify-between py-2 items-center group/item hover:text-white transition-colors text-premium-silver">
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs text-premium-gray border border-white/10 bg-white/5 rounded px-2">x{{ $item->quantity }}</span>
                                            <span class="font-medium group-hover/item:text-premium-goldLight transition-colors">{{ $item->product->name }}</span>
                                        </div>
                                        <span class="font-mono text-xs">${{ number_format($item->unit_price, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if (request()->routeIs('vendor.orders'))
                            <div class="flex flex-wrap gap-3 mt-6 border-t border-white/5 pt-6">
                                @if ($order->status === 'confirmed')
                                    <form method="POST" action="{{ route('vendor.orders.ship', $order->id) }}">
                                        @csrf
                                        <button type="submit" class="px-6 py-2.5 bg-blue-500/10 text-blue-400 border border-blue-500/30 hover:bg-blue-500 hover:text-white font-heading font-bold text-xs uppercase tracking-widest rounded-lg transition-all">
                                            Mark as Shipped
                                        </button>
                                    </form>
                                @endif

                                @if ($order->status === 'shipped')
                                    <form method="POST" action="{{ route('vendor.orders.deliver', $order->id) }}">
                                        @csrf
                                        <button type="submit" class="px-6 py-2.5 bg-green-500/10 text-green-400 border border-green-500/30 hover:bg-green-500 hover:text-white font-heading font-bold text-xs uppercase tracking-widest rounded-lg transition-all">
                                            Confirm Delivery
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="py-16 text-center">
                        <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mb-6 border border-white/10 mx-auto shadow-glow-subtle">
                            <svg class="w-8 h-8 text-premium-gray" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <p class="text-premium-silver font-heading font-bold text-xl uppercase tracking-widest">No Logs Found</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
