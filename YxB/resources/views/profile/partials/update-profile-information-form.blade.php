<section>
    <header>
        <h2 class="text-lg font-heading font-bold uppercase tracking-widest text-white">
            {{ __('Core Profile Data') }}
        </h2>

        <p class="mt-1 text-sm font-sans text-premium-silver opacity-60 uppercase tracking-tighter">
            {{ __("Manage your primary account identity and email protocols.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="full_name" :value="__('Full Identity Name')" class="text-premium-silver uppercase tracking-widest text-[10px] font-bold mb-2" />
            <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full bg-premium-black/50 border-white/10 text-white focus:border-premium-gold focus:ring-premium-gold rounded-xl shadow-inner" :value="old('full_name', $user->full_name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-red-400 text-xs" :messages="$errors->get('full_name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Network Email Address')" class="text-premium-silver uppercase tracking-widest text-[10px] font-bold mb-2" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-premium-black/50 border-white/10 text-white focus:border-premium-gold focus:ring-premium-gold rounded-xl shadow-inner" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2 text-red-400 text-xs" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 rounded-xl bg-premium-gold/5 border border-premium-gold/20">
                    <p class="text-sm text-premium-goldLight font-medium">
                        {{ __('Identity verification required.') }}

                        <button form="send-verification" class="ml-2 text-white underline hover:text-premium-gold transition-colors">
                            {{ __('Transmit verification link.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-400">
                            {{ __('Verification protocol transmitted.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-white/5">
            <x-primary-button class="bg-premium-gold text-premium-black hover:bg-white transition-all shadow-glow-gold rounded-xl py-3 px-8 font-heading font-bold uppercase tracking-widest text-xs">
                {{ __('Confirm Changes') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-400 font-medium"
                >{{ __('Identity Refined.') }}</p>
            @endif
        </div>
    </form>
</section>
