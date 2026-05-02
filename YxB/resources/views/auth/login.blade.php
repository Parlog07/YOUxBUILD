<x-guest-layout>
    <div class="fixed inset-0 flex items-center justify-center p-4 z-20">
        <div class="w-full max-w-md bg-premium-card/80 backdrop-blur-xl border border-white/10 rounded-3xl p-8 sm:p-10 shadow-glow-subtle relative overflow-hidden">
            
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-premium-gold/10 blur-3xl rounded-full"></div>

            <div class="text-center mb-10 relative z-10">
                <a href="{{ route('home') }}" class="inline-block hover:scale-105 transition-transform duration-300">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-premium-gold to-yellow-700 flex items-center justify-center shadow-glow-gold mx-auto mb-4">
                        <svg viewBox="0 0 40 40" class="w-6 h-6 text-premium-black fill-current">
                            <path d="M4 4h9.5l6.5 12V36h-5V18.5L5 5H4V4z"/>
                            <path d="M36 4h-9.5l-6.5 12V36h5V18.5L35 5h1V4z"/>
                        </svg>
                    </div>
                </a>
                <h1 class="font-heading font-extrabold text-2xl tracking-widest uppercase text-white mb-2">Secure Access</h1>
                <p class="font-sans text-sm text-premium-gray">Authenticate to access the marketplace.</p>
            </div>

            <x-auth-session-status class="mb-6 rounded-xl border border-premium-gold/30 bg-premium-gold/10 p-4 font-sans text-premium-goldLight font-semibold text-sm" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="relative z-10 space-y-6">
                @csrf

                                <div>
                    <label for="email" class="block font-heading font-bold text-xs tracking-widest uppercase text-premium-silver mb-2">Email Identity</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           class="w-full bg-premium-black/50 border border-white/10 text-white placeholder-premium-gray font-sans px-4 py-3 rounded-xl focus:outline-none focus:ring-1 focus:ring-premium-gold focus:border-premium-gold transition-all shadow-inner">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs font-sans" />
                </div>

                                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block font-heading font-bold text-xs tracking-widest uppercase text-premium-silver">Passkey</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[10px] font-heading font-bold uppercase tracking-wider text-premium-gray hover:text-white transition-colors">
                                Forgot passkey?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="w-full bg-premium-black/50 border border-white/10 text-white placeholder-premium-gray font-sans px-4 py-3 rounded-xl focus:outline-none focus:ring-1 focus:ring-premium-gold focus:border-premium-gold transition-all shadow-inner">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs font-sans" />
                </div>

                                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-white/10 bg-premium-black/50 text-premium-gold focus:ring-premium-gold focus:ring-offset-premium-black">
                    <label for="remember_me" class="ms-3 text-sm font-sans text-premium-gray">Remember signature</label>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full h-14 bg-gradient-to-r from-premium-gold to-yellow-600 text-premium-black hover:from-white hover:to-white font-heading font-bold uppercase tracking-widest text-sm rounded-xl transition-all duration-300 shadow-glow-gold flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        Initiate Session
                    </button>
                    
                    <div class="text-center mt-6">
                        <p class="text-xs font-sans text-premium-gray">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-premium-goldLight hover:text-white font-medium transition-colors">Apply for Access</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
