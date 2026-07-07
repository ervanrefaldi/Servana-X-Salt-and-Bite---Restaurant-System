@extends('layouts.pos')

@section('title', 'Tambah Bahan - Servana POS')

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    <!-- Page Header -->
    <div class="px-8 pt-8 pb-6 flex justify-between items-end border-b border-gray-100 shrink-0">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Tambah Bahan</h2>
            <p class="text-gray-500 text-sm">Tambahkan bahan baku baru ke dalam inventori dapur.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('ingredients.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium shadow-sm hover:bg-gray-50 transition-colors flex items-center gap-2">
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
                           class="inline-block px-6 py-2.5 rounded-lg text-sm font-medium transition-colors bg-white border border-gray-200 text-gray-700 hover:bg-gray-50">
                            Kembali
                        </a>

                        <button type="submit"
                                class="inline-block px-6 py-2.5 rounded-lg text-sm font-medium transition-colors bg-brand-red text-white hover:bg-[#8B121A] shadow-sm">
                            Simpan Bahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection