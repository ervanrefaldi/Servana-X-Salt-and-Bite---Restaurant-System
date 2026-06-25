<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Meja
            </h2>

            <a href="{{ route('tables.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm">
                Kembali
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

                <form action="{{ route('tables.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Grup Meja (A-J)</label>
                        <select name="table_group" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Pilih Grup Meja --</option>
                            @foreach(range('A', 'J') as $letter)
                                <option value="{{ $letter }}" {{ old('table_group') == $letter ? 'selected' : '' }}>
                                    Grup {{ $letter }} (Kapasitas {{ (ord($letter) - 64) * 2 }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Sistem akan secara otomatis menambahkan nomor urut pada nama meja (misal: A-8).</p>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Area Meja</label>
                        <select name="area" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Pilih Area --</option>
                            <option value="indoor" {{ old('area') == 'indoor' ? 'selected' : '' }}>
                                Indoor
                            </option>
                            <option value="outdoor" {{ old('area') == 'outdoor' ? 'selected' : '' }}>
                                Outdoor
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Status Meja</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>
                                Tersedia
                            </option>
                            <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>
                                Sudah Direservasi
                            </option>
                            <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>
                                Sedang Digunakan
                            </option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                Perbaikan
                            </option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
