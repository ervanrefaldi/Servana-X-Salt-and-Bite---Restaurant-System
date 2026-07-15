@extends('layouts.pos')

@section('title', 'Tambah Transaksi Manual - Servana POS')

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    <!-- Page Header -->
    <div class="px-8 pt-8 pb-6 flex justify-between items-end border-b border-gray-100 shrink-0">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Tambah Transaksi Manual</h2>
            <p class="text-gray-500 text-sm">Tambahkan transaksi pemasukan atau pengeluaran manual.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('financial-transactions.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium shadow-sm hover:bg-gray-50 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Reports
            </a>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white p-8 shadow-sm sm:rounded-2xl border border-gray-100">

                <div class="mb-4 p-4 bg-blue-50 text-blue-700 rounded">
                    <p class="font-semibold">Catatan</p>
                    <p class="text-sm mt-1">
                        Transaksi dari kasir, dapur, dan SDM tercatat otomatis.
                        Halaman ini hanya untuk transaksi manual seperti operasional,
                        maintenance, atau pemasukan/pengeluaran lain.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('financial-transactions.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Tipe Transaksi
                        </label>

                        <select name="type"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>
                                Pemasukan
                            </option>

                            <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>
                                Pengeluaran
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Kategori Manual
                        </label>

                        <select name="category"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="">-- Pilih Kategori --</option>

                            <option value="operational" {{ old('category') == 'operational' ? 'selected' : '' }}>
                                Operasional
                            </option>

                            <option value="maintenance" {{ old('category') == 'maintenance' ? 'selected' : '' }}>
                                Maintenance
                            </option>

                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>
                                Lainnya
                            </option>
                        </select>

                        <p class="text-sm text-gray-500 mt-1">
                            Kategori penjualan, pembelian stok, dan gaji dibuat otomatis dari role terkait.
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Judul Transaksi
                        </label>

                        <input type="text"
                               name="title"
                               value="{{ old('title') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Contoh: Pembayaran listrik bulan Juni"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Nominal
                        </label>

                        <input type="number"
                               name="amount"
                               value="{{ old('amount') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Contoh: 500000"
                               min="0"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Tanggal Transaksi
                        </label>

                        <input type="date"
                               name="transaction_date"
                               value="{{ old('transaction_date', now()->toDateString()) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Deskripsi
                        </label>

                        <textarea name="description"
                                  rows="4"
                                  class="w-full border-gray-300 rounded-md shadow-sm"
                                  placeholder="Keterangan tambahan">{{ old('description') }}</textarea>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('financial-transactions.index') }}"
                           class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                           style="background-color: #4b5563; color: #ffffff;">
                            Back
                        </a>

                        <button type="submit"
                                class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                                style="background-color: #2563eb; color: #ffffff;">
                            Simpan Transaksi
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
