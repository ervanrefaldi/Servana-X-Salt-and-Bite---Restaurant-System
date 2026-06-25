<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kelola Akun Staff
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
                    <p class="text-sm text-gray-500">Total Akun Staff</p>
                    <h3 class="text-2xl font-bold">
                        {{ $totalStaffAccounts ?? 0 }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Akun Aktif</p>
                    <h3 class="text-2xl font-bold text-green-600">
                        {{ $activeStaffAccounts ?? 0 }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Akun Tidak Aktif</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        {{ $inactiveStaffAccounts ?? 0 }}
                    </h3>
                </div>
            </div>

            <div class="bg-white p-4 shadow-sm sm:rounded-lg mb-6">
                <p class="text-sm text-gray-700">
                    <strong>Catatan:</strong>
                    Akun staff dibuat dari data karyawan yang sudah ada.
                    Jika karyawan belum muncul di pilihan tambah staff, pastikan data karyawan aktif,
                    memiliki email, dan belum memiliki akun staff.
                </p>
            </div>

            <div class="mb-4 flex justify-end">
                <a href="{{ route('staff-accounts.create') }}"
                   class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                   style="background-color: #16a34a; color: #ffffff;">
                    Tambah Akun Staff
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-4 border">No</th>
                            <th class="p-4 border">Nama Karyawan</th>
                            <th class="p-4 border">Email</th>
                            <th class="p-4 border">No HP</th>
                            <th class="p-4 border">Posisi Karyawan</th>
                            <th class="p-4 border">Role Akses</th>
                            <th class="p-4 border">Status Akun</th>
                            <th class="p-4 border">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($staffAccounts as $index => $staff)
                            <tr>
                                <td class="p-4 border">
                                    {{ $index + 1 }}
                                </td>

                                <td class="p-4 border font-semibold">
                                    {{ $staff->employee->name ?? $staff->name }}
                                </td>

                                <td class="p-4 border">
                                    {{ $staff->employee->email ?? $staff->email }}
                                </td>

                                <td class="p-4 border">
                                    {{ $staff->employee->phone ?? $staff->phone ?? '-' }}
                                </td>

                                <td class="p-4 border">
                                    {{ $staff->employee->position ?? '-' }}
                                </td>

                                <td class="p-4 border">
                                    @if ($staff->role === 'sdm')
                                        SDM
                                    @else
                                        {{ ucfirst($staff->role) }}
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    @if ($staff->is_active)
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('staff-accounts.show', $staff) }}"
                                           class="px-3 py-1 rounded text-xs font-semibold"
                                           style="background-color: #2563eb; color: #ffffff;">
                                            Detail
                                        </a>

                                        <a href="{{ route('staff-accounts.edit', $staff) }}"
                                           class="px-3 py-1 rounded text-xs font-semibold"
                                           style="background-color: #f59e0b; color: #ffffff;">
                                            Edit
                                        </a>

                                        <form action="{{ route('staff-accounts.destroy', $staff) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus akun staff ini? Data karyawan tidak akan terhapus.')">
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
                                <td colspan="8" class="p-4 border text-center text-gray-500">
                                    Belum ada akun staff.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>