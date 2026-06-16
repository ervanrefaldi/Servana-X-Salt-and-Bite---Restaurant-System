<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Member - Servana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">

    @include('partials.public-navbar')

    <main class="py-10">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Dashboard Member
                </h1>
                <p class="text-gray-600 mt-1">
                    Selamat datang, {{ auth()->user()->name }}. Kelola aktivitas membership Anda di Servana.
                </p>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Card Selamat Datang --}}
            <div class="bg-white p-6 shadow-sm rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-2">
                    Selamat datang, {{ auth()->user()->name }}
                </h3>

                <p class="text-gray-600">
                    Anda dapat melihat menu, promo, dan melakukan reservasi dengan memilih meja.
                </p>

                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('public.menu') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Lihat Menu
                    </a>

                    <a href="{{ route('reservations.create') }}"
                       class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Buat Reservasi
                    </a>

                    <a href="{{ route('member.profile') }}"
                       class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                        Profile Saya
                    </a>
                </div>
            </div>

            {{-- Card Membership --}}
            <div class="bg-white p-6 shadow-sm rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    Informasi Membership
                </h3>

                @if (isset($customer) && $customer)
                    <div class="p-4 bg-blue-50 text-blue-700 rounded">
                        <p class="font-semibold">
                            Kode Membership Anda:
                        </p>

                        <p class="text-2xl font-bold mt-1">
                            {{ $customer->member_code }}
                        </p>

                        <p class="text-sm mt-2">
                            Gunakan kode ini saat melakukan transaksi di kasir untuk mendapatkan diskon 5%.
                        </p>
                    </div>
                @else
                    <div class="p-4 bg-yellow-50 text-yellow-700 rounded">
                        Data membership belum ditemukan. Silakan hubungi admin.
                    </div>
                @endif
            </div>

            {{-- Keuntungan Member --}}
            <div class="bg-white p-6 shadow-sm rounded-lg">
                <h3 class="text-lg font-semibold mb-4">
                    Keuntungan Member
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 border rounded-lg">
                        <h4 class="font-semibold text-gray-800">
                            Diskon 5%
                        </h4>
                        <p class="text-sm text-gray-600 mt-1">
                            Member mendapatkan potongan harga 5% dari total transaksi.
                        </p>
                    </div>

                    <div class="p-4 border rounded-lg">
                        <h4 class="font-semibold text-gray-800">
                            Pilih Meja Reservasi
                        </h4>
                        <p class="text-sm text-gray-600 mt-1">
                            Member dapat memilih meja secara manual saat melakukan reservasi.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>

</html>