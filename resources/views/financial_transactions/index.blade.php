@extends('layouts.pos')

@section('title', 'Laporan Keuangan - Servana POS')

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    <!-- Page Header -->
    <div class="px-8 pt-8 pb-6 flex justify-between items-end border-b border-gray-100 shrink-0">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Financial Reports</h2>
            <p class="text-gray-500 text-sm">View comprehensive reports and filter transactions across all departments.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('keuangan.dashboard') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium shadow-sm hover:bg-gray-50 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Dashboard
            </a>
            <a href="{{ route('financial-transactions.create') }}" class="px-4 py-2 bg-brand-red text-white rounded-lg text-sm font-medium shadow-sm hover:bg-[#8B121A] transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Manual Record
            </a>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET"
                  action="{{ route('financial-transactions.index') }}"
                  class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">

                <h3 class="text-lg font-semibold mb-4">
                    Filter Laporan Keuangan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                    <div>
                        <label class="block mb-2 font-medium">Tanggal Awal</label>
                        <input type="date"
                               name="start_date"
                               value="{{ request('start_date') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Tanggal Akhir</label>
                        <input type="date"
                               name="end_date"
                               value="{{ request('end_date') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Tipe</label>
                        <select name="type"
                                class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>
                                Semua Tipe
                            </option>
                            <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>
                                Pemasukan
                            </option>
                            <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>
                                Pengeluaran
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Sumber Laporan</label>
                        <select name="source"
                                class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="all" {{ request('source') == 'all' ? 'selected' : '' }}>
                                Semua Sumber
                            </option>
                            <option value="pos" {{ request('source') == 'pos' ? 'selected' : '' }}>
                                POS / Kasir
                            </option>
                            <option value="dapur" {{ request('source') == 'dapur' ? 'selected' : '' }}>
                                Dapur
                            </option>
                            <option value="sdm" {{ request('source') == 'sdm' ? 'selected' : '' }}>
                                SDM / Penggajian
                            </option>
                            <option value="manual" {{ request('source') == 'manual' ? 'selected' : '' }}>
                                Manual Keuangan
                            </option>
                        </select>
                    </div>

                    <div>
                        <button type="submit"
                                class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow w-full"
                                style="background-color: #2563eb; color: #ffffff;">
                            Filter
                        </button>
                    </div>
                </div>

                <div class="mt-4 flex gap-4">
                    <a href="{{ route('financial-transactions.index') }}"
                       class="text-sm text-blue-600 hover:underline">
                        Reset Filter
                    </a>

                    @if (request()->hasAny(['start_date', 'end_date', 'type', 'source']))
                        <span class="text-sm text-gray-500">
                            Filter aktif:
                            {{ request('source', 'all') }}
                        </span>
                    @endif
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Pemasukan</p>
                    <h3 class="text-2xl font-bold text-green-600">
                        Rp{{ number_format($totalIncome, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Pengeluaran</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        Rp{{ number_format($totalExpense, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Saldo Sesuai Filter</p>
                    <h3 class="text-2xl font-bold">
                        Rp{{ number_format($balance, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <a href="{{ route('financial-transactions.index', array_merge(request()->except('page'), ['source' => 'pos'])) }}"
                   class="block bg-white p-5 shadow-sm sm:rounded-lg hover:bg-gray-50">
                    <p class="text-sm text-gray-500">POS / Kasir</p>
                    <h3 class="text-lg font-bold text-green-600">
                        Rp{{ number_format($salesIncome, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Klik untuk melihat laporan POS.
                    </p>
                </a>

                <a href="{{ route('financial-transactions.index', array_merge(request()->except('page'), ['source' => 'dapur'])) }}"
                   class="block bg-white p-5 shadow-sm sm:rounded-lg hover:bg-gray-50">
                    <p class="text-sm text-gray-500">Dapur</p>
                    <h3 class="text-lg font-bold text-red-600">
                        Rp{{ number_format($stockExpense, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Klik untuk melihat pembelian stok.
                    </p>
                </a>

                <a href="{{ route('financial-transactions.index', array_merge(request()->except('page'), ['source' => 'sdm'])) }}"
                   class="block bg-white p-5 shadow-sm sm:rounded-lg hover:bg-gray-50">
                    <p class="text-sm text-gray-500">SDM / Penggajian</p>
                    <h3 class="text-lg font-bold text-red-600">
                        Rp{{ number_format($salaryExpense, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Klik untuk melihat penggajian.
                    </p>
                </a>

                <a href="{{ route('financial-transactions.index', array_merge(request()->except('page'), ['source' => 'manual'])) }}"
                   class="block bg-white p-5 shadow-sm sm:rounded-lg hover:bg-gray-50">
                    <p class="text-sm text-gray-500">Manual Keuangan</p>
                    <h3 class="text-lg font-bold">
                        Rp{{ number_format($manualTransactionTotal, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Klik untuk melihat transaksi manual.
                    </p>
                </a>
            </div>



            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-4 border">No</th>
                            <th class="p-4 border">Tanggal</th>
                            <th class="p-4 border">Judul</th>
                            <th class="p-4 border">Tipe</th>
                            <th class="p-4 border">Kategori</th>
                            <th class="p-4 border">Sumber</th>
                            <th class="p-4 border">Nominal</th>
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

                                <td class="p-4 border">
                                    {{ $transaction->title }}
                                </td>

                                <td class="p-4 border">
                                    @if ($transaction->type === 'income')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                            Pemasukan
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">
                                            Pengeluaran
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    @if ($transaction->category === 'sales')
                                        Penjualan Kasir
                                    @elseif ($transaction->category === 'stock_purchase')
                                        Pembelian Stok Dapur
                                    @elseif ($transaction->category === 'salary')
                                        Gaji Karyawan
                                    @elseif ($transaction->category === 'operational')
                                        Operasional
                                    @elseif ($transaction->category === 'maintenance')
                                        Maintenance
                                    @else
                                        Lainnya
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    @if ($transaction->category === 'sales')
                                        POS / Kasir
                                    @elseif ($transaction->category === 'stock_purchase')
                                        Dapur
                                    @elseif ($transaction->category === 'salary')
                                        SDM / Penggajian
                                    @else
                                        Manual Keuangan
                                    @endif
                                </td>

                                <td class="p-4 border font-semibold">
                                    Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>

                                <td class="p-4 border">
                                    <a href="{{ route('financial-transactions.show', $transaction) }}"
                                       class="text-blue-600 hover:underline">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-4 border text-center text-gray-500">
                                    Belum ada data transaksi untuk filter ini.
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