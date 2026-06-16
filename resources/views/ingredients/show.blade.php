<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Bahan
            </h2>

            <a href="{{ route('ingredients.index') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #4b5563; color: #ffffff;">
                Kembali ke Kelola Bahan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    Informasi Bahan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama Bahan</p>
                        <p class="text-lg font-semibold">{{ $ingredient->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Kategori</p>
                        <p class="text-lg font-semibold">{{ $ingredient->category ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Satuan</p>
                        <p class="text-lg font-semibold">{{ $ingredient->unit }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Status Stok</p>
                        <p class="text-lg font-semibold">{{ $ingredient->stock_status }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Stok Saat Ini</p>
                        <p class="text-lg font-semibold">
                            {{ number_format($ingredient->current_stock, 2, ',', '.') }}
                            {{ $ingredient->unit }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Stok Minimum</p>
                        <p class="text-lg font-semibold">
                            {{ number_format($ingredient->minimum_stock, 2, ',', '.') }}
                            {{ $ingredient->unit }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">
                    Riwayat Transaksi Bahan
                </h3>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">No</th>
                            <th class="p-3 border">Tanggal</th>
                            <th class="p-3 border">Tipe</th>
                            <th class="p-3 border">Jumlah</th>
                            <th class="p-3 border">Supplier</th>
                            <th class="p-3 border">Total Harga</th>
                            <th class="p-3 border">Dibuat Oleh</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($ingredient->stockTransactions as $index => $transaction)
                            <tr>
                                <td class="p-3 border">{{ $index + 1 }}</td>

                                <td class="p-3 border">
                                    {{ $transaction->transaction_date->format('d-m-Y') }}
                                </td>

                                <td class="p-3 border">
                                    {{ $transaction->type === 'in' ? 'Masuk' : 'Keluar' }}
                                </td>

                                <td class="p-3 border">
                                    {{ $transaction->quantity }} {{ $transaction->unit }}
                                </td>

                                <td class="p-3 border">
                                    {{ $transaction->supplier_name ?? '-' }}
                                </td>

                                <td class="p-3 border">
                                    Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
                                </td>

                                <td class="p-3 border">
                                    {{ $transaction->creator->name ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-3 border text-center text-gray-500">
                                    Belum ada transaksi untuk bahan ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>