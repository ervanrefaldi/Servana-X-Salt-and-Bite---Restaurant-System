<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Transaksi Stok
            </h2>

            <a href="{{ route('stock-transactions.index') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #4b5563; color: #ffffff;">
                Kembali ke Riwayat Stok
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Nama Bahan</p>
                    <p class="text-lg font-semibold">
                        {{ $stockTransaction->ingredient->name ?? $stockTransaction->ingredient_name }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Supplier</p>
                    <p class="text-lg font-semibold">
                        {{ $stockTransaction->supplier_name ?? '-' }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Tipe</p>
                    <p class="text-lg font-semibold">
                        @if ($stockTransaction->type === 'in')
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-sm">
                                Masuk
                            </span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-sm">
                                Keluar
                            </span>
                        @endif
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Jumlah</p>
                    <p class="text-lg font-semibold">
                        {{ number_format($stockTransaction->quantity, 2, ',', '.') }}
                        {{ $stockTransaction->unit }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Harga Satuan</p>
                    <p class="text-lg font-semibold">
                        Rp{{ number_format($stockTransaction->unit_price, 0, ',', '.') }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Total Harga</p>
                    <p class="text-lg font-semibold">
                        Rp{{ number_format($stockTransaction->total_price, 0, ',', '.') }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Tanggal</p>
                    <p class="text-lg font-semibold">
                        {{ $stockTransaction->transaction_date->format('d-m-Y') }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Dibuat Oleh</p>
                    <p class="text-lg font-semibold">
                        {{ $stockTransaction->creator->name ?? '-' }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Deskripsi</p>
                    <p class="text-lg">
                        {{ $stockTransaction->description ?? '-' }}
                    </p>
                </div>

                @if ($stockTransaction->ingredient)
                    <div class="mt-6 p-4 bg-blue-50 text-blue-700 rounded">
                        <p class="font-semibold">
                            Stok bahan saat ini:
                        </p>

                        <p class="text-xl font-bold">
                            {{ number_format($stockTransaction->ingredient->current_stock, 2, ',', '.') }}
                            {{ $stockTransaction->ingredient->unit }}
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>