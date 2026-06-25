<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Menu
            </h2>

            <a href="{{ route('kasir.dashboard') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #2563eb; color: #ffffff;">
                Kembali ke Dashboard Kasir
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('menus.update', $menu) }}" method="POST">
                    @csrf
                    @method('PUT')

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
                           class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                           style="background-color: #4b5563; color: #ffffff;">
                            Kembali ke Kelola Menu
                        </a>

                        <button type="submit"
                                class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                                style="background-color: #2563eb; color: #ffffff;">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>