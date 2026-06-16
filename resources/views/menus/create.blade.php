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
                            Stok
                        </label>

                        <input type="number"
                               name="stock"
                               value="{{ old('stock', 0) }}"
                               min="0"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Contoh: 10"
                               required>
                    </div>

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