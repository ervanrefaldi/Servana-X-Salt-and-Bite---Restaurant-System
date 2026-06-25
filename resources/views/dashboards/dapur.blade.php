<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Dapur
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-2">
                    Selamat datang, Staff Dapur
                </h3>

                <p class="text-gray-600">
                    Anda dapat mengelola master bahan, mencatat bahan masuk, mencatat bahan keluar,
                    dan memantau stok bahan yang menipis.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Bahan</p>
                    <h3 class="text-2xl font-bold">
                        {{ $totalIngredients ?? 0 }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Stok Menipis</p>
                    <h3 class="text-2xl font-bold text-yellow-600">
                        {{ $lowStockIngredients ?? 0 }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Stok Habis</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        {{ $emptyStockIngredients ?? 0 }}
                    </h3>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Transaksi Masuk</p>
                    <h3 class="text-2xl font-bold text-green-600">
                        {{ $stockIn ?? 0 }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Transaksi Keluar</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        {{ $stockOut ?? 0 }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Pembelian Bahan Bulan Ini</p>
                    <h3 class="text-2xl font-bold">
                        Rp{{ number_format($monthlyPurchaseCost ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">
                    Menu Dapur
                </h3>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('menus.index') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #ec4899; color: #ffffff;">
                        Kelola Menu
                    </a>

                    <a href="{{ route('ingredients.index') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #2563eb; color: #ffffff;">
                        Kelola Bahan
                    </a>

                    <a href="{{ route('stock-transactions.index') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #16a34a; color: #ffffff;">
                        Riwayat Transaksi Stok
                    </a>

                    <a href="{{ route('stock-transactions.create') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #f59e0b; color: #ffffff;">
                        Tambah Transaksi Stok
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>