<x-app-layout>
    <div class="py-12 relative z-10 w-full">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 mb-10">
            <div class="flex items-center justify-between">
                <h2 class="font-heading font-extrabold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-premium-goldLight to-premium-gold uppercase tracking-widest leading-tight">
                    {{ __('Identity Configuration') }}
                </h2>
                <p class="text-premium-silver font-sans text-[10px] uppercase tracking-widest opacity-60 bg-white/5 px-4 py-1 rounded-full border border-white/10">System Security Level: High</p>
            </div>
        </div>
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
                        <div class="p-8 sm:p-10 bg-premium-card/60 backdrop-blur-xl border border-white/5 shadow-glow-subtle sm:rounded-3xl relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <svg class="w-16 h-16 text-premium-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

                        <div class="p-8 sm:p-10 bg-premium-card/60 backdrop-blur-xl border border-white/5 shadow-glow-subtle sm:rounded-3xl relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <svg class="w-16 h-16 text-premium-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

                        <div class="p-8 sm:p-10 bg-red-950/20 backdrop-blur-xl border border-red-500/20 shadow-glow-red sm:rounded-3xl relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <svg class="w-16 h-16 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
