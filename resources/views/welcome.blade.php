<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servana</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@include('partials.public-navbar')
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
   
    {{-- Hero Section --}}
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

            <div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 leading-tight">
                    Selamat Datang di Servana
                </h2>

                <p class="mt-5 text-lg text-gray-600">
                    Servana adalah sistem informasi layanan restoran berbasis website
                    yang membantu pelanggan melihat menu, melakukan reservasi, dan
                    mendukung pengelolaan operasional restoran.
                </p>

                <div class="mt-8 flex gap-4">
                    <a href="{{ route('public.menu') }}"
                       class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Lihat Menu
                    </a>

                    <a href="{{ route('reservations.create') }}"
                       class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Buat Reservasi
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">
                    Layanan Utama
                </h3>

                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded-md">
                        <h4 class="font-semibold text-gray-800">Lihat Menu</h4>
                        <p class="text-gray-600 text-sm">
                            Customer dan member dapat melihat daftar menu yang tersedia.
                        </p>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-md">
                        <h4 class="font-semibold text-gray-800">Reservasi Meja</h4>
                        <p class="text-gray-600 text-sm">
                            Customer dapat reservasi tanpa login, sedangkan member dapat memilih meja.
                        </p>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-md">
                        <h4 class="font-semibold text-gray-800">Membership</h4>
                        <p class="text-gray-600 text-sm">
                            Member mendapatkan keuntungan seperti pemilihan meja dan diskon transaksi.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-white border-t mt-10">
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-sm text-gray-500">
            © {{ date('Y') }} Servana. Sistem Informasi Manajemen Layanan Restoran.
        </div>
    </footer>

</body>
</html>