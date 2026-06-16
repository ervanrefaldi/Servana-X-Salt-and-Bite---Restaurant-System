<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Meja
            </h2>

            <a href="{{ route('tables.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm">
                Tambah Meja
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

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-4 border">No</th>
                            <th class="p-4 border">Nomor Meja</th>
                            <th class="p-4 border">Area</th>
                            <th class="p-4 border">Kapasitas</th>
                            <th class="p-4 border">Status</th>
                            <th class="p-4 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tables as $index => $table)
                            <tr>
                                <td class="p-4 border">{{ $index + 1 }}</td>
                                <td class="p-4 border">{{ $table->table_number }}</td>
                                <td class="p-4 border">{{ ucfirst($table->area) }}</td>
                                <td class="p-4 border">{{ $table->capacity }} Orang</td>
                                <td class="p-4 border">
                                    @php
                                        $statusLabels = [
                                            'available' => 'Tersedia',
                                            'reserved' => 'Sudah Direservasi',
                                            'occupied' => 'Sedang Digunakan',
                                            'maintenance' => 'Perbaikan',
                                        ];
                                    @endphp

                                    <span class="px-2 py-1 rounded text-xs bg-gray-200">
                                        {{ $statusLabels[$table->status] ?? $table->status }}
                                    </span>
                                </td>
                                <td class="p-4 border">
                                    <a href="{{ route('tables.show', $table) }}" class="text-blue-600">Detail</a>

                                    <a href="{{ route('tables.edit', $table) }}" class="text-yellow-600 ml-2">Edit</a>

                                    <form action="{{ route('tables.destroy', $table) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus meja ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 ml-2">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 border text-center">
                                    Belum ada data meja.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
