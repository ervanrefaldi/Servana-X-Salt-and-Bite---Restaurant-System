<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kelola Karyawan
            </h2>

            <a href="{{ route('sdm.dashboard') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #2563eb; color: #ffffff;">
                Kembali ke Dashboard SDM
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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
                    <p class="text-sm text-gray-500">Total Karyawan</p>
                    <h3 class="text-2xl font-bold">
                        {{ $totalEmployees }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Karyawan Aktif</p>
                    <h3 class="text-2xl font-bold text-green-600">
                        {{ $activeEmployees }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Status Gaji Belum Dibayar</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        {{ $unpaidSalaries }}
                    </h3>
                </div>
            </div>

            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('salary-payments.index') }}"
                   class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                   style="background-color: #f59e0b; color: #ffffff;">
                    Kelola Gaji Bulanan
                </a>

                <a href="{{ route('employees.create') }}"
                   class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                   style="background-color: #16a34a; color: #ffffff;">
                    Tambah Karyawan
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-4 border">No</th>
                            <th class="p-4 border">Nama</th>
                            <th class="p-4 border">Akun Login</th>
                            <th class="p-4 border">No HP</th>
                            <th class="p-4 border">Posisi</th>
                            <th class="p-4 border">Total Gaji</th>
                            <th class="p-4 border">Status Kerja</th>
                            <th class="p-4 border">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($employees as $index => $employee)
                            <tr>
                                <td class="p-4 border">
                                    {{ $index + 1 }}
                                </td>

                                <td class="p-4 border font-semibold">
                                    {{ $employee->name }}
                                </td>

                                <td class="p-4 border">
                                    @if ($employee->user)
                                        <div class="font-semibold">
                                            {{ $employee->user->email }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ ucfirst($employee->user->role) }}
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    {{ $employee->phone ?? '-' }}
                                </td>

                                <td class="p-4 border">
                                    {{ $employee->position }}
                                </td>

                                <td class="p-4 border">
                                    Rp{{ number_format($employee->total_salary ?? $employee->salary, 0, ',', '.') }}
                                </td>

                                <td class="p-4 border">
                                    @if ($employee->employment_status === 'active')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                            Aktif
                                        </span>
                                    @elseif ($employee->employment_status === 'inactive')
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">
                                            Tidak Aktif
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">
                                            Resign
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    <a href="{{ route('employees.show', $employee) }}"
                                       class="text-blue-600 hover:underline">
                                        Detail
                                    </a>

                                    <a href="{{ route('employees.edit', $employee) }}"
                                       class="text-yellow-600 hover:underline ml-2">
                                        Edit
                                    </a>

                                    <form action="{{ route('employees.destroy', $employee) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus data karyawan ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-red-600 hover:underline ml-2">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-4 border text-center text-gray-500">
                                    Belum ada data karyawan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>