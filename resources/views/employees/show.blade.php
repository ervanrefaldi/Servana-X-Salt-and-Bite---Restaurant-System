<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Karyawan
            </h2>

            <a href="{{ route('employees.index') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #4b5563; color: #ffffff;">
                Kembali ke Kelola Karyawan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    Informasi Karyawan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama Karyawan</p>
                        <p class="text-lg font-semibold">{{ $employee->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Akun Login Terkait</p>
                        <p class="text-lg font-semibold">
                            {{ $employee->user->email ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Role Akun</p>
                        <p class="text-lg font-semibold">
                            {{ $employee->user ? ucfirst($employee->user->role) : '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Nomor HP</p>
                        <p class="text-lg font-semibold">{{ $employee->phone ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Posisi</p>
                        <p class="text-lg font-semibold">{{ $employee->position }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Tanggal Masuk</p>
                        <p class="text-lg font-semibold">
                            {{ $employee->hire_date ? $employee->hire_date->format('d-m-Y') : '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Status Kerja</p>
                        <p class="text-lg font-semibold">
                            @if ($employee->employment_status === 'active')
                                Aktif
                            @elseif ($employee->employment_status === 'inactive')
                                Tidak Aktif
                            @else
                                Resign
                            @endif
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Alamat</p>
                        <p class="text-lg font-semibold">{{ $employee->address ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    Informasi Gaji
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Gaji Pokok</p>
                        <p class="text-lg font-semibold">
                            Rp{{ number_format($employee->basic_salary ?? $employee->salary, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Bonus</p>
                        <p class="text-lg font-semibold">
                            Rp{{ number_format($employee->bonus ?? 0, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Potongan</p>
                        <p class="text-lg font-semibold">
                            Rp{{ number_format($employee->deduction ?? 0, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Total Gaji</p>
                        <p class="text-lg font-bold text-blue-600">
                            Rp{{ number_format($employee->total_salary ?? $employee->salary, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">
                    Riwayat Gaji
                </h3>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">No</th>
                            <th class="p-3 border">Periode</th>
                            <th class="p-3 border">Nominal</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border">Tanggal Bayar</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($employee->salaryPayments as $index => $payment)
                            <tr>
                                <td class="p-3 border">{{ $index + 1 }}</td>

                                <td class="p-3 border">
                                    {{ $payment->salary_month }}-{{ $payment->salary_year }}
                                </td>

                                <td class="p-3 border">
                                    Rp{{ number_format($payment->amount, 0, ',', '.') }}
                                </td>

                                <td class="p-3 border">
                                    @if ($payment->status === 'paid')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                            Sudah Dibayar
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">
                                            Belum Dibayar
                                        </span>
                                    @endif
                                </td>

                                <td class="p-3 border">
                                    {{ $payment->payment_date ? $payment->payment_date->format('d-m-Y') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 border text-center text-gray-500">
                                    Belum ada riwayat pembayaran gaji.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('employees.index') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #4b5563; color: #ffffff;">
                        Back
                    </a>

                    <a href="{{ route('employees.edit', $employee) }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #f59e0b; color: #ffffff;">
                        Edit Karyawan
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>