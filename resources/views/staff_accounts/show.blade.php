<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Akun Staff
            </h2>

            <a href="{{ route('staff-accounts.index') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #4b5563; color: #ffffff;">
                Kembali ke Kelola Akun Staff
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    Data Karyawan
                </h3>

                <table class="w-full border-collapse">
                    <tr>
                        <td class="p-3 border bg-gray-100 font-semibold w-1/3">Nama</td>
                        <td class="p-3 border">{{ $staffAccount->employee->name ?? $staffAccount->name }}</td>
                    </tr>

                    <tr>
                        <td class="p-3 border bg-gray-100 font-semibold">Email</td>
                        <td class="p-3 border">{{ $staffAccount->employee->email ?? $staffAccount->email }}</td>
                    </tr>

                    <tr>
                        <td class="p-3 border bg-gray-100 font-semibold">Nomor HP</td>
                        <td class="p-3 border">{{ $staffAccount->employee->phone ?? $staffAccount->phone ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td class="p-3 border bg-gray-100 font-semibold">Posisi Karyawan</td>
                        <td class="p-3 border">{{ $staffAccount->employee->position ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">
                    Data Akses Website
                </h3>

                <table class="w-full border-collapse">
                    <tr>
                        <td class="p-3 border bg-gray-100 font-semibold w-1/3">Role Akses</td>
                        <td class="p-3 border">
                            {{ $staffAccount->role === 'sdm' ? 'SDM' : ucfirst($staffAccount->role) }}
                        </td>
                    </tr>

                    <tr>
                        <td class="p-3 border bg-gray-100 font-semibold">Status Akun</td>
                        <td class="p-3 border">
                            @if ($staffAccount->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                    Aktif
                                </span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="p-3 border bg-gray-100 font-semibold">Tanggal Dibuat</td>
                        <td class="p-3 border">
                            {{ optional($staffAccount->created_at)->format('d-m-Y H:i') }}
                        </td>
                    </tr>

                    <tr>
                        <td class="p-3 border bg-gray-100 font-semibold">Terakhir Diperbarui</td>
                        <td class="p-3 border">
                            {{ optional($staffAccount->updated_at)->format('d-m-Y H:i') }}
                        </td>
                    </tr>
                </table>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('staff-accounts.edit', $staffAccount) }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #f59e0b; color: #ffffff;">
                        Edit Akun
                    </a>

                    <a href="{{ route('staff-accounts.index') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #4b5563; color: #ffffff;">
                        Kembali
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>