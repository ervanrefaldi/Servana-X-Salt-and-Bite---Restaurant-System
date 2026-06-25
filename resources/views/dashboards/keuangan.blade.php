<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Keuangan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-2">
                    Selamat datang, Staff Keuangan
                </h3>

                <p class="text-gray-600">
                    Anda dapat memantau pemasukan dari kasir, pengeluaran stok dari dapur,
                    mengelola pembayaran gaji karyawan, serta mencatat transaksi manual lainnya.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Pemasukan</p>
                    <h3 class="text-2xl font-bold text-green-600">
                        Rp{{ number_format($totalIncome ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Pengeluaran</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        Rp{{ number_format($totalExpense ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Saldo Akhir</p>
                    <h3 class="text-2xl font-bold">
                        Rp{{ number_format($balance ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Pemasukan Hari Ini</p>
                    <h3 class="text-2xl font-bold text-green-600">
                        Rp{{ number_format($todayIncome ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Pengeluaran Hari Ini</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        Rp{{ number_format($todayExpense ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Pemasukan dari Kasir</p>
                    <h3 class="text-xl font-bold text-green-600">
                        Rp{{ number_format($salesIncome ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Pengeluaran Stok Dapur</p>
                    <h3 class="text-xl font-bold text-red-600">
                        Rp{{ number_format($stockExpense ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Pengeluaran Gaji</p>
                    <h3 class="text-xl font-bold text-red-600">
                        Rp{{ number_format($salaryExpense ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    Menu Keuangan
                </h3>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('financial-transactions.index') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #2563eb; color: #ffffff;">
                        Lihat Laporan Keuangan
                    </a>

                    <a href="{{ route('financial-transactions.create') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #16a34a; color: #ffffff;">
                        Tambah Transaksi Manual
                    </a>

                    <a href="{{ route('salary-payments.index') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #f59e0b; color: #ffffff;">
                        Kelola Gaji Karyawan
                    </a>
                </div>
                </div>
            </div>

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

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden mb-6">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">
                        Persetujuan Pembelian Stok
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="p-4 border">Tanggal</th>
                                <th class="p-4 border">Bahan</th>
                                <th class="p-4 border">Supplier</th>
                                <th class="p-4 border">Jumlah</th>
                                <th class="p-4 border">Total Harga</th>
                                <th class="p-4 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendingStockTransactions as $transaction)
                                <tr>
                                    <td class="p-4 border">{{ $transaction->transaction_date->format('d-m-Y') }}</td>
                                    <td class="p-4 border">{{ $transaction->ingredient->name ?? $transaction->ingredient_name }}</td>
                                    <td class="p-4 border">{{ $transaction->supplier_name ?? '-' }}</td>
                                    <td class="p-4 border">{{ number_format($transaction->quantity, 2, ',', '.') }} {{ $transaction->unit }}</td>
                                    <td class="p-4 border font-bold text-red-600">Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                    <td class="p-4 border">
                                        <div class="flex space-x-2">
                                            <form action="{{ route('stock-transactions.updateStatus', $transaction) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cair">
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm font-semibold" onclick="return confirm('Cairkan dana dan setujui pembelian ini?')">Cairkan</button>
                                            </form>
                                            <form action="{{ route('stock-transactions.updateStatus', $transaction) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="ditolak">
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-semibold" onclick="return confirm('Tolak pembelian ini?')">Tolak</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 border text-center text-gray-500">
                                        Tidak ada pengajuan pembelian stok baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">
                        Transaksi Terbaru
                    </h3>
                </div>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-4 border">Tanggal</th>
                            <th class="p-4 border">Judul</th>
                            <th class="p-4 border">Tipe</th>
                            <th class="p-4 border">Kategori</th>
                            <th class="p-4 border">Nominal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($latestTransactions as $transaction)
                            <tr>
                                <td class="p-4 border">
                                    {{ $transaction->transaction_date->format('d-m-Y') }}
                                </td>

                                <td class="p-4 border">
                                    {{ $transaction->title }}
                                </td>

                                <td class="p-4 border">
                                    {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                </td>

                                <td class="p-4 border">
                                    {{ ucfirst(str_replace('_', ' ', $transaction->category)) }}
                                </td>

                                <td class="p-4 border">
                                    Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 border text-center text-gray-500">
                                    Belum ada transaksi keuangan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>