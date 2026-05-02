<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-premium-black/80 backdrop-blur-xl border-b border-white/10">
    @php
        $user = Auth::user();
        $links = [];

        if ($user) {
            $links = [
                ['label' => 'Dashboard', 'route' => 'dashboard'],
                ['label' => 'Products', 'route' => 'products.index'],
                ['label' => 'Prebuilt PCs', 'route' => 'products.prebuilt'],
            ];

            if ($user->role === 'client') {
                $links[] = ['label' => 'Cart', 'route' => 'cart.index'];
                $links[] = ['label' => 'My Orders', 'route' => 'orders.index'];
            }

            if ($user->role === 'vendor' && $user->vendorProfile?->status === 'approved') {
                $links[] = ['label' => 'My Products', 'route' => 'vendor.products.index'];
                $links[] = ['label' => 'Build PC', 'route' => 'vendor.products.prebuilt.create'];
                $links[] = ['label' => 'Vendor Orders', 'route' => 'vendor.orders'];
            }

            if ($user->role === 'admin') {
                $links[] = ['label' => 'Admin Orders', 'route' => 'admin.orders'];
                $links[] = ['label' => 'Categories', 'route' => 'categories.index'];
                $links[] = ['label' => 'Vendor Requests', 'route' => 'admin.vendors.index'];
            }
        } else {
            $links = [
                ['label' => 'Home', 'route' => 'home'],
                ['label' => 'Products', 'route' => 'products.index'],
                ['label' => 'Prebuilt PCs', 'route' => 'products.prebuilt'],
                ['label' => 'Login', 'route' => 'login'],
                ['label' => 'Register', 'route' => 'register'],
            ];
        }
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
                        <a href="{{ route('home') }}" class="flex items-center gap-4 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-premium-gold to-yellow-700 flex items-center justify-center shadow-glow-gold transition-transform group-hover:scale-105 duration-300">
                    <svg viewBox="0 0 40 40" class="w-6 h-6 text-premium-black fill-current">
                        <path d="M4 4h9.5l6.5 12V36h-5V18.5L5 5H4V4z"/>
                        <path d="M36 4h-9.5l-6.5 12V36h5V18.5L35 5h1V4z"/>
                    </svg>
                </div>
                <span class="font-heading font-bold text-xl tracking-[0.15em] text-white">YOUXBUILD</span>
            </a>

                        <div class="hidden sm:flex items-center space-x-8">
                @foreach ($links as $link)
                    @php $isActive = request()->routeIs($link['route']); @endphp
                    <a href="{{ route($link['route']) }}" 
                       class="font-sans text-sm font-medium transition-colors duration-300 {{ $isActive ? 'text-premium-gold' : 'text-premium-gray hover:text-white' }}">
                        {{ __($link['label']) }}
                    </a>
                @endforeach
            </div>

                        @if ($user)
                <div class="hidden sm:flex sm:items-center sm:ms-6 border-l border-white/10 pl-6 h-10 my-auto">
                                        <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-2 text-premium-silver hover:text-premium-gold transition-colors focus:outline-none">
                            <span class="flex flex-col text-right">
                                <span class="text-sm font-sans font-medium leading-none mb-1 text-white">{{ $user->full_name }}</span>
                                <span class="text-[10px] uppercase tracking-widest font-heading text-premium-gold leading-none">{{ $user->role }}</span>
                            </span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                                                <div x-show="dropdownOpen" 
                             style="display: none;"
                             class="absolute right-0 mt-4 w-48 bg-premium-card border border-white/10 shadow-glow-subtle rounded-xl py-2 z-50 overflow-hidden">
                            
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-premium-silver font-sans hover:bg-white/5 hover:text-white transition-colors">
                                {{ __('Profile') }}
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-premium-silver font-sans hover:bg-white/5 hover:text-white transition-colors">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

                        <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-premium-gray hover:text-white focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

        <div x-show="open" style="display: none;" class="sm:hidden bg-premium-card border-t border-white/5">
        <div class="pt-2 pb-3 space-y-1">
            @foreach ($links as $link)
                @php $isActive = request()->routeIs($link['route']); @endphp
                <a href="{{ route($link['route']) }}" class="block ps-3 pe-4 py-2 border-l-4 {{ $isActive ? 'border-premium-gold text-premium-gold' : 'border-transparent text-premium-gray hover:bg-white/5 hover:text-white hover:border-premium-silver' }} text-base font-medium transition duration-150 ease-in-out font-sans">
                    {{ __($link['label']) }}
                </a>
            @endforeach
        </div>

        @if ($user)
            <div class="pt-4 pb-1 border-t border-white/5">
                <div class="px-4">
                    <div class="font-sans font-medium text-base text-white">{{ $user->full_name }}</div>
                    <div class="font-heading font-bold text-xs text-premium-gold uppercase tracking-widest mt-1">{{ $user->role }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-premium-gray hover:text-white hover:bg-white/5 hover:border-premium-silver transition duration-150 ease-in-out font-sans">
                        {{ __('Profile') }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-premium-gray hover:text-white hover:bg-white/5 hover:border-premium-silver transition duration-150 ease-in-out font-sans">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</nav>
