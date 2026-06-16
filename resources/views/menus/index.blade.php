<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kelola Menu
            </h2>

            <a href="{{ route('kasir.dashboard') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #2563eb; color: #ffffff;">
                Kembali ke Dashboard Kasir
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

            <div class="mb-4 flex justify-end">
                <a href="{{ route('menus.create') }}"
                   class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                   style="background-color: #16a34a; color: #ffffff;">
                    Tambah Menu
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-4 border">No</th>
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
                                <td colspan="7" class="p-4 border text-center text-gray-500">
                                    Belum ada data menu.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>