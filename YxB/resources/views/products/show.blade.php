<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-16 relative z-10 w-full">
        
        <a href="{{ route('products.index') }}" class="inline-flex items-center text-premium-gray hover:text-white font-sans font-medium text-sm transition-colors mb-8 group">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Return to Directory
        </a>

        @if (session('success'))
            <div class="mb-8 rounded-xl border border-premium-gold/30 bg-premium-gold/10 p-4 font-sans text-premium-goldLight font-semibold text-sm flex items-center gap-3 backdrop-blur-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-8 rounded-xl border border-red-500/30 bg-red-500/10 p-4 font-sans text-red-400 text-sm backdrop-blur-md">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div> 
        @endif

                <div class="bg-premium-card/80 backdrop-blur-xl shadow-glow-subtle border border-white/5 rounded-3xl flex flex-col lg:flex-row overflow-hidden relative">
            
                        <div class="absolute top-6 left-6 z-20">
                <span class="bg-white/10 backdrop-blur-md border border-white/10 text-premium-silver font-heading text-xs font-bold px-4 py-2 uppercase rounded-full shadow-lg">
                    {{ $product->category?->name ?? 'UNCATEGORIZED' }}
                </span>
            </div>

                        <div class="w-full lg:w-1/2 bg-gradient-to-br from-white/5 to-transparent flex items-center justify-center p-12 border-b lg:border-b-0 lg:border-r border-white/5 relative group">
                <div class="absolute inset-0 bg-premium-gold/5 blur-3xl opacity-50 group-hover:opacity-100 transition-opacity duration-700"></div>
                <img src="{{ $product->image_url ?? 'https://images.unsplash.com/photo-1587202376732-8309058b74a4?q=80&w=800&auto=format&fit=crop' }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-contain max-h-[500px] relative z-10 brightness-90 drop-shadow-2xl hover:scale-105 transition-transform duration-700">
            </div>

                        <div class="w-full lg:w-1/2 p-8 lg:p-14 flex flex-col relative z-20">
                
                <p class="text-xs uppercase text-premium-silver font-heading font-semibold tracking-[0.2em] mb-3">Item #{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</p>
                <h1 class="text-3xl lg:text-5xl font-heading font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-premium-goldLight via-premium-gold to-yellow-600 mb-6 leading-tight">
                    {{ $product->name }}
                </h1>
                
                <div class="text-white font-heading font-bold text-4xl tracking-tight mb-10 flex items-center gap-3">
                    ${{ number_format($product->price, 2) }}
                    @if($product->stock_quantity > 0)
                        <span class="text-xs font-sans font-medium px-2 py-1 bg-green-500/10 text-green-400 rounded-lg border border-green-500/20">In Stock</span>
                    @else
                        <span class="text-xs font-sans font-medium px-2 py-1 bg-red-500/10 text-red-400 rounded-lg border border-red-500/20">Sold Out</span>
                    @endif
                </div>

                                <div class="mb-12 flex-grow">
                    <h3 class="font-heading font-bold text-sm text-premium-silver uppercase tracking-widest border-b border-white/10 pb-3 mb-5">Component Data</h3>
                    <div class="space-y-6 font-sans text-premium-gray leading-relaxed text-sm">
                        <p class="text-white/80 text-base">{{ $product->description }}</p>
                        
                        @if($product->technical_specs)
                            <div class="bg-premium-black/50 border border-white/5 p-5 rounded-2xl font-mono text-xs text-premium-silver shadow-inner block">
                                {!! nl2br(e($product->technical_specs)) !!}
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-6 pt-4 border-t border-white/5">
                            <div>
                                <span class="block text-xs uppercase tracking-widest font-heading font-bold text-premium-gray mb-1">Availability</span>
                                <span class="text-white font-medium">{{ $product->stock_quantity }} Units</span>
                            </div>
                            <div>
                                <span class="block text-xs uppercase tracking-widest font-heading font-bold text-premium-gray mb-1">Source Vendor</span>
                                <span class="text-premium-goldLight font-medium">{{ $product->vendor?->user?->full_name ?? 'YOUXBUILD Direct' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                                <div class="pt-8 border-t border-white/10 mt-auto">
                    @auth
                        @if(auth()->user()->role === 'client')
                            <form method="POST" action="{{ route('cart.add') }}" class="flex flex-col sm:flex-row gap-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="w-full sm:w-32 relative group">
                                    <label for="quantity" class="absolute -top-2.5 left-4 bg-premium-card px-1 text-[10px] uppercase tracking-widest text-premium-silver font-heading z-10">Qty</label>
                                    <input id="quantity" type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                                           class="w-full h-14 bg-premium-black/50 border border-white/10 text-white font-sans text-center rounded-xl focus:border-premium-gold focus:ring-1 focus:ring-premium-gold transition-colors relative z-0">
                                </div>

                                <button type="submit" @disabled($product->stock_quantity < 1) 
                                        class="flex-grow h-14 bg-gradient-to-r from-premium-gold to-yellow-600 hover:from-white hover:to-white text-premium-black font-heading font-bold uppercase tracking-widest text-sm rounded-xl transition-all duration-300 flex items-center justify-center gap-3 shadow-glow-gold disabled:opacity-50 disabled:grayscale">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    Procure Component
                                </button>
                            </form>
                        @else
                            <div class="text-center p-4 rounded-xl bg-premium-gold/10 border border-premium-gold/30 backdrop-blur-sm">
                                <p class="font-heading font-bold text-premium-goldLight text-sm tracking-wider uppercase">Vendor accounts cannot make purchases.</p>
                            </div>
                        @endif
                    @else
                        <div class="flex flex-col sm:flex-row gap-4 items-center">
                            <p class="text-sm font-heading font-bold text-premium-gray uppercase tracking-widest flex-grow text-center sm:text-left">Authentication Required</p>
                            <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 h-12 flex items-center justify-center border border-premium-gold/50 text-premium-goldLight hover:bg-premium-gold hover:text-premium-black rounded-full font-heading font-bold text-xs uppercase tracking-widest transition-all shadow-glow-gold">
                                Secure Login
                            </a>
                        </div>
                    @endauth
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
