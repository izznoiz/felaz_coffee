<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-latte-cream py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 gap-8 shadow-xl bg-white rounded-2xl overflow-hidden">

            <!-- Left Image / Illustration -->
            <div class="hidden md:flex items-center justify-center bg-coffee-light">
                <img src="{{ asset('images/coffee_icon.svg') }}" alt="Kopi" class="object-cover h-full w-full">
            </div>

            <!-- Right Form -->
            <div class="p-8 sm:p-12">
                <div class="flex justify-center mb-6">
                    <x-authentication-card-logo class="mx-auto h-16 w-auto" />
                </div>

                <div class="text-center mb-6">
                    <h2 class="mt-6 text-3xl font-extrabold text-coffee-dark font-sans">Masuk ke Felaz Coffee</h2>
                    <p class="mt-2 text-sm text-gray-600 font-sans">Selamat datang kembali! Silakan login untuk memesan menu favoritmu.</p>
                </div>

                <x-validation-errors class="mb-4 text-red-600 font-sans" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 font-sans">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-label for="email" value="Email" class="font-sans text-coffee-dark" />
                        <x-input id="email" class="block mt-1 w-full  border-gray-300 focus:border-coffee-medium focus:ring-coffee-medium rounded-md shadow-sm font-sans" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div>
                        <x-label for="password" value="Password" class="font-sans text-coffee-dark" />
                        <x-input id="password" class="block mt-1 w-full  border-gray-300 focus:border-coffee-medium focus:ring-coffee-medium rounded-md shadow-sm font-sans" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="flex items-center justify-between">
                    

                        @if (Route::has('password.request'))
                            <a class="text-sm text-coffee-medium hover:text-coffee-dark underline font-sans" href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2 bg-latte-cream border border-transparent rounded-full font-semibold text-xs text-coffee-dark uppercase tracking-widest shadow hover:bg-coffee-light focus:outline-none focus:ring-2 focus:ring-coffee-medium focus:ring-offset-2 transition ease-in-out duration-150 font-sans">
                                Daftar
                            </a>
                        @endif

                        <x-button class="px-5 py-2 bg-coffee-medium text-white rounded-full font-semibold text-xs uppercase tracking-widest shadow hover:bg-coffee-dark focus:outline-none focus:ring-2 focus:ring-latte-cream focus:ring-offset-2 transition ease-in-out duration-150 font-sans">
                            Masuk
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
