<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-heading font-extrabold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-premium-goldLight to-premium-gold uppercase tracking-widest leading-tight">
                    Prebuilt PC Builder
                </h2>
                <p class="mt-2 text-sm font-sans text-premium-gray">Fill the hardware once and the listing description will be assembled automatically.</p>
            </div>

            <a href="{{ route('vendor.products.index') }}" class="px-5 py-3 bg-white/5 border border-white/10 text-white hover:bg-white hover:text-black font-heading font-bold text-xs uppercase tracking-widest rounded-xl transition-all">
                Back To Inventory
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12 relative z-10 w-full">
        <div class="grid gap-8 lg:grid-cols-[1.65fr_0.9fr]">
            <div class="bg-premium-card/60 backdrop-blur-xl shadow-glow-subtle border border-white/5 rounded-3xl overflow-hidden">
                <div class="p-8 border-b border-white/5 bg-premium-black/50">
                    <h1 class="text-xl font-heading font-bold uppercase tracking-widest text-white">Launch New Prebuilt PC</h1>
                    <p class="text-sm font-sans text-premium-gray mt-2">This builder saves the PC as a normal product in the <span class="text-premium-goldLight">{{ $prebuiltCategory->name }}</span> category.</p>
                </div>

                <form action="{{ route('vendor.products.prebuilt.store') }}" method="POST" class="p-8 space-y-8">
                    @csrf

                    @if ($errors->any())
                        <div class="rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-200">
                            Please review the highlighted fields and try again.
                        </div>
                    @endif

                    <section class="space-y-6">
                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label for="name" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">Prebuilt Name</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Example: Phantom RTX 4070 Gaming PC" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white placeholder:text-premium-gray focus:border-premium-gold focus:ring-premium-gold">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="price" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">Price</label>
                                <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price') }}" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white focus:border-premium-gold focus:ring-premium-gold">
                                @error('price')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="stock_quantity" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">Units Available</label>
                                <input id="stock_quantity" name="stock_quantity" type="number" min="0" value="{{ old('stock_quantity', 0) }}" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white focus:border-premium-gold focus:ring-premium-gold">
                                @error('stock_quantity')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="availability_status" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">Availability</label>
                                <select id="availability_status" name="availability_status" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white focus:border-premium-gold focus:ring-premium-gold">
                                    <option value="in_stock" @selected(old('availability_status', 'in_stock') === 'in_stock')>In Stock</option>
                                    <option value="out_of_stock" @selected(old('availability_status') === 'out_of_stock')>Out of Stock</option>
                                    <option value="preorder" @selected(old('availability_status') === 'preorder')>Preorder</option>
                                </select>
                                @error('availability_status')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="image_url" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">Image URL</label>
                                <input id="image_url" name="image_url" type="url" value="{{ old('image_url') }}" placeholder="https://..." class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white placeholder:text-premium-gray focus:border-premium-gold focus:ring-premium-gold">
                                @error('image_url')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <section class="space-y-6">
                        <div>
                            <h3 class="font-heading font-bold text-sm uppercase tracking-widest text-white">Core Components</h3>
                            <p class="mt-2 text-sm font-sans text-premium-gray">The final description is generated from these parts, so fill each line as the buyer should see it.</p>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="cpu" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">CPU</label>
                                <input id="cpu" name="cpu" type="text" value="{{ old('cpu') }}" placeholder="AMD Ryzen 7 7800X3D" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white placeholder:text-premium-gray focus:border-premium-gold focus:ring-premium-gold">
                                @error('cpu')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gpu" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">GPU</label>
                                <input id="gpu" name="gpu" type="text" value="{{ old('gpu') }}" placeholder="NVIDIA GeForce RTX 4070 Super 12GB" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white placeholder:text-premium-gray focus:border-premium-gold focus:ring-premium-gold">
                                @error('gpu')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ram" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">RAM</label>
                                <input id="ram" name="ram" type="text" value="{{ old('ram') }}" placeholder="32GB DDR5 6000MHz" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white placeholder:text-premium-gray focus:border-premium-gold focus:ring-premium-gold">
                                @error('ram')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="motherboard" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">Motherboard</label>
                                <input id="motherboard" name="motherboard" type="text" value="{{ old('motherboard') }}" placeholder="B650 ATX Wi-Fi" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white placeholder:text-premium-gray focus:border-premium-gold focus:ring-premium-gold">
                                @error('motherboard')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ssd" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">SSD</label>
                                <input id="ssd" name="ssd" type="text" value="{{ old('ssd') }}" placeholder="1TB NVMe Gen4 SSD" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white placeholder:text-premium-gray focus:border-premium-gold focus:ring-premium-gold">
                                @error('ssd')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="hdd" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">HDD</label>
                                <input id="hdd" name="hdd" type="text" value="{{ old('hdd') }}" placeholder="2TB 7200RPM HDD" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white placeholder:text-premium-gray focus:border-premium-gold focus:ring-premium-gold">
                                @error('hdd')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="power_supply" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">Power Supply</label>
                                <input id="power_supply" name="power_supply" type="text" value="{{ old('power_supply') }}" placeholder="750W 80+ Gold" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white placeholder:text-premium-gray focus:border-premium-gold focus:ring-premium-gold">
                                @error('power_supply')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="pc_case" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">Case</label>
                                <input id="pc_case" name="pc_case" type="text" value="{{ old('pc_case') }}" placeholder="Mid Tower Tempered Glass Case" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white placeholder:text-premium-gray focus:border-premium-gold focus:ring-premium-gold">
                                @error('pc_case')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cpu_cooler" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">CPU Cooler</label>
                                <input id="cpu_cooler" name="cpu_cooler" type="text" value="{{ old('cpu_cooler') }}" placeholder="240mm Liquid Cooler" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white placeholder:text-premium-gray focus:border-premium-gold focus:ring-premium-gold">
                                @error('cpu_cooler')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="case_fans" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">Case Fans</label>
                                <input id="case_fans" name="case_fans" type="text" value="{{ old('case_fans') }}" placeholder="3 x 120mm ARGB Fans" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white placeholder:text-premium-gray focus:border-premium-gold focus:ring-premium-gold">
                                @error('case_fans')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="operating_system" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">Operating System</label>
                                <input id="operating_system" name="operating_system" type="text" value="{{ old('operating_system') }}" placeholder="Windows 11 Pro" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white placeholder:text-premium-gray focus:border-premium-gold focus:ring-premium-gold">
                                @error('operating_system')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="connectivity" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">Connectivity / Extras</label>
                                <input id="connectivity" name="connectivity" type="text" value="{{ old('connectivity') }}" placeholder="Wi-Fi 6, Bluetooth 5.3, RGB controller" class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white placeholder:text-premium-gray focus:border-premium-gold focus:ring-premium-gold">
                                @error('connectivity')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <section class="space-y-4">
                        <div>
                            <label for="vendor_notes" class="block font-heading font-bold text-xs uppercase tracking-widest text-premium-silver">Extra Selling Notes</label>
                            <textarea id="vendor_notes" name="vendor_notes" rows="4" placeholder="Optional: mention the target use case, airflow, upgrade potential, warranty, or special build notes." class="mt-2 block w-full rounded-xl border border-white/10 bg-premium-black/60 px-4 py-3 text-white placeholder:text-premium-gray focus:border-premium-gold focus:ring-premium-gold">{{ old('vendor_notes') }}</textarea>
                            @error('vendor_notes')
                                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                            @enderror
                        </div>
                    </section>

                    <div class="flex flex-wrap items-center gap-4 border-t border-white/10 pt-6">
                        <button type="submit" class="px-8 py-4 bg-gradient-to-r from-premium-gold to-yellow-600 text-premium-black hover:scale-[1.02] font-heading font-bold text-xs uppercase tracking-widest rounded-xl transition-all shadow-glow-gold flex items-center gap-2">
                            Launch Prebuilt PC
                        </button>

                        <a href="{{ route('vendor.products.index') }}" class="px-6 py-4 bg-white/5 border border-white/10 text-white hover:bg-white hover:text-black font-heading font-bold text-xs uppercase tracking-widest rounded-xl transition-all">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <aside class="bg-premium-card/50 backdrop-blur-xl shadow-glow-subtle border border-white/5 rounded-3xl overflow-hidden h-fit">
                <div class="p-8 border-b border-white/5 bg-premium-black/50">
                    <h3 class="font-heading font-bold text-sm uppercase tracking-widest text-white">What Gets Generated</h3>
                </div>

                <div class="p-8 space-y-6 text-sm font-sans text-premium-gray">
                    <div class="rounded-2xl border border-white/5 bg-white/5 p-5">
                        <p class="font-heading font-bold text-xs uppercase tracking-widest text-premium-silver mb-3">Automatic Description</p>
                        <p>The saved description is assembled from the CPU, GPU, RAM, storage, cooling, case, and your extra notes so the vendor does not need to rewrite the full build manually.</p>
                    </div>

                    <div class="rounded-2xl border border-white/5 bg-white/5 p-5">
                        <p class="font-heading font-bold text-xs uppercase tracking-widest text-premium-silver mb-3">Automatic Category</p>
                        <p>This page always saves the product in <span class="text-premium-goldLight">Prebuilt PCs</span>, so it will automatically appear on the public prebuilt marketplace page.</p>
                    </div>

                    <div class="rounded-2xl border border-white/5 bg-white/5 p-5">
                        <p class="font-heading font-bold text-xs uppercase tracking-widest text-premium-silver mb-3">Fast Vendor Workflow</p>
                        <p>Use the guided hardware fields for complete builds, then keep the regular component page for single parts like GPUs, RAM, SSDs, and power supplies.</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>
