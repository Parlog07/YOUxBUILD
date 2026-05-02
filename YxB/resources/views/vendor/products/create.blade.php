<x-app-layout>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-12 relative z-10 w-full">
        
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
            <div>
                <h2 class="font-heading font-extrabold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-premium-goldLight to-premium-gold uppercase tracking-widest leading-tight">
                    Deploy Hardware Component
                </h2>
                <p class="text-premium-gray text-xs font-sans uppercase tracking-[0.2em] mt-2 opacity-70">Initialize new hardware parameters</p>
            </div>
            <a href="{{ route('vendor.products.index') }}" class="px-6 py-3 bg-white/5 border border-white/10 text-white hover:bg-white hover:text-black font-heading font-bold text-xs uppercase tracking-widest rounded-xl transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Abort Deployment
            </a>
        </div>

        <div class="bg-premium-card/60 backdrop-blur-xl shadow-glow-subtle border border-white/5 rounded-3xl overflow-hidden relative">
            
            <div class="p-8 border-b border-white/5 bg-premium-black/50 relative overflow-hidden">
                <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-premium-gold/50 to-transparent"></div>
                <h1 class="text-xl font-heading font-bold uppercase tracking-widest text-white">Component Definition</h1>
                <p class="text-sm font-sans text-premium-gray mt-2">Create a new entry in the global marketplace hardware database.</p>
            </div>

            <div class="p-8 lg:p-10">
                <form action="{{ route('vendor.products.store') }}" method="POST" class="space-y-10">
                    @csrf

                    @if ($errors->any())
                        <div class="rounded-xl border border-red-500/30 bg-red-500/10 p-5 font-sans text-red-400 text-sm backdrop-blur-md">
                            <p class="font-bold mb-2 uppercase tracking-tight text-xs flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Validation Failure:
                            </p>
                            <ul class="list-disc list-inside space-y-1 opacity-90">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                                <div class="space-y-8">
                            <div class="group">
                                <label for="name" class="block font-heading font-bold text-[10px] tracking-widest uppercase text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Internal Title</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required placeholder="e.g. GeForce RTX 4090"
                                       class="w-full bg-premium-black/40 border border-white/10 text-white font-sans px-5 py-4 rounded-2xl focus:outline-none focus:ring-1 focus:ring-premium-gold focus:border-premium-gold transition-all shadow-inner placeholder-white/10">
                            </div>

                            <div class="group">
                                <label for="category_id" class="block font-heading font-bold text-[10px] tracking-widest uppercase text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Category Taxonomy</label>
                                <div class="relative">
                                    <select id="category_id" name="category_id" required
                                            class="w-full bg-premium-black/40 border border-white/10 text-white font-sans px-5 py-4 rounded-2xl appearance-none focus:outline-none focus:border-premium-gold transition-colors cursor-pointer shadow-inner">
                                        <option value="" class="bg-premium-black">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id) class="bg-premium-black">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-premium-gray">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-8">
                                <div class="group">
                                    <label for="price" class="block font-heading font-bold text-[10px] tracking-widest uppercase text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Unit Value ($)</label>
                                    <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price') }}" required
                                           class="w-full bg-premium-black/40 border border-white/10 text-premium-goldLight font-mono px-5 py-4 rounded-2xl focus:outline-none focus:border-premium-gold transition-all shadow-inner">
                                </div>
                                <div class="group">
                                    <label for="stock_quantity" class="block font-heading font-bold text-[10px] tracking-widest uppercase text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Reserve Qty</label>
                                    <input id="stock_quantity" name="stock_quantity" type="number" min="0" value="{{ old('stock_quantity', 0) }}" required
                                           class="w-full bg-premium-black/40 border border-white/10 text-white font-sans px-5 py-4 rounded-2xl focus:outline-none focus:border-premium-gold transition-all shadow-inner">
                                </div>
                            </div>
                        </div>

                                                <div class="space-y-8">
                            <div class="group">
                                <label for="availability_status" class="block font-heading font-bold text-[10px] tracking-widest uppercase text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Avail. Status</label>
                                <input id="availability_status" name="availability_status" type="text" value="{{ old('availability_status', 'in_stock') }}" required
                                       class="w-full bg-premium-black/40 border border-white/10 text-white font-sans px-5 py-4 rounded-2xl focus:outline-none focus:border-premium-gold transition-all shadow-inner">
                            </div>

                            <div class="group">
                                <label for="product_type" class="block font-heading font-bold text-[10px] tracking-widest uppercase text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Product Protocol</label>
                                <input id="product_type" name="product_type" type="text" value="{{ old('product_type', 'physical') }}" required
                                       class="w-full bg-premium-black/40 border border-white/10 text-white font-sans px-5 py-4 rounded-2xl focus:outline-none focus:border-premium-gold transition-all shadow-inner">
                            </div>

                            <div class="group">
                                <label for="image_url" class="block font-heading font-bold text-[10px] tracking-widest uppercase text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Visual Indicator URL</label>
                                <input id="image_url" name="image_url" type="url" value="{{ old('image_url') }}" placeholder="https://..."
                                       class="w-full bg-premium-black/40 border border-white/10 text-premium-silver font-sans px-5 py-4 rounded-2xl focus:outline-none focus:border-premium-gold transition-all shadow-inner text-xs placeholder-white/10">
                            </div>
                        </div>
                    </div>

                                        <div class="space-y-8 border-t border-white/5 pt-10">
                        <div class="group">
                            <label for="description" class="block font-heading font-bold text-[10px] tracking-widest uppercase text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Functional Description</label>
                            <textarea id="description" name="description" rows="5" required placeholder="Describe the component's capabilities..."
                                      class="w-full bg-premium-black/40 border border-white/10 text-white font-sans px-6 py-5 rounded-3xl focus:outline-none focus:ring-1 focus:ring-premium-gold focus:border-premium-gold transition-all shadow-inner resize-none min-h-[150px] leading-relaxed placeholder-white/10">{{ old('description') }}</textarea>
                        </div>

                        <div class="group">
                            <label for="technical_specs" class="block font-heading font-bold text-[10px] tracking-widest uppercase text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Technical Matrix (Raw Data)</label>
                            <textarea id="technical_specs" name="technical_specs" rows="4" placeholder="Model: X100, Chipset: B550, TDP: 65W..."
                                      class="w-full bg-premium-black/40 border border-white/10 text-premium-silver font-mono px-6 py-5 rounded-3xl focus:outline-none focus:border-premium-gold transition-all shadow-inner resize-none text-xs placeholder-white/10">{{ old('technical_specs') }}</textarea>
                        </div>
                    </div>

                    <div class="pt-10 border-t border-white/5 flex flex-col sm:flex-row gap-5">
                        <button type="submit" class="flex-grow h-16 bg-gradient-to-r from-premium-gold to-yellow-600 text-premium-black hover:scale-[1.01] font-heading font-bold uppercase tracking-widest text-sm rounded-2xl transition-all duration-300 shadow-glow-gold flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Confirm Deployment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
