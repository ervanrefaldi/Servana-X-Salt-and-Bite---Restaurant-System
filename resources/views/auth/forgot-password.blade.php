<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-xl font-semibold text-gray-800">
            Lupa Kata Sandi
        </h2>

        <p class="text-sm text-gray-600 mt-2">
            Masukkan email akun Anda. Sistem akan mengirimkan kode atur ulang kata sandi ke email tersebut.
        </p>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('status'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('status') }}
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

    <form method="POST" action="{{ route('password.send.code') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />

            <x-text-input id="email"
                          class="block mt-1 w-full"
                          type="email"
                          name="email"
                          value="{{ old('email') }}"
                          required
                          autofocus />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('login') }}"
               class="underline text-sm text-gray-600 hover:text-gray-900">
                Kembali ke Masuk
            </a>

            <x-primary-button>
                Kirim Kode
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
