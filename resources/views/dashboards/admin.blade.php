<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Welcome --}}
            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-2">
                    Selamat datang, Admin
                </h3>

                <p class="text-gray-600">
                    Anda memiliki akses penuh untuk memantau dan mengelola seluruh sistem Servana,
                    mulai dari operasional restoran, transaksi kasir, stok dapur, keuangan, hingga SDM.
                </p>
            </div>

            {{-- Ringkasan Operasional --}}
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    Ringkasan Operasional
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Menu</p>
                    <h3 class="text-2xl font-bold">{{ $totalMenus ?? 0 }}</h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Menu aktif: {{ $activeMenus ?? 0 }}
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Meja</p>
                    <h3 class="text-2xl font-bold">{{ $totalTables ?? 0 }}</h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Meja tersedia: {{ $availableTables ?? 0 }}
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Reservasi</p>
                    <h3 class="text-2xl font-bold">{{ $totalReservations ?? 0 }}</h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Hari ini: {{ $todayReservations ?? 0 }} |
                        Pending: {{ $pendingReservations ?? 0 }}
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Member</p>
                    <h3 class="text-2xl font-bold">{{ $totalMembers ?? 0 }}</h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Member terdaftar di sistem
                    </p>
                </div>
            </div>

            {{-- Ringkasan Keuangan --}}
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    Ringkasan Keuangan
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Pemasukan</p>
                    <h3 class="text-2xl font-bold text-green-600">
                        Rp{{ number_format($totalIncome ?? 0, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Hari ini: Rp{{ number_format($todayIncome ?? 0, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Pengeluaran</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        Rp{{ number_format($totalExpense ?? 0, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Hari ini: Rp{{ number_format($todayExpense ?? 0, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Saldo Akhir</p>
                    <h3 class="text-2xl font-bold">
                        Rp{{ number_format($balance ?? 0, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Pemasukan dikurangi pengeluaran
                    </p>
                </div>
            </div>

            {{-- Ringkasan Internal --}}
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    Ringkasan Internal
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Staff</p>
                    <h3 class="text-2xl font-bold text-blue-600">
                        {{ $totalStaffAccounts ?? 0 }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Akun internal staff
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Karyawan Aktif</p>
                    <h3 class="text-2xl font-bold text-green-600">
                        {{ $activeEmployees ?? 0 }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Dari total {{ $totalEmployees ?? 0 }} karyawan
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Stok Menipis / Habis</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        {{ ($lowStockIngredients ?? 0) + ($emptyStockIngredients ?? 0) }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Menipis: {{ $lowStockIngredients ?? 0 }},
                        Habis: {{ $emptyStockIngredients ?? 0 }}
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Gaji Belum Dibayar</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        {{ $unpaidSalaries ?? 0 }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Periode bulan ini
                    </p>
                </div>
            </div>

            {{-- Akses Cepat Admin --}}
            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    Akses Cepat Admin
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <a href="{{ route('menus.index') }}"
                       class="inline-block px-4 py-3 rounded-md text-sm font-semibold shadow text-center"
                       style="background-color: #2563eb; color: #ffffff;">
                        Kelola Menu
                    </a>

                    <a href="{{ route('tables.index') }}"
                       class="inline-block px-4 py-3 rounded-md text-sm font-semibold shadow text-center"
                       style="background-color: #4f46e5; color: #ffffff;">
                        Kelola Meja
                    </a>

                    <a href="{{ route('reservations.index') }}"
                       class="inline-block px-4 py-3 rounded-md text-sm font-semibold shadow text-center"
                       style="background-color: #16a34a; color: #ffffff;">
                        Kelola Reservasi
                    </a>

                    <a href="{{ route('orders.index') }}"
                       class="inline-block px-4 py-3 rounded-md text-sm font-semibold shadow text-center"
                       style="background-color: #0891b2; color: #ffffff;">
                        Kelola Transaksi POS
                    </a>

                    <a href="{{ route('ingredients.index') }}"
                       class="inline-block px-4 py-3 rounded-md text-sm font-semibold shadow text-center"
                       style="background-color: #ea580c; color: #ffffff;">
                        Kelola Bahan Dapur
                    </a>

                    <a href="{{ route('stock-transactions.index') }}"
                       class="inline-block px-4 py-3 rounded-md text-sm font-semibold shadow text-center"
                       style="background-color: #f59e0b; color: #ffffff;">
                        Riwayat Stok Dapur
                    </a>

                    <a href="{{ route('financial-transactions.index') }}"
                       class="inline-block px-4 py-3 rounded-md text-sm font-semibold shadow text-center"
                       style="background-color: #15803d; color: #ffffff;">
                        Laporan Keuangan
                    </a>

                    <a href="{{ route('employees.index') }}"
                       class="inline-block px-4 py-3 rounded-md text-sm font-semibold shadow text-center"
                       style="background-color: #7c3aed; color: #ffffff;">
                        Kelola Karyawan
                    </a>

                    <a href="{{ route('salary-payments.index') }}"
                       class="inline-block px-4 py-3 rounded-md text-sm font-semibold shadow text-center"
                       style="background-color: #dc2626; color: #ffffff;">
                        Kelola Gaji
                    </a>

                    <a href="{{ route('staff-accounts.index') }}"
                       class="inline-block px-4 py-3 rounded-md text-sm font-semibold shadow text-center"
                       style="background-color: #0f766e; color: #ffffff;">
                        Kelola Akun Staff
                    </a>

                    <a href="{{ route('admin.reports.index') }}"
                       class="inline-block px-4 py-3 rounded-md text-sm font-semibold shadow text-center md:col-span-2"
                       style="background-color: #374151; color: #ffffff;">
                        Pusat Laporan Admin
                    </a>

                    <a href="{{ route('admin.reports.financial') }}"
                       class="inline-block px-4 py-3 rounded-md text-sm font-semibold shadow text-center"
                       style="background-color: #111827; color: #ffffff;">
                        Cetak Laporan Keuangan
                    </a>
                </div>
            </div>

            {{-- Pusat Laporan Admin --}}
            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-2">
                    Pusat Laporan Admin
                </h3>

                <p class="text-gray-600 mb-4">
                    Admin dapat melihat, memfilter, dan mencetak laporan sistem.
                    Untuk saat ini laporan keuangan sudah bisa dicetak dalam bentuk Excel/CSV
                    dan PDF melalui fitur print browser.
                </p>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.reports.financial') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #16a34a; color: #ffffff;">
                        Laporan Keuangan Excel/PDF
                    </a>

                    <a href="{{ route('admin.reports.index') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #374151; color: #ffffff;">
                        Buka Pusat Laporan
                    </a>

                    <button disabled
                            class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow bg-gray-400 text-white cursor-not-allowed">
                        Laporan POS Segera Dibuat
                    </button>

                    <button disabled
                            class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow bg-gray-400 text-white cursor-not-allowed">
                        Laporan Reservasi Segera Dibuat
                    </button>

                    <button disabled
                            class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow bg-gray-400 text-white cursor-not-allowed">
                        Laporan Stok Segera Dibuat
                    </button>

                    <button disabled
                            class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow bg-gray-400 text-white cursor-not-allowed">
                        Laporan Gaji Segera Dibuat
                    </button>
                </div>
            </div>

            {{-- Transaksi Keuangan Terbaru --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">
                        Transaksi Keuangan Terbaru
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