<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
        
        <!-- Premium Header Area -->
        <header class="mb-16 text-center flex flex-col items-center">
            <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-premium-silver to-white tracking-tight mb-4 inline-block">
                Precision Catalog.
            </h1>
            <p class="text-premium-gray max-w-2xl font-medium text-lg md:text-xl leading-relaxed">
                Discover next-gen hardware across all major categories.
            </p>
        </header>

        <!-- Search & Filter Bar -->
        <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row justify-between items-center bg-premium-card/60 backdrop-blur-xl border border-white/5 p-3 rounded-2xl mb-12 shadow-glow-subtle gap-4">
            
            <!-- Sleek Search Input -->
            <div class="w-full md:w-96 relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-premium-gray group-focus-within:text-premium-gold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search components..." 
                       class="w-full bg-premium-black/50 border border-white/10 text-white placeholder-premium-gray font-sans pl-12 pr-4 py-3 rounded-xl focus:outline-none focus:ring-1 focus:ring-premium-gold/50 focus:border-premium-gold/50 transition-all shadow-inner">
            </div>

            <div class="flex items-center gap-4 w-full md:w-auto">
                <!-- Elegant Dropdown -->
                <div class="w-full md:w-64 relative">
                    <select name="category" class="w-full bg-premium-black/50 border border-white/10 text-white font-medium text-sm py-3 px-4 pr-10 focus:outline-none focus:border-premium-gold/50 appearance-none rounded-xl cursor-pointer transition-colors shadow-inner">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <!-- Custom minimal Arrow -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-premium-gray">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-6 py-3 bg-premium-gold text-premium-black font-heading font-bold text-xs uppercase tracking-widest rounded-xl hover:bg-white hover:text-black hover:scale-105 transition-all duration-300 shadow-glow-gold">
                        Filter
                    </button>
                    @if(request('search') || request('category'))
                        <a href="{{ route('products.index') }}" class="px-6 py-3 bg-white/5 border border-white/10 text-white font-heading font-bold text-xs uppercase tracking-widest rounded-xl hover:bg-white/10 transition-all duration-300 flex items-center">
                            Reset
                        </a>
                    @endif
                </div>
            </div>

        </form>

        <!-- Modern Grid Layout -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
            @forelse ($products as $product)
                <!-- Premium Product Card -->
                <article class="relative flex flex-col bg-premium-card rounded-3xl border border-white/5 overflow-hidden group hover:border-premium-gold/40 hover:-translate-y-2 transition-all duration-500 hover:shadow-glow-gold">
                    
                    <!-- Image Area -->
                    <div class="w-full aspect-[4/3] bg-gradient-to-b from-white/5 to-transparent relative flex items-center justify-center p-8 overflow-hidden rounded-t-3xl">
                        <div class="absolute inset-0 bg-premium-gold/10 blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <img src="https://images.unsplash.com/photo-1591488320449-011701bb6704?q=80&w=400&auto=format&fit=crop" 
                             alt="{{ $product->name }}" 
                             class="relative z-10 w-full h-full object-contain group-hover:scale-110 transition-transform duration-700 drop-shadow-2xl brightness-90 group-hover:brightness-110">
                    </div>

                    <!-- Info Area -->
                    <div class="p-6 flex flex-col flex-grow relative z-20 bg-premium-card backdrop-blur-sm rounded-b-3xl">
                        <!-- Badge -->
                        <span class="inline-block px-3 py-1 bg-white/5 border border-white/10 rounded-full text-premium-silver text-[10px] font-semibold uppercase tracking-wider mb-3 w-max">
                            {{ $product->category?->name ?? 'Uncategorized' }}
                        </span>
                        
                        <h2 class="font-heading font-bold text-white text-lg leading-tight group-hover:text-premium-gold transition-colors mb-2 line-clamp-1">
                            {{ $product->name }}
                        </h2>
                        
                        <p class="text-sm text-premium-gray line-clamp-2 mb-6">
                            {{ $product->description }}
                        </p>

                        <div class="mt-auto flex items-center justify-between">
                            <span class="font-heading font-bold text-2xl text-premium-goldLight tracking-tight">
                                ${{ number_format($product->price, 2) }}
                            </span>
                            
                            <a href="{{ route('products.show', $product->id) }}" class="px-5 py-2.5 rounded-full bg-white/10 border border-white/10 text-white text-sm font-sans font-medium hover:bg-premium-gold hover:text-black hover:border-transparent transition-all duration-300">
                                View Data
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-20 flex flex-col items-center justify-center">
                    <div class="w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center mb-4 border border-white/10">
                        <svg class="w-8 h-8 text-premium-gray" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <p class="text-premium-silver font-heading font-bold text-xl uppercase tracking-widest">No Components Found</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
