<section class="space-y-6">
    <header>
        <h2 class="text-lg font-heading font-bold uppercase tracking-widest text-red-500">
            {{ __('Terminal Deletion') }}
        </h2>

        <p class="mt-1 text-sm font-sans text-red-400 opacity-60 uppercase tracking-tighter">
            {{ __('Once your account is purged, all associated data will be permanently erased from the neural network.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600/20 border border-red-500/30 text-red-400 hover:bg-red-500 hover:text-white transition-all shadow-glow-red rounded-xl py-3 px-8 font-heading font-bold uppercase tracking-widest text-xs"
    >{{ __('Initiate Purge') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-premium-black border border-white/5 rounded-3xl">
            @csrf
            @method('delete')

            <h2 class="text-xl font-heading font-extrabold text-white uppercase tracking-widest text-center mb-4">
                {{ __('Final Authorization') }}
            </h2>

            <p class="text-sm font-sans text-premium-silver text-center mb-8 leading-relaxed">
                {{ __('Are you absolutely sure you want to delete your account? This protocol is irreversible. Please enter your passphrase to confirm.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Identity Passphrase') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full bg-premium-black/50 border-white/10 text-white focus:border-red-500 focus:ring-red-500 rounded-xl shadow-inner text-center py-4"
                    placeholder="{{ __('Enter Passphrase') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-400 text-xs text-center" />
            </div>

            <div class="mt-8 flex justify-center gap-4">
                <x-secondary-button x-on:click="$dispatch('close')" class="bg-white/5 border-white/10 text-white hover:bg-white/10 rounded-xl px-8 py-3 font-heading font-bold uppercase tracking-widest text-xs">
                    {{ __('Abort') }}
                </x-secondary-button>

                <x-danger-button class="bg-red-600 text-white hover:bg-red-700 shadow-glow-red rounded-xl px-8 py-3 font-heading font-bold uppercase tracking-widest text-xs">
                    {{ __('Execute Purge') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
