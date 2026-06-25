<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kelola Karyawan
            </h2>

            <a href="{{ route('employees.create') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #2563eb; color: #ffffff;">
                Tambah Karyawan
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

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Karyawan</p>
                    <h3 class="text-2xl font-bold">{{ $totalEmployees ?? 0 }}</h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Aktif</p>
                    <h3 class="text-2xl font-bold text-green-600">{{ $activeEmployees ?? 0 }}</h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Tidak Aktif</p>
                    <h3 class="text-2xl font-bold text-yellow-600">{{ $inactiveEmployees ?? 0 }}</h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Resign</p>
                    <h3 class="text-2xl font-bold text-red-600">{{ $resignedEmployees ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-4 border">Nama</th>
                            <th class="p-4 border">Email</th>
                            <th class="p-4 border">Telepon</th>
                            <th class="p-4 border">Posisi</th>
                            <th class="p-4 border">Gaji Pokok</th>
                            <th class="p-4 border">Status</th>
                            <th class="p-4 border">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($employees as $employee)
                            <tr>
                                <td class="p-4 border">
                                    {{ $employee->name }}
                                </td>

                                <td class="p-4 border">
                                    {{ $employee->email ?? '-' }}
                                </td>

                                <td class="p-4 border">
                                    {{ $employee->phone ?? '-' }}
                                </td>

                                <td class="p-4 border">
                                    {{ $employee->position }}
                                </td>

                                <td class="p-4 border">
                                    Rp{{ number_format($employee->basic_salary ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="p-4 border">
                                    @if ($employee->employment_status === 'active')
                                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                            Aktif
                                        </span>
                                    @elseif ($employee->employment_status === 'inactive')
                                        <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                            Tidak Aktif
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                            Resign
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('employees.edit', $employee) }}"
                                           class="px-3 py-1 rounded text-xs font-semibold"
                                           style="background-color: #2563eb; color: #ffffff;">
                                            Edit
                                        </a>

                                        <form action="{{ route('employees.destroy', $employee) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data karyawan ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="px-3 py-1 rounded text-xs font-semibold"
                                                    style="background-color: #dc2626; color: #ffffff;">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-4 border text-center text-gray-500">
                                    Belum ada data karyawan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 p-4 bg-blue-50 text-blue-700 rounded">
                <p class="text-sm">
                    Catatan: Data karyawan di halaman ini bukan akun login sistem.
                    Akun staff login tetap dikelola melalui menu Kelola Akun Staff.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>