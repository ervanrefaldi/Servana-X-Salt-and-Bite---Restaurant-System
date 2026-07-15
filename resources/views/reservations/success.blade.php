<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reservasi Berhasil - Servana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.favicon')
</head>

<body class="bg-gray-100 text-gray-900">

    @include('partials.public-navbar')

    <main class="py-10">
        <div class="max-w-3xl mx-auto px-6">

            <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                <h1 class="text-2xl font-bold text-green-600 mb-3">
                    Reservasi Berhasil
                </h1>

                <p class="text-gray-600 mb-4">
                    Terima kasih. Reservasi Anda berhasil dibuat dan menunggu konfirmasi dari resepsionis.
                </p>

                @if (session('reservation_code'))
                    <div class="p-4 bg-blue-50 text-blue-700 rounded mb-4">
                        <p class="font-semibold">
                            Kode Reservasi Anda:
                        </p>
                        <p class="text-2xl font-bold">
                            {{ session('reservation_code') }}
                        </p>
                    </div>
                @endif

                <div class="flex justify-center gap-3 mt-6">
                    <a href="{{ url('/') }}"
                       class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                        Kembali ke Home
                    </a>

                    <a href="{{ route('reservations.create') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Buat Reservasi Lagi
                    </a>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
