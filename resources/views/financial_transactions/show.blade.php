<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Transaksi Keuangan
            </h2>

            <a href="{{ route('financial-transactions.index') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #4b5563; color: #ffffff;">
                Kembali ke Laporan Keuangan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Judul</p>
                    <p class="text-lg font-semibold">
                        {{ $financialTransaction->title }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Tipe</p>
                    <p class="text-lg font-semibold">
                        {{ $financialTransaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Kategori</p>
                    <p class="text-lg font-semibold">
                        @if ($financialTransaction->category === 'sales')
                            Penjualan Kasir
                        @elseif ($financialTransaction->category === 'stock_purchase')
                            Pembelian Stok Dapur
                        @elseif ($financialTransaction->category === 'salary')
                            Gaji Karyawan
                        @elseif ($financialTransaction->category === 'operational')
                            Operasional
                        @elseif ($financialTransaction->category === 'maintenance')
                            Maintenance
                        @else
                            Lainnya
                        @endif
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Sumber Transaksi</p>
                    <p class="text-lg font-semibold">
                        @if ($financialTransaction->category === 'sales')
                            Kasir / POS
                        @elseif ($financialTransaction->category === 'stock_purchase')
                            Dapur
                        @elseif ($financialTransaction->category === 'salary')
                            SDM
                        @else
                            Manual Keuangan
                        @endif
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Nominal</p>
                    <p class="text-lg font-semibold">
                        Rp{{ number_format($financialTransaction->amount, 0, ',', '.') }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Tanggal Transaksi</p>
                    <p class="text-lg font-semibold">
                        {{ $financialTransaction->transaction_date->format('d-m-Y') }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Dibuat Oleh</p>
                    <p class="text-lg font-semibold">
                        {{ $financialTransaction->creator->name ?? '-' }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Deskripsi</p>
                    <p class="text-lg">
                        {{ $financialTransaction->description ?? '-' }}
                    </p>
                </div>

                @if ($financialTransaction->order)
                    <div class="mt-6 p-4 bg-blue-50 text-blue-700 rounded">
                        <p class="font-semibold">
                            Transaksi ini berasal dari order kasir:
                        </p>

                        <p class="text-xl font-bold">
                            {{ $financialTransaction->order->order_code }}
                        </p>
                    </div>
                @endif

                <div class="mt-6">
                    <a href="{{ route('financial-transactions.index') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #4b5563; color: #ffffff;">
                        Back
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>