<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Menu
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

                <form action="{{ route('menus.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Nama Menu
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Contoh: Chicken Rice Bowl"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Kategori
                        </label>

                        <select name="category"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="">-- Pilih Kategori --</option>

                            <option value="Makanan" {{ old('category') == 'Makanan' ? 'selected' : '' }}>
                                Makanan
                            </option>

                            <option value="Minuman" {{ old('category') == 'Minuman' ? 'selected' : '' }}>
                                Minuman
                            </option>

                            <option value="Snack" {{ old('category') == 'Snack' ? 'selected' : '' }}>
                                Snack
                            </option>

                            <option value="Dessert" {{ old('category') == 'Dessert' ? 'selected' : '' }}>
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
                                  class="w-full border-gray-300 rounded-md shadow-sm"
                                  placeholder="Deskripsi singkat menu">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Harga
                        </label>

                        <input type="number"
                               name="price"
                               value="{{ old('price') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Contoh: 28000"
                               min="0"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Bahan Baku (Ingredients)
                        </label>
                        <div id="ingredients-container">
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
                        </div>
                        <button type="button" id="add-ingredient" class="mt-2 text-sm text-blue-600 hover:text-blue-800">+ Tambah Bahan</button>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let ingredientIndex = 1;
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
                            <option value="1" {{ old('is_available', '1') == '1' ? 'selected' : '' }}>
                                Tersedia
                            </option>

                            <option value="0" {{ old('is_available') == '0' ? 'selected' : '' }}>
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
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>