<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-xl font-semibold text-gray-800">
            Verifikasi Kode
        </h2>

        <p class="text-sm text-gray-600 mt-2">
            Masukkan kode 6 digit yang dikirim ke email:
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

    <form method="POST" action="{{ route('password.code.verify') }}">
        @csrf

        <div>
            <x-input-label for="code" value="Kode Verifikasi" />

            <x-text-input id="code"
                          class="block mt-1 w-full text-center text-lg tracking-widest"
                          type="text"
                          name="code"
                          maxlength="6"
                          placeholder="123456"
                          required
                          autofocus />

            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('password.request') }}"
               class="underline text-sm text-gray-600 hover:text-gray-900">
                Kirim Ulang
            </a>

            <x-primary-button>
                Verifikasi
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>