@extends('layouts.pos')

@section('title', 'Edit Menu - Servana POS')

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    <!-- Page Header -->
    <div class="px-8 pt-8 pb-6 flex justify-between items-end border-b border-gray-100 shrink-0">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Edit Menu</h2>
            <p class="text-gray-500 text-sm">Perbarui informasi menu dan resep bahan bakunya.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('menus.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium shadow-sm hover:bg-gray-50 transition-colors flex items-center gap-2">
                Batal
            </a>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white p-8 shadow-sm border border-gray-100 rounded-2xl">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Foto Menu
                        </label>
                        @if($menu->has_image)
                            <div class="mb-2">
                                <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="w-32 h-32 object-cover rounded-md shadow-sm">
                            </div>
                        @endif
                        <input type="file"
                               name="image"
                               accept="image/*"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                        <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, GIF (Maks. 2MB)</p>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Nama Menu
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name', $menu->name) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Kategori
                        </label>

                        <select name="category"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="Makanan" {{ old('category', $menu->category) == 'Makanan' ? 'selected' : '' }}>
                                Makanan
                            </option>

                            <option value="Minuman" {{ old('category', $menu->category) == 'Minuman' ? 'selected' : '' }}>
                                Minuman
                            </option>

                            <option value="Snack" {{ old('category', $menu->category) == 'Snack' ? 'selected' : '' }}>
                                Snack
                            </option>

                            <option value="Dessert" {{ old('category', $menu->category) == 'Dessert' ? 'selected' : '' }}>
                                Dessert
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Deskripsi
                        </label>

                        <textarea name="description"
                                  rows="4"
                                  class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $menu->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Harga
                        </label>

                        <input type="number"
                               name="price"
                               value="{{ old('price', $menu->price) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               min="0"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Bahan Baku (Ingredients)
                        </label>
                        <div id="ingredients-container">
                            @if(old('ingredients', $menu->menuIngredients->toArray()))
                                @foreach(old('ingredients', $menu->menuIngredients) as $index => $mi)
                                    <div class="ingredient-row flex gap-2 mb-2 items-center">
                                        <select name="ingredients[{{ $index }}][id]" class="w-1/2 border-gray-300 rounded-md shadow-sm">
                                            <option value="">-- Pilih Bahan --</option>
                                            @foreach($ingredients as $ingredient)
                                                <option value="{{ $ingredient->id }}" {{ (isset($mi['ingredient_id']) && $mi['ingredient_id'] == $ingredient->id) || (isset($mi['id']) && $mi['id'] == $ingredient->id) ? 'selected' : '' }}>{{ $ingredient->name }} ({{ $ingredient->unit }})</option>
                                            @endforeach
                                        </select>
                                        <input type="number" name="ingredients[{{ $index }}][quantity]" value="{{ $mi['quantity'] ?? '' }}" class="w-1/3 border-gray-300 rounded-md shadow-sm" placeholder="Jumlah (per porsi)" min="0.01" step="0.01">
                                        <button type="button" class="text-red-500 hover:text-red-700 remove-ingredient" style="{{ count(old('ingredients', $menu->menuIngredients)) === 1 ? 'display: none;' : '' }}">Hapus</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="ingredient-row flex gap-2 mb-2 items-center">
                                    <select name="ingredients[0][id]" class="w-1/2 border-gray-300 rounded-md shadow-sm">
                                        <option value="">-- Pilih Bahan --</option>
                                        @foreach($ingredients as $ingredient)
                                            <option value="{{ $ingredient->id }}">{{ $ingredient->name }} ({{ $ingredient->unit }})</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="ingredients[0][quantity]" class="w-1/3 border-gray-300 rounded-md shadow-sm" placeholder="Jumlah (per porsi)" min="0.01" step="0.01">
                                    <button type="button" class="text-red-500 hover:text-red-700 remove-ingredient" style="display: none;">Hapus</button>
                                </div>
                            @endif
                        </div>
                        <button type="button" id="add-ingredient" class="mt-2 text-sm text-blue-600 hover:text-blue-800">+ Tambah Bahan</button>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let ingredientIndex = {{ count(old('ingredients', $menu->menuIngredients)) > 0 ? count(old('ingredients', $menu->menuIngredients)) : 1 }};
                            const container = document.getElementById('ingredients-container');
                            const addButton = document.getElementById('add-ingredient');

                            addButton.addEventListener('click', function() {
                                const row = document.createElement('div');
                                row.className = 'ingredient-row flex gap-2 mb-2 items-center';
                                row.innerHTML = `
                                    <select name="ingredients[${ingredientIndex}][id]" class="w-1/2 border-gray-300 rounded-md shadow-sm">
                                        <option value="">-- Pilih Bahan --</option>
                                        @foreach($ingredients as $ingredient)
                                            <option value="{{ $ingredient->id }}">{{ $ingredient->name }} ({{ $ingredient->unit }})</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="ingredients[${ingredientIndex}][quantity]" class="w-1/3 border-gray-300 rounded-md shadow-sm" placeholder="Jumlah (per porsi)" min="0.01" step="0.01">
                                    <button type="button" class="text-red-500 hover:text-red-700 remove-ingredient">Hapus</button>
                                `;
                                container.appendChild(row);
                                ingredientIndex++;
                                
                                updateRemoveButtons();
                            });

                            container.addEventListener('click', function(e) {
                                if (e.target.classList.contains('remove-ingredient')) {
                                    e.target.closest('.ingredient-row').remove();
                                    updateRemoveButtons();
                                }
                            });

                            function updateRemoveButtons() {
                                const rows = container.querySelectorAll('.ingredient-row');
                                rows.forEach((row, index) => {
                                    const btn = row.querySelector('.remove-ingredient');
                                    if (rows.length === 1) {
                                        btn.style.display = 'none';
                                    } else {
                                        btn.style.display = 'block';
                                    }
                                });
                            }
                        });
                    </script>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Status Menu
                        </label>

                        <select name="is_available"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="1" {{ old('is_available', $menu->is_available) == '1' ? 'selected' : '' }}>
                                Tersedia
                            </option>

                            <option value="0" {{ old('is_available', $menu->is_available) == '0' ? 'selected' : '' }}>
                                Tidak Tersedia
                            </option>
                        </select>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('menus.index') }}"
                           class="inline-block px-6 py-2.5 rounded-lg text-sm font-medium transition-colors bg-white border border-gray-200 text-gray-700 hover:bg-gray-50">
                            Kembali
                        </a>

                        <button type="submit"
                                class="inline-block px-6 py-2.5 rounded-lg text-sm font-medium transition-colors bg-brand-red text-white hover:bg-[#8B121A] shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
