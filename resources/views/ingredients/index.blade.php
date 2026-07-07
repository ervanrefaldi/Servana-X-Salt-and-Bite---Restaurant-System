@extends('layouts.pos')

@section('title', 'Kelola Bahan - Servana POS')

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    <!-- Page Header -->
    <div class="px-8 pt-8 pb-6 flex justify-between items-end border-b border-gray-100 shrink-0">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Manage Ingredients</h2>
            <p class="text-gray-500 text-sm">Monitor stock levels, status, and add new ingredients.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('stock-transactions.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium shadow-sm hover:bg-gray-50 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Stock Transactions
            </a>
            <a href="{{ route('ingredients.create') }}" class="px-4 py-2 bg-brand-red text-white rounded-lg text-sm font-medium shadow-sm hover:bg-[#8B121A] transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Ingredient
            </a>
        </div>
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
    </div>
</div>
@endsection