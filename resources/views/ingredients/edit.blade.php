<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Bahan
            </h2>

            <a href="{{ route('ingredients.index') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #4b5563; color: #ffffff;">
                Kembali ke Kelola Bahan
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

                <form action="{{ route('ingredients.update', $ingredient) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Nama Bahan
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name', $ingredient->name) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Kategori
                        </label>

                        <input type="text"
                               name="category"
                               value="{{ old('category', $ingredient->category) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Satuan
                        </label>

                        <select name="unit"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            @foreach (['kg', 'gram', 'liter', 'ml', 'pcs', 'pack', 'box'] as $unit)
                                <option value="{{ $unit }}" {{ old('unit', $ingredient->unit) == $unit ? 'selected' : '' }}>
                                    {{ $unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Stok Saat Ini
                            </label>

                            <input type="number"
                                   step="0.01"
                                   name="current_stock"
                                   value="{{ old('current_stock', $ingredient->current_stock) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   min="0"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Stok Minimum
                            </label>

                            <input type="number"
                                   step="0.01"
                                   name="minimum_stock"
                                   value="{{ old('minimum_stock', $ingredient->minimum_stock) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   min="0"
                                   required>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('ingredients.index') }}"
                           class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                           style="background-color: #4b5563; color: #ffffff;">
                            Back
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