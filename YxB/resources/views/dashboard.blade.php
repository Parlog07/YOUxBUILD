<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12 relative z-10 w-full">
        <h2 class="font-heading font-extrabold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-premium-goldLight to-premium-gold uppercase tracking-widest leading-tight mb-8">
            {{ __('Command Center') }}
        </h2>
            
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Account Status Card -->
                <div class="bg-premium-card/60 backdrop-blur-xl shadow-glow-subtle border border-white/5 rounded-3xl p-8 relative overflow-hidden group hover:border-premium-silver/30 transition-colors">
                    <div class="absolute inset-0 bg-gradient-to-br from-premium-silver/5 to-transparent"></div>
                    
                    <h3 class="font-heading font-bold text-premium-silver uppercase tracking-widest text-sm mb-6 border-b border-white/10 pb-4 relative z-10 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Network Identity
                    </h3>

                    <div class="relative z-10">
                        <p class="text-white font-heading text-lg mb-2">{{ auth()->user()->full_name }}</p>
                        <p class="text-premium-gray font-sans text-sm mb-6">{{ auth()->user()->email }}</p>
                        
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/5 border border-white/10">
                            <span class="w-2 h-2 rounded-full bg-green-500 mr-2 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></span>
                            <span class="text-white font-sans text-xs font-medium uppercase tracking-wider">Session Active</span>
                        </div>
                    </div>
                </div>

                <!-- Vendor Status Card -->
                <div class="bg-premium-card/60 backdrop-blur-xl shadow-glow-gold border border-white/5 rounded-3xl p-8 relative overflow-hidden group hover:border-premium-gold/30 transition-colors">
                    <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-premium-gold/5 to-transparent"></div>
                    
                    <h3 class="font-heading font-bold text-premium-gold uppercase tracking-widest text-sm mb-6 border-b border-white/10 pb-4 relative z-10 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Vendor Portal Status
                    </h3>

                    <div class="relative z-10 flex flex-col h-[calc(100%-4rem)] justify-between">
                        @if (! auth()->user()->vendorProfile)
                            <p class="text-premium-gray font-sans text-sm mb-6">You are currently operating as a standard client. Apply to become a verified vendor to list hardware on the marketplace.</p>
                            <a href="{{ route('vendor.request.form') }}" class="w-full px-6 py-3 bg-white/5 border border-white/10 text-white hover:bg-premium-gold hover:text-black hover:border-transparent font-heading font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 text-center">
                                Initiate Vendor Request
                            </a>
                        @elseif (auth()->user()->vendorProfile->status === 'pending')
                            <div class="space-y-4">
                                <div class="flex items-center gap-3 bg-yellow-500/10 border border-yellow-500/20 p-4 rounded-xl">
                                    <svg class="w-6 h-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-yellow-500 font-sans text-sm font-medium">Your vendor application is under review by network administrators.</p>
                                </div>
                                <div class="bg-premium-black/30 border border-white/10 rounded-xl p-4 space-y-2 text-sm font-sans">
                                    <p><span class="text-premium-gray">Store:</span> <span class="text-white">{{ auth()->user()->vendorProfile->store_name }}</span></p>
                                    <p><span class="text-premium-gray">Business address:</span> <span class="text-white">{{ auth()->user()->vendorProfile->business_address }}</span></p>
                                    @if (auth()->user()->vendorProfile->store_description)
                                        <p><span class="text-premium-gray">Description:</span> <span class="text-white">{{ auth()->user()->vendorProfile->store_description }}</span></p>
                                    @endif
                                </div>
                            </div>
                        @elseif (auth()->user()->vendorProfile->status === 'approved')
                            <div class="flex flex-col h-full justify-between">
                                <div class="flex items-center gap-3 bg-green-500/10 border border-green-500/20 p-4 rounded-xl mb-4">
                                    <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-green-400 font-sans text-sm font-medium">Clearance granted. You are a verified vendor.</p>
                                </div>
                                <div class="bg-premium-black/30 border border-white/10 rounded-xl p-4 space-y-2 text-sm font-sans mb-4">
                                    <p><span class="text-premium-gray">Store:</span> <span class="text-white">{{ auth()->user()->vendorProfile->store_name }}</span></p>
                                    <p><span class="text-premium-gray">Business address:</span> <span class="text-white">{{ auth()->user()->vendorProfile->business_address }}</span></p>
                                    @if (auth()->user()->vendorProfile->store_description)
                                        <p><span class="text-premium-gray">Description:</span> <span class="text-white">{{ auth()->user()->vendorProfile->store_description }}</span></p>
                                    @endif
                                </div>
                                <a href="{{ route('vendor.products.index') }}" class="w-full px-6 py-3 text-center bg-gradient-to-r from-premium-gold to-yellow-600 text-premium-black hover:scale-[1.02] font-heading font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 shadow-glow-gold">
                                    Access Vendor Dashboard
                                </a>
                            </div>
                        @elseif (auth()->user()->vendorProfile->status === 'rejected')
                            <div class="space-y-4">
                                <div class="flex items-center gap-3 bg-red-500/10 border border-red-500/20 p-4 rounded-xl">
                                    <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-red-400 font-sans text-sm font-medium">Your vendor application was rejected.</p>
                                </div>
                                <div class="bg-premium-black/30 border border-white/10 rounded-xl p-4 space-y-2 text-sm font-sans">
                                    <p><span class="text-premium-gray">Store:</span> <span class="text-white">{{ auth()->user()->vendorProfile->store_name }}</span></p>
                                    <p><span class="text-premium-gray">Business address:</span> <span class="text-white">{{ auth()->user()->vendorProfile->business_address }}</span></p>
                                    @if (auth()->user()->vendorProfile->store_description)
                                        <p><span class="text-premium-gray">Description:</span> <span class="text-white">{{ auth()->user()->vendorProfile->store_description }}</span></p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </x-app-layout>
