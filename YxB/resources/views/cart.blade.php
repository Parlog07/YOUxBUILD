<x-app-layout>
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 py-16 relative z-10 w-full">
            
        @if (session('success'))
            <div class="mb-8 rounded-xl border border-premium-gold/30 bg-premium-gold/10 p-4 font-sans text-premium-goldLight font-semibold text-sm flex items-center gap-3 backdrop-blur-md">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-8 rounded-xl border border-red-500/30 bg-red-500/10 p-4 font-sans text-red-400 text-sm flex items-center gap-3 backdrop-blur-md">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-premium-card/60 backdrop-blur-xl shadow-glow-subtle border border-white/5 rounded-3xl overflow-hidden relative">
            
                        <div class="p-8 border-b border-white/5 bg-premium-black/50 relative overflow-hidden">
                                <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-premium-gold/50 to-transparent"></div>
                <h1 class="text-3xl font-heading font-extrabold uppercase tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-premium-goldLight to-premium-gold">Secure Cart</h1>
                <p class="text-sm font-sans text-premium-gray mt-2">Active procurement order</p>
            </div>

            <div class="p-8">
                @if($order && $order->items->count())
                    
                                        <div class="hidden md:grid grid-cols-12 gap-4 pb-4 font-heading font-bold text-xs uppercase tracking-widest text-premium-silver border-b border-white/5 mb-4">
                        <div class="col-span-6">Component Identity</div>
                        <div class="col-span-2 text-center">Unit Price</div>
                        <div class="col-span-2 text-center">Quantity</div>
                        <div class="col-span-2 text-right">Subtotal</div>
                    </div>

                                        <div class="divide-y divide-white/5">
                        @foreach($order->items as $item)
                            <div class="py-6 flex flex-col md:grid md:grid-cols-12 gap-4 items-center group">
                                
                                                                <div class="col-span-6 w-full flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-white/5 to-transparent border border-white/5 flex items-center justify-center shrink-0 group-hover:border-premium-silver/30 transition-colors">
                                        <svg class="w-6 h-6 text-premium-silver" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <a href="{{ route('products.show', $item->product_id) }}" class="font-heading font-bold text-white uppercase tracking-wider text-sm hover:text-premium-goldLight transition-colors line-clamp-2 leading-tight">
                                            {{ $item->product->name }}
                                        </a>
                                        <p class="text-xs font-sans text-premium-gray mt-1 line-clamp-1 flex items-center gap-2">
                                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-premium-silver/50"></span>
                                            {{ $item->product->category?->name ?? 'Category' }}
                                        </p>
                                    </div>
                                </div>

                                                                <div class="col-span-2 w-full md:text-center font-sans text-premium-silver mt-2 md:mt-0">
                                    <span class="md:hidden font-heading text-xs uppercase text-premium-gray mr-2">Price:</span>
                                    ${{ number_format($item->unit_price, 2) }}
                                </div>

                                                                <div class="col-span-2 w-full flex items-center justify-between md:justify-center mt-2 md:mt-0">
                                    <span class="md:hidden font-heading text-xs uppercase text-premium-gray mr-2">Qty:</span>
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center bg-premium-black/50 border border-white/10 rounded-full overflow-hidden focus-within:border-premium-gold/50 transition-colors">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity }}"
                                               class="w-14 bg-transparent text-center text-sm font-sans text-white border-none focus:ring-0 appearance-none py-1.5">
                                        <button type="submit" class="px-3 hover:text-premium-gold text-premium-gray transition-colors border-l border-white/10" title="Update Quantity">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        </button>
                                    </form>
                                </div>

                                                                <div class="col-span-2 w-full flex items-center justify-between md:justify-end mt-4 md:mt-0 gap-4">
                                    <span class="font-heading font-bold text-white tracking-tight">
                                        ${{ number_format($item->subtotal, 2) }}
                                    </span>
                                    
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 bg-red-500/10 hover:bg-red-500/20 p-2 rounded-full transition-colors border border-red-500/20" title="Remove Component">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                                        <div class="mt-8 pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-8">
                        <a href="{{ route('products.index') }}" class="text-premium-gray hover:text-white font-sans font-medium text-sm flex items-center transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Continue Shopping
                        </a>

                        <div class="flex flex-col items-center md:items-end w-full md:w-auto bg-premium-black/30 p-6 rounded-2xl border border-white/5">
                            <div class="flex items-center gap-4 mb-6 w-full justify-between md:justify-end">
                                <span class="font-heading font-bold text-premium-gray uppercase tracking-widest text-sm">Total Estimate:</span>
                                <span class="font-heading font-extrabold text-3xl text-premium-goldLight tracking-tight drop-shadow-lg">
                                    ${{ number_format($order->total_amount, 2) }}
                                </span>
                            </div>

                            <a href="{{ route('payment.page') }}" class="w-full px-8 py-4 bg-gradient-to-r from-premium-gold to-yellow-600 text-premium-black hover:scale-[1.02] font-heading font-bold text-sm uppercase tracking-widest rounded-xl transition-all flex justify-center items-center gap-3 shadow-glow-gold">
                                Proceed to Payment
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>

                @else
                                        <div class="py-24 flex flex-col items-center justify-center text-center">
                        <div class="w-24 h-24 rounded-full bg-white/5 flex items-center justify-center mb-6 border border-white/10 shadow-glow-subtle">
                            <svg class="w-10 h-10 text-premium-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="font-heading font-bold text-2xl text-white uppercase tracking-widest mb-3">No Data Found</h3>
                        <p class="text-premium-gray font-sans mb-10 max-w-sm leading-relaxed">Your procurement list is empty. Proceed to the central database to gather required components.</p>
                        <a href="{{ route('products.index') }}" class="px-8 py-4 rounded-full bg-white/10 border border-white/10 text-white font-heading font-bold text-xs uppercase tracking-widest hover:bg-premium-gold hover:text-black hover:border-transparent transition-all shadow-glow-subtle">
                            Enter Database
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
