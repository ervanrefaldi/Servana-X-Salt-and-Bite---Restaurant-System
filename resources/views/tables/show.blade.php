<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Meja
            </h2>

            <a href="{{ route('tables.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Nomor Meja</p>
                    <p class="text-lg font-semibold">{{ $table->table_number }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Area</p>
                    <p class="text-lg font-semibold">{{ ucfirst($table->area) }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Kapasitas</p>
                    <p class="text-lg font-semibold">{{ $table->capacity }} Orang</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Status</p>
                    @php
                        $statusLabels = [
                            'available' => 'Tersedia',
                            'reserved' => 'Sudah Direservasi',
                            'occupied' => 'Sedang Digunakan',
                            'maintenance' => 'Perbaikan',
                        ];
                    @endphp

                    {{ $statusLabels[$table->status] ?? $table->status }}
                </div>

                <div class="flex gap-2 mt-6">
                    <a href="{{ route('tables.edit', $table) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md">
                        Edit
                    </a>

                    <form action="{{ route('tables.destroy', $table) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus meja ini?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
