<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
        
                <header class="mb-16 text-center flex flex-col items-center">
            <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-premium-silver to-white tracking-tight mb-4 inline-block">
                Architected Builds.
            </h1>
            <p class="text-premium-gray max-w-2xl font-medium text-lg md:text-xl leading-relaxed">
                Elite pre-configured workstations and gaming rigs from top tier vendors.
            </p>
        </header>

        @if ($products->isEmpty())
            <div class="py-24 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center mb-6 border border-white/10 shadow-glow-subtle">
                    <svg class="w-8 h-8 text-premium-gray" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="font-heading font-bold text-xl text-white uppercase tracking-widest mb-3">No Prebuilts Available</h3>
                <p class="text-premium-gray font-sans max-w-sm">The current architecture list is empty. Please check back later for new hardware drops.</p>
            </div>
        @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($products as $product)
                                        <article class="relative flex flex-col bg-premium-card rounded-3xl border border-white/5 overflow-hidden group hover:border-premium-gold/40 hover:-translate-y-2 transition-all duration-500 hover:shadow-glow-gold">
                        
                                                <div class="w-full aspect-[4/3] bg-gradient-to-b from-white/5 to-transparent relative flex items-center justify-center p-8 overflow-hidden rounded-t-3xl">
                            <div class="absolute inset-0 bg-premium-gold/10 blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <img src="{{ $product->image_url ?? 'https://images.unsplash.com/photo-1587202376732-8309058b74a4?q=80&w=400&auto=format&fit=crop' }}" 
                                 alt="{{ $product->name }}" 
                                 class="relative z-10 w-full h-full object-contain group-hover:scale-110 transition-transform duration-700 drop-shadow-2xl brightness-90 group-hover:brightness-110">
                        </div>

                                                <div class="p-6 flex flex-col flex-grow relative z-20 bg-premium-card backdrop-blur-sm rounded-b-3xl">
                                                        <div class="flex items-center justify-between mb-3">
                                <span class="inline-block px-3 py-1 bg-white/5 border border-white/10 rounded-full text-premium-silver text-[10px] font-semibold uppercase tracking-wider w-max">
                                    {{ $product->category?->name ?? 'SYSTEM ARCHITECTURE' }}
                                </span>
                                <span class="text-[9px] text-premium-goldLight font-bold uppercase tracking-widest">Prebuilt</span>
                            </div>
                            
                            <h2 class="font-heading font-bold text-white text-lg leading-tight group-hover:text-premium-gold transition-colors mb-2 line-clamp-1 uppercase">
                                {{ $product->name }}
                            </h2>
                            
                            <p class="text-xs text-premium-gray font-sans mb-6 line-clamp-1">
                                Vendor: <span class="text-white">{{ $product->vendor?->user?->full_name ?? 'Unknown Entity' }}</span>
                            </p>

                            <div class="mt-auto flex items-center justify-between border-t border-white/5 pt-4">
                                <span class="font-heading font-bold text-2xl text-premium-goldLight tracking-tight">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                                
                                @auth
                                    <a href="{{ route('products.show', $product->id) }}" class="px-5 py-2.5 rounded-xl bg-white/10 border border-white/10 text-white text-xs font-heading font-bold uppercase tracking-widest hover:bg-premium-gold hover:text-black hover:border-transparent transition-all duration-300">
                                        View Data
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-premium-gray text-xs font-heading font-bold uppercase tracking-widest hover:text-white transition-all">
                                        Login
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
