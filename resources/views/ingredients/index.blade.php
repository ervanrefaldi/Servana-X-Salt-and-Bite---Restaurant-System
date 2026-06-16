<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kelola Bahan
            </h2>

            <a href="{{ route('dapur.dashboard') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #2563eb; color: #ffffff;">
                Kembali ke Dashboard Dapur
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
                    <p class="text-sm text-gray-500">Total Bahan</p>
                    <h3 class="text-2xl font-bold">
                        {{ $totalIngredients }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Stok Menipis</p>
                    <h3 class="text-2xl font-bold text-yellow-600">
                        {{ $lowStockIngredients }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Stok Habis</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        {{ $emptyStockIngredients }}
                    </h3>
                </div>
            </div>

            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('stock-transactions.index') }}"
                   class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                   style="background-color: #4b5563; color: #ffffff;">
                    Riwayat Transaksi Stok
                </a>

                <a href="{{ route('ingredients.create') }}"
                   class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                   style="background-color: #16a34a; color: #ffffff;">
                    Tambah Bahan
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-4 border">No</th>
                            <th class="p-4 border">Nama Bahan</th>
                            <th class="p-4 border">Kategori</th>
                            <th class="p-4 border">Satuan</th>
                            <th class="p-4 border">Stok Saat Ini</th>
                            <th class="p-4 border">Stok Minimum</th>
                            <th class="p-4 border">Status</th>
                            <th class="p-4 border">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($ingredients as $index => $ingredient)
                            <tr>
                                <td class="p-4 border">
                                    {{ $index + 1 }}
                                </td>

                                <td class="p-4 border font-semibold">
                                    {{ $ingredient->name }}
                                </td>

                                <td class="p-4 border">
                                    {{ $ingredient->category ?? '-' }}
                                </td>

                                <td class="p-4 border">
                                    {{ $ingredient->unit }}
                                </td>

                                <td class="p-4 border">
                                    {{ number_format($ingredient->current_stock, 2, ',', '.') }}
                                    {{ $ingredient->unit }}
                                </td>

                                <td class="p-4 border">
                                    {{ number_format($ingredient->minimum_stock, 2, ',', '.') }}
                                    {{ $ingredient->unit }}
                                </td>

                                <td class="p-4 border">
                                    @if ($ingredient->stock_status === 'Aman')
                                        <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">
                                            Aman
                                        </span>
                                    @elseif ($ingredient->stock_status === 'Stok Menipis')
                                        <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-700">
                                            Stok Menipis
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700">
                                            Habis
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    <a href="{{ route('ingredients.show', $ingredient) }}"
                                       class="text-blue-600 hover:underline">
                                        Detail
                                    </a>

                                    <a href="{{ route('ingredients.edit', $ingredient) }}"
                                       class="text-yellow-600 hover:underline ml-2">
                                        Edit
                                    </a>

                                    <form action="{{ route('ingredients.destroy', $ingredient) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus bahan ini?')">
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
                                    Belum ada data bahan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>