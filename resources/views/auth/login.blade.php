<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">
            Login Servana
        </h2>
        <p class="text-sm text-gray-600 mt-2">
            Masuk sesuai akun dan role Anda.
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-[#a01a1d] shadow-sm focus:ring-[#a01a1d]" name="remember">

                <span class="ms-2 text-sm text-gray-600">
                    Remember me
                </span>
            </label>
        </div>

        <!-- Login Action -->
        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md"
                    href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif

            <x-primary-button>
                LOG IN
            </x-primary-button>
        </div>
    </form>

    <!-- Register Member Section -->
    <div class="mt-6 pt-5 border-t border-gray-200 text-center">
        <p class="text-sm text-gray-600 mb-3">
            Belum punya akun member?
        </p>

        <a href="{{ route('register') }}"
            class="block w-full text-center px-4 py-3 rounded-md font-semibold text-sm transition border border-[#a01a1d] text-[#a01a1d] hover:bg-[#a01a1d] hover:text-white">
            Daftar Sebagai Member
        </a>

        <p class="text-xs text-gray-500 mt-3">
            Member mendapatkan diskon 5% dan dapat memilih meja saat reservasi.
        </p>
    </div>
</x-guest-layout>
