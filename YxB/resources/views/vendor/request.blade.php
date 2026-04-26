<x-app-layout>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-12 relative z-10 w-full">
        <div class="flex items-center justify-between mb-8 gap-4">
            <h2 class="font-heading font-extrabold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-premium-goldLight to-premium-gold uppercase tracking-widest leading-tight">
                Vendor Request
            </h2>
            <a href="{{ route('dashboard') }}" class="text-premium-silver hover:text-white font-sans text-xs font-bold uppercase tracking-widest transition-colors flex items-center gap-2 bg-white/5 px-4 py-2 rounded-xl border border-white/10">
                Back to Dashboard
            </a>
        </div>

        <div class="bg-premium-card/60 backdrop-blur-xl shadow-glow-subtle border border-white/5 rounded-3xl overflow-hidden">
            <div class="p-8 border-b border-white/5 bg-premium-black/50">
                <h1 class="text-xl font-heading font-bold uppercase tracking-widest text-white">Submit Store Details</h1>
                <p class="text-sm font-sans text-premium-gray mt-2">Complete your vendor profile so an admin can review your request.</p>
            </div>

            <form method="POST" action="{{ route('vendor.request') }}" class="p-8 space-y-6">
                @csrf

                <div>
                    <label for="store_name" class="block text-sm font-heading font-bold uppercase tracking-widest text-premium-silver mb-2">Store Name</label>
                    <input id="store_name" name="store_name" type="text" value="{{ old('store_name') }}" required class="w-full rounded-xl border border-white/10 bg-premium-black/40 px-4 py-3 text-white focus:border-premium-gold focus:ring-premium-gold">
                    @error('store_name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="business_address" class="block text-sm font-heading font-bold uppercase tracking-widest text-premium-silver mb-2">Business Address</label>
                    <input id="business_address" name="business_address" type="text" value="{{ old('business_address') }}" required class="w-full rounded-xl border border-white/10 bg-premium-black/40 px-4 py-3 text-white focus:border-premium-gold focus:ring-premium-gold">
                    @error('business_address')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="store_description" class="block text-sm font-heading font-bold uppercase tracking-widest text-premium-silver mb-2">Store Description</label>
                    <textarea id="store_description" name="store_description" rows="5" class="w-full rounded-xl border border-white/10 bg-premium-black/40 px-4 py-3 text-white focus:border-premium-gold focus:ring-premium-gold">{{ old('store_description') }}</textarea>
                    @error('store_description')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-premium-gold to-yellow-600 text-premium-black font-heading font-bold text-xs uppercase tracking-widest rounded-xl transition-all shadow-glow-gold">
                    Send Vendor Request
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
