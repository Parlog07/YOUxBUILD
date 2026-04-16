<x-guest-layout>
    <div class="fixed inset-0 flex items-center justify-center p-4 z-20 overflow-y-auto">
        <div class="w-full max-w-xl bg-premium-card/80 backdrop-blur-xl border border-white/10 rounded-3xl p-8 sm:p-10 shadow-glow-subtle relative overflow-hidden my-8">
            
            <!-- Subtle internal glow -->
            <div class="absolute -top-10 -right-10 w-60 h-60 bg-premium-silver/10 blur-3xl rounded-full"></div>

            <div class="text-center mb-10 relative z-10">
                <a href="{{ route('home') }}" class="inline-block hover:scale-105 transition-transform duration-300">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-premium-gold to-yellow-700 flex items-center justify-center shadow-glow-gold mx-auto mb-4">
                        <svg viewBox="0 0 40 40" class="w-6 h-6 text-premium-black fill-current">
                            <path d="M4 4h9.5l6.5 12V36h-5V18.5L5 5H4V4z"/>
                            <path d="M36 4h-9.5l-6.5 12V36h5V18.5L35 5h1V4z"/>
                        </svg>
                    </div>
                </a>
                <h1 class="font-heading font-extrabold text-2xl tracking-widest uppercase text-white mb-2">Create Profile</h1>
                <p class="font-sans text-sm text-premium-gray">Gain authorization to the marketplace network.</p>
            </div>

            @if ($errors->any())
                <div class="mb-8 rounded-xl border border-red-500/30 bg-red-500/10 p-4 font-sans text-red-400 text-sm backdrop-blur-md relative z-10">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="relative z-10 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block font-heading font-bold text-xs tracking-widest uppercase text-premium-silver mb-2">Full Identity</label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" required autofocus
                               class="w-full bg-premium-black/50 border border-white/10 text-white placeholder-premium-gray font-sans px-4 py-3 rounded-xl focus:outline-none focus:ring-1 focus:ring-premium-gold focus:border-premium-gold transition-all shadow-inner">
                    </div>

                    <!-- Email -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block font-heading font-bold text-xs tracking-widest uppercase text-premium-silver mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full bg-premium-black/50 border border-white/10 text-white placeholder-premium-gray font-sans px-4 py-3 rounded-xl focus:outline-none focus:ring-1 focus:ring-premium-gold focus:border-premium-gold transition-all shadow-inner">
                    </div>

                    <!-- Password -->
                    <div class="col-span-1">
                        <label class="block font-heading font-bold text-xs tracking-widest uppercase text-premium-silver mb-2">Passkey</label>
                        <input type="password" name="password" required autocomplete="new-password"
                               class="w-full bg-premium-black/50 border border-white/10 text-white placeholder-premium-gray font-sans px-4 py-3 rounded-xl focus:outline-none focus:ring-1 focus:ring-premium-gold focus:border-premium-gold transition-all shadow-inner">
                    </div>

                    <!-- Confirm Password -->
                    <div class="col-span-1">
                        <label class="block font-heading font-bold text-xs tracking-widest uppercase text-premium-silver mb-2">Verify Passkey</label>
                        <input type="password" name="password_confirmation" required autocomplete="new-password"
                               class="w-full bg-premium-black/50 border border-white/10 text-white placeholder-premium-gray font-sans px-4 py-3 rounded-xl focus:outline-none focus:ring-1 focus:ring-premium-gold focus:border-premium-gold transition-all shadow-inner">
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full h-14 bg-white text-premium-black hover:bg-premium-silver font-heading font-bold uppercase tracking-widest text-sm rounded-xl transition-all duration-300 shadow-glow-subtle flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Generate Profile
                    </button>
                    
                    <div class="text-center mt-6">
                        <p class="text-xs font-sans text-premium-gray">
                            Already registered? 
                            <a href="{{ route('login') }}" class="text-white hover:text-premium-goldLight font-medium transition-colors">Access Session</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>