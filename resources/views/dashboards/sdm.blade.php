<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard SDM
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-2">
                    Selamat datang, Staff SDM
                </h3>

                <p class="text-gray-600">
                    Anda dapat mengelola akun staff dan data karyawan. Untuk melihat gaji karyawan,
                    gunakan menu Lihat Gaji — pengelolaan gaji dilakukan oleh bagian keuangan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Karyawan</p>
                    <h3 class="text-2xl font-bold">
                        {{ $totalEmployees ?? 0 }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Karyawan Aktif</p>
                    <h3 class="text-2xl font-bold text-green-600">
                        {{ $activeEmployees ?? 0 }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Akun Staff</p>
                    <h3 class="text-2xl font-bold text-blue-600">
                        {{ $totalStaffAccounts ?? 0 }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Gaji Belum Dibayar Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        {{ $unpaidSalaries ?? 0 }}
                    </h3>
                </div>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">
                    Menu SDM
                </h3>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('staff-accounts.index') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #2563eb; color: #ffffff;">
                        Kelola Akun Staff
                    </a>

                    <a href="{{ route('employees.index') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #16a34a; color: #ffffff;">
                        Kelola Karyawan
                    </a>

                    <a href="{{ route('salary-payments.index') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #f59e0b; color: #ffffff;">
                        Lihat Gaji Karyawan
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>