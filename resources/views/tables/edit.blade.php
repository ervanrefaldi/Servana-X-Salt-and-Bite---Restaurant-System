<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Meja
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

                <form action="{{ route('tables.update', $table) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Nomor Meja</label>
                        <input type="text" value="Meja {{ $table->table_number }} (Kapasitas {{ $table->capacity }})" class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100" disabled>
                        <p class="text-sm text-gray-500 mt-1">Nomor meja tidak dapat diubah setelah dibuat.</p>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Area Meja</label>
                        <select name="area" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="indoor" {{ old('area', $table->area) == 'indoor' ? 'selected' : '' }}>
                                Indoor
                            </option>
                            <option value="outdoor" {{ old('area', $table->area) == 'outdoor' ? 'selected' : '' }}>
                                Outdoor
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Status Meja</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="available"
                                {{ old('status', $table->status) == 'available' ? 'selected' : '' }}>
                                Tersedia
                            </option>
                            <option value="reserved"
                                {{ old('status', $table->status) == 'reserved' ? 'selected' : '' }}>
                                Sudah Direservasi
                            </option>
                            <option value="occupied"
                                {{ old('status', $table->status) == 'occupied' ? 'selected' : '' }}>
                                Sedang Digunakan
                            </option>
                            <option value="maintenance"
                                {{ old('status', $table->status) == 'maintenance' ? 'selected' : '' }}>
                                Perbaikan
                            </option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-md">
                            Update
                        </button>
                    </div>
                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('tables.index') }}"
                            class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                            Back
                        </a>

                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
