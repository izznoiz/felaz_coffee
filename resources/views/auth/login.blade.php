<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4 text-red-600 font-sans" /> @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 font-sans"> {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" class="font-sans text-coffee-dark" /> <x-input id="email" class="block mt-1 w-full border-gray-300 focus:border-coffee-medium focus:ring-coffee-medium rounded-md shadow-sm font-sans" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" class="font-sans text-coffee-dark" /> <x-input id="password" class="block mt-1 w-full border-gray-300 focus:border-coffee-medium focus:ring-coffee-medium rounded-md shadow-sm font-sans" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" class="form-checkbox h-4 w-4 text-coffee-medium border-gray-300 rounded focus:ring-coffee-medium" /> <span class="ms-2 text-sm text-gray-700 font-sans">{{ __('Remember me') }}</span> </label>
            </div>

            <div class="flex items-center justify-between mt-6"> @if (Route::has('password.request'))
                    <a class="underline text-sm text-coffee-medium hover:text-coffee-dark font-sans rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-coffee-medium" href="{{ route('password.request') }}"> {{ __('Forgot your password?') }}
                    </a>
                @endif

                <div class="flex items-center gap-3">

                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2 bg-latte-cream border border-transparent rounded-full font-semibold text-xs text-coffee-dark uppercase tracking-widest shadow-md hover:bg-coffee-light focus:outline-none focus:ring-2 focus:ring-coffee-medium focus:ring-offset-2 transition ease-in-out duration-150 font-sans"> {{ __('Register') }}
                </a>
                @endif

                <x-button class="ms-4 px-5 py-2 bg-coffee-medium border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest shadow-md hover:bg-coffee-dark focus:outline-none focus:ring-2 focus:ring-latte-cream focus:ring-offset-2 transition ease-in-out duration-150 font-sans"> {{ __('Log in') }}
                </x-button>
                </div>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>