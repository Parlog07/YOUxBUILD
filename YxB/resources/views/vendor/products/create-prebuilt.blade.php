<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12 relative z-10 w-full">
        
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
            <div>
                <h2 class="font-heading font-extrabold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-premium-goldLight to-premium-gold uppercase tracking-widest leading-tight">
                    Prebuilt PC Architect
                </h2>
                <p class="text-premium-gray text-xs font-sans uppercase tracking-[0.2em] mt-2 opacity-70">Assemble a complete hardware listing</p>
            </div>
            <a href="{{ route('vendor.products.index') }}" class="px-6 py-3 bg-white/5 border border-white/10 text-white hover:bg-white hover:text-black font-heading font-bold text-xs uppercase tracking-widest rounded-xl transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Abort & Return
            </a>
        </div>

        <div class="grid gap-10 lg:grid-cols-[1fr_0.4fr]">
            <div class="bg-premium-card/60 backdrop-blur-xl shadow-glow-subtle border border-white/5 rounded-3xl overflow-hidden relative">
                <div class="p-8 border-b border-white/5 bg-premium-black/50 relative overflow-hidden">
                    <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-premium-gold/50 to-transparent"></div>
                    <h1 class="text-xl font-heading font-bold uppercase tracking-widest text-white">System Specification</h1>
                    <p class="text-sm font-sans text-premium-gray mt-2">Fill the hardware parameters once; the manifest generates automatically.</p>
                </div>

                <form action="{{ route('vendor.products.prebuilt.store') }}" method="POST" class="p-8 lg:p-10 space-y-12">
                    @csrf

                    @if ($errors->any())
                        <div class="rounded-xl border border-red-500/30 bg-red-500/10 p-5 font-sans text-red-400 text-sm backdrop-blur-md">
                            <p class="font-bold mb-2 uppercase tracking-tight text-xs">Configuration Failure:</p>
                            <ul class="list-disc list-inside space-y-1 opacity-80">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <section class="space-y-8">
                        <div class="grid gap-8 md:grid-cols-2">
                            <div class="md:col-span-2 group">
                                <label for="name" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Prebuilt Build Name</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Example: Phantom RTX 4070 Super Edition" 
                                       class="block w-full rounded-2xl border border-white/10 bg-premium-black/40 px-5 py-4 text-white placeholder:text-white/10 focus:border-premium-gold focus:ring-premium-gold shadow-inner">
                            </div>

                            <div class="group">
                                <label for="price" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Total Value ($)</label>
                                <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price') }}" 
                                       class="block w-full rounded-2xl border border-white/10 bg-premium-black/40 px-5 py-4 text-premium-goldLight font-mono focus:border-premium-gold focus:ring-premium-gold shadow-inner">
                            </div>

                            <div class="group">
                                <label for="stock_quantity" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Build Reserve Qty</label>
                                <input id="stock_quantity" name="stock_quantity" type="number" min="0" value="{{ old('stock_quantity', 0) }}" 
                                       class="block w-full rounded-2xl border border-white/10 bg-premium-black/40 px-5 py-4 text-white focus:border-premium-gold focus:ring-premium-gold shadow-inner">
                            </div>

                            <div class="group">
                                <label for="availability_status" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Logistics Availability</label>
                                <div class="relative">
                                    <select id="availability_status" name="availability_status" class="block w-full rounded-2xl border border-white/10 bg-premium-black/40 px-5 py-4 text-white appearance-none focus:border-premium-gold focus:ring-premium-gold shadow-inner cursor-pointer">
                                        <option value="in_stock" @selected(old('availability_status', 'in_stock') === 'in_stock') class="bg-premium-black">In Stock</option>
                                        <option value="out_of_stock" @selected(old('availability_status') === 'out_of_stock') class="bg-premium-black">Out of Stock</option>
                                        <option value="preorder" @selected(old('availability_status') === 'preorder') class="bg-premium-black">Preorder</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-premium-gray">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="group">
                                <label for="image_url" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Showcase Image URL</label>
                                <input id="image_url" name="image_url" type="url" value="{{ old('image_url') }}" placeholder="https://..." 
                                       class="block w-full rounded-2xl border border-white/10 bg-premium-black/40 px-5 py-4 text-white placeholder:text-white/10 focus:border-premium-gold focus:ring-premium-gold shadow-inner text-xs">
                            </div>
                        </div>
                    </section>

                    <section class="space-y-10 pt-10 border-t border-white/5">
                        <div>
                            <h3 class="font-heading font-bold text-sm uppercase tracking-widest text-white mb-2">Core Component Matrix</h3>
                            <p class="text-xs font-sans text-premium-gray opacity-60">The final manifest is auto-generated from these parameters.</p>
                        </div>

                        <div class="grid gap-8 md:grid-cols-2">
                            <div class="group">
                                <label for="cpu" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Central Processing Unit (CPU)</label>
                                <input id="cpu" name="cpu" type="text" value="{{ old('cpu') }}" placeholder="e.g. AMD Ryzen 9 7950X" class="block w-full rounded-2xl border border-white/10 bg-premium-black/40 px-5 py-4 text-white placeholder:text-white/10 focus:border-premium-gold focus:ring-premium-gold shadow-inner">
                            </div>

                            <div class="group">
                                <label for="gpu" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Graphics Processor (GPU)</label>
                                <input id="gpu" name="gpu" type="text" value="{{ old('gpu') }}" placeholder="e.g. NVIDIA RTX 4080 16GB" class="block w-full rounded-2xl border border-white/10 bg-premium-black/40 px-5 py-4 text-white placeholder:text-white/10 focus:border-premium-gold focus:ring-premium-gold shadow-inner">
                            </div>

                            <div class="group">
                                <label for="ram" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Memory Loadout (RAM)</label>
                                <input id="ram" name="ram" type="text" value="{{ old('ram') }}" placeholder="e.g. 64GB DDR5 6000MHz" class="block w-full rounded-2xl border border-white/10 bg-premium-black/40 px-5 py-4 text-white placeholder:text-white/10 focus:border-premium-gold focus:ring-premium-gold shadow-inner">
                            </div>

                            <div class="group">
                                <label for="motherboard" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Mainboard Architecture</label>
                                <input id="motherboard" name="motherboard" type="text" value="{{ old('motherboard') }}" placeholder="e.g. X670E Hero Wi-Fi" class="block w-full rounded-2xl border border-white/10 bg-premium-black/40 px-5 py-4 text-white placeholder:text-white/10 focus:border-premium-gold focus:ring-premium-gold shadow-inner">
                            </div>

                            <div class="group">
                                <label for="ssd" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Primary Storage (SSD)</label>
                                <input id="ssd" name="ssd" type="text" value="{{ old('ssd') }}" placeholder="e.g. 2TB NVMe Gen5" class="block w-full rounded-2xl border border-white/10 bg-premium-black/40 px-5 py-4 text-white placeholder:text-white/10 focus:border-premium-gold focus:ring-premium-gold shadow-inner">
                            </div>

                            <div class="group">
                                <label for="hdd" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Secondary Storage (HDD)</label>
                                <input id="hdd" name="hdd" type="text" value="{{ old('hdd') }}" placeholder="Optional" class="block w-full rounded-2xl border border-white/10 bg-premium-black/40 px-5 py-4 text-white placeholder:text-white/10 focus:border-premium-gold focus:ring-premium-gold shadow-inner">
                            </div>

                            <div class="group">
                                <label for="power_supply" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Power Delivery Unit (PSU)</label>
                                <input id="power_supply" name="power_supply" type="text" value="{{ old('power_supply') }}" placeholder="e.g. 1000W 80+ Platinum" class="block w-full rounded-2xl border border-white/10 bg-premium-black/40 px-5 py-4 text-white placeholder:text-white/10 focus:border-premium-gold focus:ring-premium-gold shadow-inner">
                            </div>

                            <div class="group">
                                <label for="pc_case" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Chassis Choice</label>
                                <input id="pc_case" name="pc_case" type="text" value="{{ old('pc_case') }}" placeholder="e.g. ROG Hyperion GR701" class="block w-full rounded-2xl border border-white/10 bg-premium-black/40 px-5 py-4 text-white placeholder:text-white/10 focus:border-premium-gold focus:ring-premium-gold shadow-inner">
                            </div>

                            <div class="group">
                                <label for="cpu_cooler" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Thermal Solution</label>
                                <input id="cpu_cooler" name="cpu_cooler" type="text" value="{{ old('cpu_cooler') }}" placeholder="e.g. 360mm AIO Liquid" class="block w-full rounded-2xl border border-white/10 bg-premium-black/40 px-5 py-4 text-white placeholder:text-white/10 focus:border-premium-gold focus:ring-premium-gold shadow-inner">
                            </div>

                            <div class="group">
                                <label for="case_fans" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Airflow Components</label>
                                <input id="case_fans" name="case_fans" type="text" value="{{ old('case_fans') }}" placeholder="e.g. 6 x 140mm RGB" class="block w-full rounded-2xl border border-white/10 bg-premium-black/40 px-5 py-4 text-white placeholder:text-white/10 focus:border-premium-gold focus:ring-premium-gold shadow-inner">
                            </div>
                        </div>
                    </section>

                    <section class="space-y-8 pt-10 border-t border-white/5">
                        <div class="group">
                            <label for="vendor_notes" class="block font-heading font-bold text-[10px] uppercase tracking-widest text-premium-gray mb-3 group-focus-within:text-premium-gold transition-colors">Additional Selling Protocols</label>
                            <textarea id="vendor_notes" name="vendor_notes" rows="5" placeholder="Optional build notes, target benchmarks, or special features..." 
                                      class="block w-full rounded-3xl border border-white/10 bg-premium-black/40 px-6 py-5 text-white placeholder:text-white/10 focus:border-premium-gold focus:ring-premium-gold shadow-inner resize-none min-h-[150px] leading-relaxed">{{ old('vendor_notes') }}</textarea>
                        </div>
                    </section>

                    <div class="flex flex-wrap items-center gap-5 pt-10 border-t border-white/10">
                        <button type="submit" class="px-10 py-5 bg-gradient-to-r from-premium-gold to-yellow-600 text-premium-black hover:scale-[1.01] font-heading font-bold text-xs uppercase tracking-widest rounded-2xl transition-all shadow-glow-gold flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Launch Hardware Manifest
                        </button>
                    </div>
                </form>
            </div>

            <aside class="space-y-8">
                <div class="bg-premium-card/40 backdrop-blur-xl shadow-glow-subtle border border-white/5 rounded-3xl overflow-hidden sticky top-8">
                    <div class="p-8 border-b border-white/5 bg-premium-black/40 relative">
                        <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-premium-silver/30 to-transparent"></div>
                        <h3 class="font-heading font-bold text-sm uppercase tracking-widest text-white">System Protocols</h3>
                    </div>

                    <div class="p-8 space-y-8 text-sm font-sans text-premium-gray">
                        <div class="p-5 rounded-2xl bg-white/5 border border-white/5 hover:border-premium-gold/30 transition-colors">
                            <p class="font-heading font-bold text-[10px] uppercase tracking-widest text-premium-goldLight mb-3">Manifest Generation</p>
                            <p class="leading-relaxed opacity-80">The system automatically synthesizes the technical description from the hardware matrix provided. No manual writing required.</p>
                        </div>

                        <div class="p-5 rounded-2xl bg-white/5 border border-white/5 hover:border-premium-gold/30 transition-colors">
                            <p class="font-heading font-bold text-[10px] uppercase tracking-widest text-premium-goldLight mb-3">Global Routing</p>
                            <p class="leading-relaxed opacity-80">This asset will be automatically indexed in the <span class="text-white">Prebuilt PCs</span> marketplace sector.</p>
                        </div>

                        <div class="p-5 rounded-2xl bg-white/5 border border-white/5 hover:border-premium-gold/30 transition-colors">
                            <p class="font-heading font-bold text-[10px] uppercase tracking-widest text-premium-goldLight mb-3">Asset Classification</p>
                            <p class="leading-relaxed opacity-80">Use this builder for full systems. Use the standard component portal for individual hardware items.</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>
