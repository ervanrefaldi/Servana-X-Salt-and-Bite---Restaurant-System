<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Bahan
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

                <form action="{{ route('ingredients.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Nama Bahan
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Contoh: Ayam, Beras, Telur"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Kategori
                        </label>

                        <input type="text"
                               name="category"
                               value="{{ old('category') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Contoh: Protein, Karbohidrat, Bumbu">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Satuan
                        </label>

                        <select name="unit"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="">-- Pilih Satuan --</option>
                            <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>kg</option>
                            <option value="gram" {{ old('unit') == 'gram' ? 'selected' : '' }}>gram</option>
                            <option value="liter" {{ old('unit') == 'liter' ? 'selected' : '' }}>liter</option>
                            <option value="ml" {{ old('unit') == 'ml' ? 'selected' : '' }}>ml</option>
                            <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>pcs</option>
                            <option value="pack" {{ old('unit') == 'pack' ? 'selected' : '' }}>pack</option>
                            <option value="box" {{ old('unit') == 'box' ? 'selected' : '' }}>box</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Stok Minimum
                            </label>

                            <input type="number"
                                   step="0.01"
                                   name="minimum_stock"
                                   value="{{ old('minimum_stock', 0) }}"
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
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>