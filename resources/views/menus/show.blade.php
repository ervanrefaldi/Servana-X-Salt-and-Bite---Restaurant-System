<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Menu
            </h2>

            <a href="{{ route('menus.index') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Nama Menu</p>
                    <p class="text-lg font-semibold">{{ $menu->name }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Kategori</p>
                    <p class="text-lg font-semibold">{{ $menu->category }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Deskripsi</p>
                    <p class="text-lg">{{ $menu->description ?? '-' }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Harga</p>
                    <p class="text-lg font-semibold">
                        Rp{{ number_format($menu->price, 0, ',', '.') }}
                    </p>
                </div>
                <div class="mb-4">
                    <p class="text-sm text-gray-500">Stok</p>
                    <p class="text-lg font-semibold">
                        {{ $menu->stock }}
                    </p>
                </div>
                <div class="mb-4">
                    <p class="text-sm text-gray-500">Status</p>
                    @if ($menu->is_available)
                        <p class="text-lg font-semibold text-green-600">Tersedia</p>
                    @else
                        <p class="text-lg font-semibold text-red-600">Tidak Tersedia</p>
                    @endif
                </div>

                <div class="flex gap-2 mt-6">
                    <a href="{{ route('menus.edit', $menu) }}"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                        Edit
                    </a>

                    <form action="{{ route('menus.destroy', $menu) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
