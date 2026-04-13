<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(!auth()->user()->vendorProfile)
        <form action="{{ route('vendor.request') }}" method="POST">
            @csrf
            <button type="submit">Become a Vendor</button>
        </form>

        @elseif(auth()->user()->vendorProfile->status === 'pending')
            <p>Your request is pending approval</p>

        @elseif(auth()->user()->vendorProfile->status === 'approved')
            <p>You are a vendor</p>

        @elseif(auth()->user()->vendorProfile->status === 'rejected')
            <p>Your request was rejected</p>
        @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
