<x-app-layout>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-16 relative z-10 w-full">
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-heading font-extrabold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-premium-goldLight to-premium-gold uppercase tracking-widest leading-tight">
                {{ __('Secure Authorization') }}
            </h2>
            <a href="{{ route('cart.index') }}" class="text-premium-silver hover:text-white font-sans text-xs font-bold uppercase tracking-widest transition-colors flex items-center gap-2 bg-white/5 px-4 py-2 rounded-xl border border-white/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Modify Cart
            </a>
        </div>
        
        <div class="bg-premium-card/60 backdrop-blur-xl shadow-glow-subtle border border-white/5 rounded-3xl overflow-hidden relative">
            
                        <div class="p-8 border-b border-white/5 bg-premium-black/50 relative overflow-hidden text-center">
                <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-premium-gold/50 to-transparent"></div>
                <div class="w-16 h-16 bg-premium-gold/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-premium-gold/30">
                    <svg class="w-8 h-8 text-premium-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04m12.849 3.332c.303.116.51.405.51.734v3.138c0 3.01-1.242 5.881-3.387 7.892L12 21l-1.573-1.892C8.283 17.098 7.041 14.227 7.041 11.217V8.08c0-.329.207-.618.51-.734l5-2z"></path></svg>
                </div>
                <h1 class="text-xl font-heading font-bold uppercase tracking-[0.2em] text-white">Encrypted Settlement</h1>
                <p class="text-xs font-sans text-premium-gray mt-2 tracking-wide uppercase">Finalizing procurement protocol for Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>

            <div class="p-8 lg:p-12">
                @if ($errors->any())
                    <div class="mb-8 rounded-xl border border-red-500/30 bg-red-500/10 p-4 font-sans text-red-400 text-sm">
                        <p class="font-semibold mb-2">Please complete the delivery address.</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h3 class="font-heading font-bold text-sm text-premium-silver uppercase tracking-widest border-b border-white/5 pb-4 mb-6">Inventory Summary</h3>

                <div class="space-y-4 mb-10">
                    @foreach ($order->items as $item)
                        <div class="flex items-center justify-between p-4 bg-premium-black/40 rounded-xl border border-white/5 hover:border-premium-gold/20 transition-all group">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 group-hover:border-premium-silver/30 transition-colors">
                                    <svg class="w-5 h-5 text-premium-silver" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <div>
                                    <p class="font-heading font-bold text-white text-sm uppercase tracking-wider">{{ $item->product->name }}</p>
                                    <p class="text-[10px] text-premium-gray font-sans">QTY: {{ $item->quantity }} • ${{ number_format($item->unit_price, 2) }} UNIT</p>
                                </div>
                            </div>
                            <p class="font-heading font-bold text-premium-silver tracking-tight">
                                ${{ number_format($item->subtotal, 2) }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="bg-premium-black/60 rounded-2xl p-8 border border-premium-gold/30 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-6 opacity-10">
                        <svg class="w-24 h-24 text-premium-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    
                    <div class="flex flex-col items-center text-center relative z-10">
                        <span class="font-heading font-bold text-premium-gray uppercase tracking-[0.3em] text-xs mb-2">Total Financial Commitment</span>
                        <h2 class="text-5xl font-heading font-extrabold text-white tracking-tighter mb-8 flex items-start">
                            <span class="text-2xl text-premium-gold mt-2 mr-1">$</span>
                            {{ number_format($order->total_amount, 2) }}
                        </h2>

                        <form method="POST" action="{{ route('payment.confirm') }}" class="w-full space-y-6 text-left">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label for="street" class="block text-xs font-heading font-bold uppercase tracking-widest text-premium-silver mb-2">Street</label>
                                    <input id="street" name="street" type="text" value="{{ old('street', $order->address?->street ?? $preferredAddress?->street) }}" required class="w-full rounded-xl border border-white/10 bg-premium-black/40 px-4 py-3 text-white focus:border-premium-gold focus:ring-premium-gold">
                                </div>
                                <div>
                                    <label for="city" class="block text-xs font-heading font-bold uppercase tracking-widest text-premium-silver mb-2">City</label>
                                    <input id="city" name="city" type="text" value="{{ old('city', $order->address?->city ?? $preferredAddress?->city) }}" required class="w-full rounded-xl border border-white/10 bg-premium-black/40 px-4 py-3 text-white focus:border-premium-gold focus:ring-premium-gold">
                                </div>
                                <div>
                                    <label for="postal_code" class="block text-xs font-heading font-bold uppercase tracking-widest text-premium-silver mb-2">Postal Code</label>
                                    <input id="postal_code" name="postal_code" type="text" value="{{ old('postal_code', $order->address?->postal_code ?? $preferredAddress?->postal_code) }}" required class="w-full rounded-xl border border-white/10 bg-premium-black/40 px-4 py-3 text-white focus:border-premium-gold focus:ring-premium-gold">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="country" class="block text-xs font-heading font-bold uppercase tracking-widest text-premium-silver mb-2">Country</label>
                                    <input id="country" name="country" type="text" value="{{ old('country', $order->address?->country ?? $preferredAddress?->country) }}" required class="w-full rounded-xl border border-white/10 bg-premium-black/40 px-4 py-3 text-white focus:border-premium-gold focus:ring-premium-gold">
                                </div>
                                <div>
                                    <label for="phone_number" class="block text-xs font-heading font-bold uppercase tracking-widest text-premium-silver mb-2">Phone Number</label>
                                    <input id="phone_number" name="phone_number" type="text" value="{{ old('phone_number', $order->address?->phone_number ?? $preferredAddress?->phone_number ?? auth()->user()->phone) }}" required class="w-full rounded-xl border border-white/10 bg-premium-black/40 px-4 py-3 text-white focus:border-premium-gold focus:ring-premium-gold">
                                </div>
                                <div>
                                    <label for="email" class="block text-xs font-heading font-bold uppercase tracking-widest text-premium-silver mb-2">Email Address</label>
                                    <input id="email" name="email" type="email" value="{{ old('email', $order->address?->email ?? $preferredAddress?->email ?? auth()->user()->email) }}" required class="w-full rounded-xl border border-white/10 bg-premium-black/40 px-4 py-3 text-white focus:border-premium-gold focus:ring-premium-gold">
                                </div>
                            </div>
                            <button type="submit" class="w-full h-16 bg-gradient-to-r from-premium-gold to-yellow-600 text-premium-black hover:from-white hover:to-white font-heading font-bold text-sm uppercase tracking-widest rounded-xl transition-all duration-500 flex justify-center items-center gap-3 shadow-glow-gold hover:scale-[1.01] active:scale-95">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Authorize Transaction
                            </button>
                        </form>
                        
                        <p class="text-[10px] text-premium-gray font-sans mt-6 uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.9L10 .3l7.834 4.6a1 1 0 01.5.866v7.468a1 1 0 01-.5.866L10 18.7l-7.834-4.6a1 1 0 01-.5-.866V5.766a1 1 0 01.5-.866zM10 2.3l-6 3.5v6.4l6 3.5 6-3.5V5.8l-6-3.5zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                            Secure Neural-Link Protocol Active
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
