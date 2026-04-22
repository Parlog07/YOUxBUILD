<section>
    <header>
        <h2 class="text-lg font-heading font-bold uppercase tracking-widest text-white">
            {{ __('Security Protocols') }}
        </h2>

        <p class="mt-1 text-sm font-sans text-premium-silver opacity-60 uppercase tracking-tighter">
            {{ __('Ensure your account is protected by a high-entropy passphrase.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Cipher')" class="text-premium-silver uppercase tracking-widest text-[10px] font-bold mb-2" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full bg-premium-black/50 border-white/10 text-white focus:border-premium-gold focus:ring-premium-gold rounded-xl shadow-inner" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Encryption Key')" class="text-premium-silver uppercase tracking-widest text-[10px] font-bold mb-2" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full bg-premium-black/50 border-white/10 text-white focus:border-premium-gold focus:ring-premium-gold rounded-xl shadow-inner" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Key')" class="text-premium-silver uppercase tracking-widest text-[10px] font-bold mb-2" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-premium-black/50 border-white/10 text-white focus:border-premium-gold focus:ring-premium-gold rounded-xl shadow-inner" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-white/5">
            <x-primary-button class="bg-premium-gold text-premium-black hover:bg-white transition-all shadow-glow-gold rounded-xl py-3 px-8 font-heading font-bold uppercase tracking-widest text-xs">
                {{ __('Update Security') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-400 font-medium"
                >{{ __('Encryption Refined.') }}</p>
            @endif
        </div>
    </form>
</section>
