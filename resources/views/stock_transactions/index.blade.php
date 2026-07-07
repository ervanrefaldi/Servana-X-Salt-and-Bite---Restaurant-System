@extends('layouts.pos')

@section('title', 'Riwayat Transaksi Stok - Servana POS')

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    <!-- Page Header -->
    <div class="px-8 pt-8 pb-6 flex justify-between items-end border-b border-gray-100 shrink-0">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Stock Transactions</h2>
            <p class="text-gray-500 text-sm">View history of stock in/out and purchase requests.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('ingredients.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium shadow-sm hover:bg-gray-50 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Manage Ingredients
            </a>
            <a href="{{ route('stock-transactions.create') }}" class="px-4 py-2 bg-brand-red text-white rounded-lg text-sm font-medium shadow-sm hover:bg-[#8B121A] transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Request
            </a>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">

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
                            <th class="p-4 border">Status</th>
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
                                    @if ($transaction->status === 'pengajuan')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs">
                                            Pengajuan
                                        </span>
                                    @elseif ($transaction->status === 'cair')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                            Cair
                                        </span>
                                    @elseif ($transaction->status === 'ditolak')
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">
                                            Selesai
                                        </span>
                                    @endif
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
                                <td colspan="10" class="p-4 border text-center text-gray-500">
                                    Belum ada data transaksi stok.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            </div>
        </div>
    </div>
</div>
@endsection