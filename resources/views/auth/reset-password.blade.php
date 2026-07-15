<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-xl font-semibold text-gray-800">
            Buat Kata Sandi Baru
        </h2>

        <p class="text-sm text-gray-600 mt-2">
            Masukkan kata sandi baru untuk akun:
        </p>

        <p class="font-semibold text-gray-800 mt-1">
            {{ session('reset_email') }}
        </p>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.reset.update') }}">
        @csrf

        <div>
            <x-input-label for="password" value="Kata Sandi Baru" />

            <x-text-input id="password"
                          class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi Baru" />

            <x-text-input id="password_confirmation"
                          class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation"
                          required />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('login') }}"
               class="underline text-sm text-gray-600 hover:text-gray-900">
                Kembali ke Masuk
            </a>

            <x-primary-button>
                Simpan Kata Sandi
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
