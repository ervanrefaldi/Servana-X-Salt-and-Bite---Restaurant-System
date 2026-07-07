@extends('layouts.pos')

@section('title', 'Kelola Karyawan - Servana POS')

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    <!-- Page Header -->
    <div class="px-8 pt-8 pb-6 flex justify-between items-end border-b border-gray-100 shrink-0">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Employee Directory</h2>
            <p class="text-gray-500 text-sm">Manage staff profiles, positions, and employment status.</p>
        </div>
        <a href="{{ route('employees.create') }}" class="px-4 py-2 bg-brand-red text-white rounded-lg text-sm font-medium shadow-sm hover:bg-[#8B121A] transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Employee
        </a>
    </div>

    <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">

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
    </div>
</div>
@endsection