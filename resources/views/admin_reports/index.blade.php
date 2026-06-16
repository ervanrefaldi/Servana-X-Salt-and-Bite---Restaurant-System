<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pusat Laporan Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-2">
                    Pusat Laporan Servana
                </h3>

                <p class="text-gray-600">
                    Halaman ini digunakan admin untuk melihat dan mencetak laporan sistem.
                    Untuk tahap awal, laporan yang dibuat terlebih dahulu adalah laporan keuangan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">
                        Laporan Keuangan
                    </h3>

                    <p class="text-sm text-gray-600 mb-4">
                        Berisi pemasukan, pengeluaran, kategori transaksi, sumber transaksi,
                        dan total saldo.
                    </p>

                    <a href="{{ route('admin.reports.financial') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold"
                       style="background-color: #2563eb; color: #ffffff;">
                        Buka Laporan
                    </a>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg opacity-70">
                    <h3 class="text-lg font-semibold mb-2">
                        Laporan POS
                    </h3>

                    <p class="text-sm text-gray-600 mb-4">
                        Laporan transaksi kasir akan dibuat pada tahap berikutnya.
                    </p>

                    <button disabled
                            class="px-4 py-2 rounded-md text-sm font-semibold bg-gray-400 text-white">
                        Segera Dibuat
                    </button>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg opacity-70">
                    <h3 class="text-lg font-semibold mb-2">
                        Laporan Reservasi
                    </h3>

                    <p class="text-sm text-gray-600 mb-4">
                        Laporan reservasi akan dibuat setelah laporan keuangan selesai.
                    </p>

                    <button disabled
                            class="px-4 py-2 rounded-md text-sm font-semibold bg-gray-400 text-white">
                        Segera Dibuat
                    </button>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>