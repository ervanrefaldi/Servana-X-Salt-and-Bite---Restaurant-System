@extends('layouts.pos')

@section('title', 'Manajemen Meja - Servana POS')

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    <!-- Page Header -->
    <div class="px-8 pt-8 pb-6 flex justify-between items-end border-b border-gray-100 shrink-0">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Manajemen Meja</h2>
            <p class="text-gray-500 text-sm">Kelola tata letak dan kapasitas meja restoran.</p>
        </div>
        <a href="{{ route('tables.create') }}" class="px-4 py-2 bg-brand-red text-white rounded-lg text-sm font-medium shadow-sm hover:bg-[#8B121A] transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Meja
        </a>
    </div>

    <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
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

                                    @if(isset($deletableTableIds) && in_array($table->id, $deletableTableIds))
                                        <form action="{{ route('tables.destroy', $table) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus meja ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 ml-2">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" class="text-gray-400 ml-2 cursor-not-allowed" title="Hanya meja terakhir di abjad ini yang bisa dihapus">
                                            Hapus
                                        </button>
                                    @endif
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
    </div>
</div>
@endsection
