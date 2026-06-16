<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Keuangan Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    Filter Laporan Keuangan
                </h3>

                <form method="GET" action="{{ route('admin.reports.financial') }}"
                      class="grid grid-cols-1 md:grid-cols-5 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Tanggal Awal
                        </label>
                        <input type="date"
                               name="start_date"
                               value="{{ request('start_date') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Tanggal Akhir
                        </label>
                        <input type="date"
                               name="end_date"
                               value="{{ request('end_date') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Tipe
                        </label>
                        <select name="type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="all" {{ request('type') === 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Sumber
                        </label>
                        <select name="source"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="all" {{ request('source') === 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="pos" {{ request('source') === 'pos' ? 'selected' : '' }}>POS / Kasir</option>
                            <option value="dapur" {{ request('source') === 'dapur' ? 'selected' : '' }}>Dapur</option>
                            <option value="sdm" {{ request('source') === 'sdm' ? 'selected' : '' }}>SDM / Gaji</option>
                            <option value="manual" {{ request('source') === 'manual' ? 'selected' : '' }}>Manual Keuangan</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full px-4 py-2 rounded-md text-sm font-semibold"
                                style="background-color: #2563eb; color: #ffffff;">
                            Filter
                        </button>
                    </div>
                </form>

                <div class="flex flex-wrap gap-3 mt-4">
                    <a href="{{ route('admin.reports.financial') }}"
                       class="px-4 py-2 rounded-md text-sm font-semibold bg-gray-500 text-white">
                        Reset
                    </a>

                    <a href="{{ route('admin.reports.financial.excel', request()->query()) }}"
                       class="px-4 py-2 rounded-md text-sm font-semibold"
                       style="background-color: #16a34a; color: #ffffff;">
                        Export Excel
                    </a>

                    <a href="{{ route('admin.reports.financial.pdf', request()->query()) }}"
                       target="_blank"
                       class="px-4 py-2 rounded-md text-sm font-semibold"
                       style="background-color: #dc2626; color: #ffffff;">
                        Cetak PDF
                    </a>
                </div>
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
                    <p class="text-sm text-gray-500">Saldo</p>
                    <h3 class="text-2xl font-bold">
                        Rp{{ number_format($balance ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-4 border">Tanggal</th>
                            <th class="p-4 border">Judul</th>
                            <th class="p-4 border">Tipe</th>
                            <th class="p-4 border">Kategori</th>
                            <th class="p-4 border">Nominal</th>
                            <th class="p-4 border">Dibuat Oleh</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td class="p-4 border">
                                    {{ optional($transaction->transaction_date)->format('d-m-Y') }}
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

                                <td class="p-4 border">
                                    {{ $transaction->creator->name ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 border text-center text-gray-500">
                                    Tidak ada data laporan keuangan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>