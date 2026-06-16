<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Riwayat Transaksi Stok
            </h2>

            <a href="{{ route('dapur.dashboard') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #2563eb; color: #ffffff;">
                Kembali ke Dashboard Dapur
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Transaksi Masuk</p>
                    <h3 class="text-2xl font-bold text-green-600">
                        {{ $totalStockIn }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Transaksi Keluar</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        {{ $totalStockOut }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Biaya Pembelian</p>
                    <h3 class="text-2xl font-bold">
                        Rp{{ number_format($totalPurchaseCost, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('ingredients.index') }}"
                   class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                   style="background-color: #4b5563; color: #ffffff;">
                    Kelola Bahan
                </a>

                <a href="{{ route('stock-transactions.create') }}"
                   class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                   style="background-color: #16a34a; color: #ffffff;">
                    Tambah Transaksi Stok
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-4 border">No</th>
                            <th class="p-4 border">Tanggal</th>
                            <th class="p-4 border">Bahan</th>
                            <th class="p-4 border">Supplier</th>
                            <th class="p-4 border">Tipe</th>
                            <th class="p-4 border">Jumlah</th>
                            <th class="p-4 border">Harga Satuan</th>
                            <th class="p-4 border">Total Harga</th>
                            <th class="p-4 border">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($transactions as $index => $transaction)
                            <tr>
                                <td class="p-4 border">
                                    {{ $index + 1 }}
                                </td>

                                <td class="p-4 border">
                                    {{ $transaction->transaction_date->format('d-m-Y') }}
                                </td>

                                <td class="p-4 border font-semibold">
                                    {{ $transaction->ingredient->name ?? $transaction->ingredient_name }}
                                </td>

                                <td class="p-4 border">
                                    {{ $transaction->supplier_name ?? '-' }}
                                </td>

                                <td class="p-4 border">
                                    @if ($transaction->type === 'in')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                            Masuk
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">
                                            Keluar
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    {{ number_format($transaction->quantity, 2, ',', '.') }}
                                    {{ $transaction->unit }}
                                </td>

                                <td class="p-4 border">
                                    Rp{{ number_format($transaction->unit_price, 0, ',', '.') }}
                                </td>

                                <td class="p-4 border">
                                    Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
                                </td>

                                <td class="p-4 border">
                                    <a href="{{ route('stock-transactions.show', $transaction) }}"
                                       class="text-blue-600 hover:underline">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="p-4 border text-center text-gray-500">
                                    Belum ada data transaksi stok.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>