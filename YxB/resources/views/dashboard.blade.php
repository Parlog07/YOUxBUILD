<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-3">
                    @if (session('success'))
                        <p class="text-green-600">{{ session('success') }}</p>
                    @endif

                    @if (session('error'))
                        <p class="text-red-600">{{ session('error') }}</p>
                    @endif

                    @if (! auth()->user()->vendorProfile)
                        <form action="{{ route('vendor.request') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md">Become a Vendor</button>
                        </form>
                    @elseif (auth()->user()->vendorProfile->status === 'pending')
                        <p>Your vendor request is pending approval.</p>
                    @elseif (auth()->user()->vendorProfile->status === 'approved')
                        <p>Your vendor account is approved.</p>
                    @elseif (auth()->user()->vendorProfile->status === 'rejected')
                        <p>Your vendor request was rejected.</p>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
