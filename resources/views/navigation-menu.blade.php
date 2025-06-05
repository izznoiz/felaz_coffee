<nav x-data="{ open: false }" class="fixed top-0 left-0 w-full bg-white bg-opacity-95 backdrop-blur-sm shadow-md z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
        <div class="shrink-0 flex items-center">
            <a href="{{ route('produk.index') }}" class="flex items-center text-gray-800 hover:text-gray-900 transition-colors duration-200">
                <img src="{{ asset('images/logo.jpg') }}" alt="Felaz Coffee Logo" class="block h-14 w-auto me-3 object-contain">
                <span class="font-bold text-2xl text-gray-800">Felaz Coffee</span>
            </a>
        </div>

        <div class="hidden sm:flex relative items-center bg-white shadow-lg rounded-full h-16 max-w-xl mx-auto md:ml-auto md:mr-auto px-4">
            <div class="flex flex-grow justify-center h-full">
                <div class="flex space-x-6 items-center h-full">
                    {{-- Link Home (selalu ada) --}}
                    <x-nav-link href="{{ route('produk.index') }}" :active="request()->routeIs('produk.index')"
                        class="{{ request()->routeIs('produk.index') ? 'text-amber-600 after:w-5' : 'text-gray-600 after:w-0' }} relative after:absolute after:bottom-0 after:left-1/2 after:-translate-x-1/2 after:h-0.5 after:bg-amber-600 after:rounded-full after:transition-all after:duration-300 hover:text-gray-800 hover:after:w-full transition-colors duration-200 h-full flex items-center px-4">
                        {{ __('Home') }}
                    </x-nav-link>

                    {{-- Riwayat Pesanan (hanya jika user adalah 'pelanggan' dan login) --}}
                    @if(auth()->check() && auth()->user()->role === 'pelanggan')
                        <x-nav-link href="{{ route('orders.index') }}" :active="request()->routeIs('orders.index')"
                            class="{{ request()->routeIs('orders.index') ? 'text-amber-600 after:w-5' : 'text-gray-600 after:w-0' }} relative after:absolute after:bottom-0 after:left-1/2 after:-translate-x-1/2 after:h-0.5 after:bg-amber-600 after:rounded-full after:transition-all after:duration-300 hover:text-gray-800 hover:after:w-full transition-colors duration-200 h-full flex items-center px-4">
                            {{ __('Riwayat Pesanan') }}
                        </x-nav-link>
                    @endif

                    {{-- tombol tambah produk admin --}}
                    @if(auth()->user()->role === 'admin')
                    <x-nav-link href="{{ route('produk.create') }}" :active="request()->routeIs('produk.create')"
                            class="{{ request()->routeIs('produk.create') ? 'text-amber-600 after:w-5' : 'text-gray-600 after:w-0' }} relative after:absolute after:bottom-0 after:left-1/2 after:-translate-x-1/2 after:h-0.5 after:bg-amber-600 after:rounded-full after:transition-all after:duration-300 hover:text-gray-800 hover:after:w-full transition-colors duration-200 h-full flex items-center px-4">
                            {{ __('Tambah Produk') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-4 ml-auto"> {{-- Menggunakan ml-auto untuk dorong ke kanan --}}
            {{-- Ikon Keranjang (hanya jika user adalah 'pelanggan') --}}
            @if(auth()->check() && auth()->user()->role === 'pelanggan')
                <a href="{{ route('cart.index') }}" class="relative flex items-center p-2 rounded-full text-gray-700 hover:text-orange-600 hover:bg-gray-100 transition duration-300 group">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.182 1.705.707 1.705H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 110 4 2 2 0 010-4z"></path>
                    </svg>
                </a>
            @endif

            {{-- Ikon Akun / Login-Register (tergantung status login) --}}
            @auth
                {{-- Dropdown Akun jika user sudah login (menggunakan Jetstream/Livewire dropdown) --}}
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}
                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-600 font-semibold py-2 px-3 rounded-full transition duration-300">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-3 rounded-full transition duration-300">
                    {{ __('Register') }}
                </a>
            @endauth

            <div class="-mr-2 flex items-center sm:hidden"> {{-- Penyesuaian untuk hamburger menu --}}
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden absolute top-full left-0 w-full bg-white shadow-lg">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="text-gray-800 hover:bg-gray-100">
                {{ __('Home') }}
            </x-responsive-nav-link>

            @if(auth()->check() && auth()->user()->role === 'pelanggan')
                <x-responsive-nav-link href="{{ route('orders.index') }}" :active="request()->routeIs('orders.index')" class="text-gray-800 hover:bg-gray-100">
                    {{ __('Riwayat Pesanan') }}
                </x-responsive-nav-link>
            @endif

            {{-- Anda bisa tambahkan link lain di sini jika perlu untuk mobile --}}
            {{-- Misalnya: About Us, Shop, Blog, dll. --}}
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="shrink-0 me-3">
                            <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif
                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" class="text-gray-800 hover:bg-gray-100">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')" class="text-gray-800 hover:bg-gray-100">
                            {{ __('API Tokens') }}
                        </x-responsive-nav-link>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();" class="text-gray-800 hover:bg-gray-100">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>

                    {{-- Bagian Team Management (jika aktif di Jetstream) --}}
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="border-t border-gray-200"></div>
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Team') }}
                        </div>
                        <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')" class="text-gray-800 hover:bg-gray-100">
                            {{ __('Team Settings') }}
                        </x-responsive-nav-link>
                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')" class="text-gray-800 hover:bg-gray-100">
                                {{ __('Create New Team') }}
                            </x-responsive-nav-link>
                        @endcan
                        @if (Auth::user()->allTeams()->count() > 1)
                            <div class="border-t border-gray-200"></div>
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Switch Teams') }}
                            </div>
                            @foreach (Auth::user()->allTeams() as $team)
                                <x-switchable-team :team="$team" component="responsive-nav-link" />
                            @endforeach
                        @endif
                    @endif
                </div>
            @else
                <div class="px-4 py-2 space-y-1">
                    <x-responsive-nav-link href="{{ route('login') }}" class="text-gray-800 hover:bg-gray-100">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('register') }}" class="text-white bg-amber-600 hover:bg-amber-700">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>