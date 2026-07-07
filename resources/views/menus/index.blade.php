@extends('layouts.pos')

@section('title', 'Kelola Menu - Servana POS')

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    <!-- Page Header -->
    <div class="px-8 pt-8 pb-6 flex justify-between items-end border-b border-gray-100 shrink-0">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Kelola Menu</h2>
            <p class="text-gray-500 text-sm">Daftar semua menu yang tersedia.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('menus.create') }}" class="px-4 py-2 bg-brand-red text-white rounded-lg text-sm font-medium shadow-sm hover:bg-[#8B121A] transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Menu
            </a>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
        <div class="max-w-7xl mx-auto">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-50 text-green-700 border border-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-4 border">No</th>
                            <th class="p-4 border">Foto</th>
                            <th class="p-4 border">Nama Menu</th>
                            <th class="p-4 border">Kategori</th>
                            <th class="p-4 border">Harga</th>
                            <th class="p-4 border">Stok</th>
                            <th class="p-4 border">Status</th>
                            <th class="p-4 border">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($menus as $index => $menu)
                            <tr>
                                <td class="p-4 border">
                                    {{ $index + 1 }}
                                </td>

                                <td class="p-4 border text-center">
                                    @if($menu->image)
                                        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-12 h-12 object-cover rounded mx-auto">
                                    @else
                                        <span class="text-gray-400 text-xs">No Image</span>
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    {{ $menu->name }}
                                </td>

                                <td class="p-4 border">
                                    {{ $menu->category }}
                                </td>

                                <td class="p-4 border">
                                    Rp{{ number_format($menu->price, 0, ',', '.') }}
                                </td>

                                <td class="p-4 border">
                                    @if ($menu->stock > 0)
                                        <span class="text-green-600 font-semibold">
                                            {{ $menu->stock }}
                                        </span>
                                    @else
                                        <span class="text-red-600 font-semibold">
                                            Habis
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    @if ($menu->is_available)
                                        <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700">
                                            Tidak Tersedia
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    <a href="{{ route('menus.show', $menu) }}"
                                       class="text-blue-600 hover:underline">
                                        Detail
                                    </a>

                                    <a href="{{ route('menus.edit', $menu) }}"
                                       class="text-yellow-600 hover:underline ml-2">
                                        Edit
                                    </a>

                                    <form action="{{ route('menus.destroy', $menu) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
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
                                    Belum ada data menu.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection