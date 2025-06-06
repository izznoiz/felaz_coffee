<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-latte-cream py-12 px-4 sm:px-6 lg:px-8">
        <div
            class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 gap-8 shadow-xl bg-white rounded-2xl overflow-hidden">

            <!-- Left Image / Illustration -->
            <div class="hidden md:flex items-center justify-center bg-coffee-light">
                <img src="{{ asset('images/coffee_icon.svg') }}" alt="Daftar Kopi" class="object-cover h-full w-full">
            </div>

            <!-- Right Form -->
            <div class="p-8 sm:p-12">
                <div class="flex justify-center mb-6">
                    <x-authentication-card-logo class="mx-auto h-16 w-auto" />
                </div>

                <div class="text-center mb-6">
                    <h2 class="mt-6 text-3xl font-extrabold text-coffee-dark font-sans">Bergabung ke Felaz Coffee</h2>
                    <p class="mt-2 text-sm text-gray-600 font-sans">Daftar akun untuk mulai menikmati menu favoritmu.
                    </p>
                </div>

                <x-validation-errors class="mb-4 text-red-600 font-sans" />

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-label for="name" value="Nama Lengkap" class="font-sans text-coffee-dark" />
                        <x-input id="name"
                            class="block mt-1 w-full  border-gray-300 focus:border-coffee-medium focus:ring-coffee-medium rounded-md shadow-sm font-sans"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>

                    <div>
                        <x-label for="email" value="Email" class="font-sans text-coffee-dark" />
                        <x-input id="email"
                            class="block mt-1 w-full  border-gray-300 focus:border-coffee-medium focus:ring-coffee-medium rounded-md shadow-sm font-sans"
                            type="email" name="email" :value="old('email')" required autocomplete="username" />
                    </div>

                    <div>
                        <x-label for="password" value="Password" class="font-sans text-coffee-dark" />
                        <x-input id="password"
                            class="block mt-1 w-full  border-gray-300 focus:border-coffee-medium focus:ring-coffee-medium rounded-md shadow-sm font-sans"
                            type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <div>
                        <x-label for="password_confirmation" value="Konfirmasi Password"
                            class="font-sans text-coffee-dark" />
                        <x-input id="password_confirmation"
                            class="block mt-1 w-full  border-gray-300 focus:border-coffee-medium focus:ring-coffee-medium rounded-md shadow-sm font-sans"
                            type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                        <div>
                                            <label for="terms" class="flex items-center">
                                                <x-checkbox name="terms" id="terms" required />
                                                <span class="ml-2 text-sm text-gray-700 font-sans">
                                                    {!! __('Saya setuju dengan :terms_of_service dan :privacy_policy', [
                            'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '" class="underline text-sm text-coffee-medium hover:text-coffee-dark">' . __('Syarat Layanan') . '</a>',
                            'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '" class="underline text-sm text-coffee-medium hover:text-coffee-dark">' . __('Kebijakan Privasi') . '</a>',
                        ]) !!}
                                                </span>
                                            </label>
                                        </div>
                    @endif

                    <div class="flex items-center justify-between mt-6">
                        <a class="text-sm text-gray-600 hover:text-coffee-dark underline font-sans"
                            href="{{ route('login') }}">
                            Sudah punya akun?
                        </a>

                        <x-button
                            class="px-5 py-2 bg-coffee-medium text-white rounded-full font-semibold text-xs uppercase tracking-widest shadow hover:bg-coffee-dark focus:outline-none focus:ring-2 focus:ring-latte-cream focus:ring-offset-2 transition ease-in-out duration-150 font-sans">
                            Daftar
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>