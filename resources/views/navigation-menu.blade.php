<nav x-data="{ open: false }" class="fixed top-0 left-0 w-full bg-white/90 backdrop-blur-lg shadow-lg z-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 flex justify-between items-center h-20">
        {{-- Logo --}}
        <div class="flex items-center space-x-4">
            @php
                $user = auth()->user();
                $homeRoute = $user && $user->role === 'admin' ? route('admin.produk.index') : route('produk.index');
            @endphp

            <div class="flex items-center space-x-4">
                <a href="{{ $homeRoute }}" class="flex items-center">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Felaz Coffee Logo" class="h-14 w-14 object-cover rounded-full shadow-md">
                    <span class="ml-3 text-2xl font-bold tracking-tight text-amber-700">Felaz Coffee</span>
                </a>
            </div>

        </div>

        {{-- Menu Tengah --}}
        <div class="hidden md:flex items-center space-x-8">
            @php
                $user = auth()->user();
                $isPelanggan = $user && $user->role === 'pelanggan';
                $routeName = $isPelanggan ? 'produk.index' : 'admin.produk.index';
            @endphp

            <x-nav-link href="{{ route($routeName) }}" :active="request()->routeIs($routeName)" class="nav-menu-item">
                {{ __('Home') }}
            </x-nav-link>

            @if(auth()->check() && $user->role === 'pelanggan')
                <x-nav-link href="{{ route('orders.index') }}" :active="request()->routeIs('orders.index')" class="nav-menu-item">
                    {{ __('Riwayat Pesanan') }}
                </x-nav-link>
            @endif

            @if(auth()->check() && $user->role === 'admin')
                <x-nav-link href="{{ route('produk.create') }}" :active="request()->routeIs('produk.create')" class="nav-menu-item">
                    {{ __('Tambah Produk') }}
                </x-nav-link>
            @endif

            @if(auth()->check() && $user->role === 'admin')
                <x-nav-link href="{{ route('admin.orders.index') }}" :active="request()->routeIs('admin.orders.index')" class="nav-menu-item">
                    {{ __('Pesanan') }}
                </x-nav-link>
            @endif
        </div>

        {{-- Menu Kanan --}}
        <div class="flex items-center space-x-4">
            @if(auth()->check() && auth()->user()->role === 'pelanggan')
                <a href="{{ route('cart.index') }}" class="relative group p-2 text-gray-700 hover:text-amber-600 transition">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2.3 2.3c-.6.6-.2 1.7.7 1.7H17m0 0a2 2 0 100 4 2 2 0 000-4zM9 19a2 2 0 100 4 2 2 0 000-4z" />
                    </svg>
                </a>
            @endif

            {{-- Akun --}}
            @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                            <button class="text-sm font-medium text-gray-700 hover:text-gray-900">
                                {{ Auth::user()->name }}
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('profile.show') }}">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 font-semibold hover:text-amber-600 transition">Login</a>
                <a href="{{ route('register') }}" class="bg-amber-600 text-white font-semibold py-2 px-4 rounded-full hover:bg-amber-700 transition">Register</a>
            @endauth

            {{-- Hamburger --}}
            <div class="md:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="md:hidden px-4 pt-2 pb-4 space-y-2 bg-white border-t border-gray-200">
        <x-responsive-nav-link href="{{ route($routeName) }}" :active="request()->routeIs($routeName)">
            {{ __('Home') }}
        </x-responsive-nav-link>

        @if(auth()->check() && $user->role === 'pelanggan')
            <x-responsive-nav-link href="{{ route('orders.index') }}" :active="request()->routeIs('orders.index')">
                {{ __('Riwayat Pesanan') }}
            </x-responsive-nav-link>
        @endif

         @if(auth()->check() && $user->role === 'admin')
                <x-responsive-nav-link href="{{ route('produk.create') }}" :active="request()->routeIs('produk.create')">
                    {{ __('Tambah Produk') }}
                </x-responsive-nav-link>
            @endif

            @if(auth()->check() && $user->role === 'admin')
                <x-responsive-nav-link href="{{ route('admin.orders.index') }}" :active="request()->routeIs('admin.orders.index')">
                    {{ __('Pesanan') }}
                </x-responsive-nav-link>
            @endif

        @auth
            <x-responsive-nav-link href="{{ route('profile.show') }}">
                {{ __('Profile') }}
            </x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        @else
            <x-responsive-nav-link href="{{ route('login') }}">{{ __('Login') }}</x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('register') }}">{{ __('Register') }}</x-responsive-nav-link>
        @endauth
    </div>
</nav>
