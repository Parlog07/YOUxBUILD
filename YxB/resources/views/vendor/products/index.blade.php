<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12 relative z-10 w-full">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
            <h2 class="font-heading font-extrabold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-premium-goldLight to-premium-gold uppercase tracking-widest leading-tight">
                My Component Supply
            </h2>

            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('vendor.products.prebuilt.create') }}" class="px-6 py-3 bg-gradient-to-r from-premium-gold to-yellow-600 text-premium-black hover:scale-[1.02] font-heading font-bold text-xs uppercase tracking-widest rounded-xl transition-all shadow-glow-gold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"></path></svg>
                    Launch Prebuilt PC
                </a>

                <a href="{{ route('vendor.products.create') }}" class="px-6 py-3 bg-white/5 border border-white/10 text-white hover:bg-premium-gold hover:text-black hover:border-transparent font-heading font-bold text-xs uppercase tracking-widest rounded-xl transition-all shadow-glow-subtle hover:shadow-glow-gold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Deploy New Hardware
                </a>
            </div>
        </div>
        
        <div class="bg-premium-card/60 backdrop-blur-xl shadow-glow-subtle border border-white/5 rounded-3xl overflow-hidden relative">
            <div class="p-8 border-b border-white/5 bg-premium-black/50 relative overflow-hidden">
                <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-premium-silver/50 to-transparent"></div>
                <h1 class="text-xl font-heading font-bold uppercase tracking-widest text-white">Inventory Control</h1>
                <p class="text-sm font-sans text-premium-gray mt-2">Manage your current active components on the marketplace network.</p>
            </div>

            <div class="p-8">
                @if (session('success'))
                    <div class="mb-8 rounded-xl border border-premium-gold/30 bg-premium-gold/10 p-4 font-sans text-premium-goldLight font-semibold text-sm flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if ($products->isEmpty())
                    <div class="py-24 flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mb-6 border border-white/10 shadow-glow-subtle">
                            <svg class="w-8 h-8 text-premium-gray" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h3 class="font-heading font-bold text-xl text-white uppercase tracking-widest mb-3">No Active Inventory</h3>
                        <p class="text-premium-gray font-sans max-w-sm leading-relaxed mb-8">You have not deployed any hardware components to the global marketplace database.</p>
                        
                        <div class="flex flex-wrap items-center justify-center gap-4">
                            <a href="{{ route('vendor.products.prebuilt.create') }}" class="px-8 py-4 bg-gradient-to-r from-premium-gold to-yellow-600 text-premium-black font-heading font-bold text-xs uppercase tracking-widest rounded-xl hover:scale-[1.02] transition-all shadow-glow-gold flex items-center gap-2">
                                Launch First Prebuilt PC
                            </a>

                            <a href="{{ route('vendor.products.create') }}" class="px-8 py-4 bg-white/5 border border-white/10 text-white font-heading font-bold text-xs uppercase tracking-widest rounded-xl hover:bg-white hover:text-black transition-all flex items-center gap-2">
                                Deploy First Component
                            </a>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left font-sans text-sm">
                            <thead>
                                <tr class="text-premium-silver font-heading font-bold text-xs uppercase tracking-widest border-b border-white/10">
                                    <th class="py-4 pl-4">Definition</th>
                                    <th class="py-4">Taxonomy</th>
                                    <th class="py-4 text-center">Value</th>
                                    <th class="py-4 text-center">Reserves</th>
                                    <th class="py-4 text-right pr-4">Protocols</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach ($products as $product)
                                    <tr class="hover:bg-white/5 transition-colors group">
                                        <td class="py-4 pl-4">
                                            <span class="font-heading font-bold text-white uppercase tracking-wider text-sm">{{ $product->name }}</span>
                                        </td>
                                        <td class="py-4">
                                            <span class="inline-block px-3 py-1 bg-white/5 border border-white/10 rounded-full text-premium-silver text-[10px] font-semibold uppercase tracking-wider">
                                                {{ $product->category?->name ?? 'Uncategorized' }}
                                            </span>
                                        </td>
                                        <td class="py-4 text-center font-mono text-premium-goldLight">
                                            ${{ number_format($product->price, 2) }}
                                        </td>
                                        <td class="py-4 text-center">
                                            @if($product->stock_quantity > 0)
                                                <span class="text-white">{{ $product->stock_quantity }}</span>
                                            @else
                                                <span class="text-red-400 font-bold uppercase text-xs">DEPLETED</span>
                                            @endif
                                        </td>
                                        <td class="py-4 pr-4">
                                            <div class="flex items-center justify-end gap-3 flex-nowrap">
                                                <a href="{{ route('vendor.products.edit', $product) }}" title="Modify Data" class="text-premium-silver bg-white/5 hover:bg-white hover:text-black p-2 rounded-lg transition-all border border-white/10">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </a>

                                                <form action="{{ route('vendor.products.destroy', $product) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Purge Record" class="text-red-500 bg-red-500/10 hover:bg-red-500 hover:text-black p-2 rounded-lg transition-all border border-red-500/20">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
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
