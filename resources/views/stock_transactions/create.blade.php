<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Transaksi Stok
            </h2>

            <a href="{{ route('stock-transactions.index') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #4b5563; color: #ffffff;">
                Kembali ke Riwayat Stok
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

                @if ($ingredients->count() === 0)
                    <div class="mb-4 p-4 bg-yellow-100 text-yellow-700 rounded">
                        Belum ada master bahan. Silakan tambahkan bahan terlebih dahulu sebelum membuat transaksi stok.
                    </div>

                    <a href="{{ route('ingredients.create') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #2563eb; color: #ffffff;">
                        Tambah Bahan
                    </a>
                @else
                    <form action="{{ route('stock-transactions.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Pilih Bahan
                            </label>

                            <select name="ingredient_id"
                                    id="ingredient_id"
                                    class="w-full border-gray-300 rounded-md shadow-sm"
                                    required>
                                <option value="">-- Pilih Bahan --</option>

                                @foreach ($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}"
                                            data-unit="{{ $ingredient->unit }}"
                                            data-stock="{{ $ingredient->current_stock }}"
                                            {{ old('ingredient_id') == $ingredient->id ? 'selected' : '' }}>
                                        {{ $ingredient->name }}
                                        - Stok:
                                        {{ number_format($ingredient->current_stock, 2, ',', '.') }}
                                        {{ $ingredient->unit }}
                                    </option>
                                @endforeach
                            </select>

                            <p class="text-sm text-gray-500 mt-1" id="ingredient_info">
                                Pilih bahan untuk melihat stok dan satuannya.
                            </p>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Supplier
                            </label>

                            <input type="text"
                                   name="supplier_name"
                                   value="{{ old('supplier_name') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   placeholder="Opsional, isi jika transaksi masuk dari supplier">
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Tipe Transaksi
                            </label>

                            <select name="type"
                                    id="type"
                                    class="w-full border-gray-300 rounded-md shadow-sm"
                                    required>
                                <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>
                                    Masuk
                                </option>

                                <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>
                                    Keluar
                                </option>
                            </select>

                            <p class="text-sm text-gray-500 mt-1">
                                Masuk = stok bertambah dan tercatat sebagai pengeluaran keuangan.
                                Keluar = stok berkurang tanpa mencatat pengeluaran baru.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block mb-2 font-medium">
                                    Jumlah
                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="quantity"
                                       id="quantity"
                                       value="{{ old('quantity') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm"
                                       placeholder="Contoh: 10"
                                       min="0.01"
                                       required>
                            </div>

                            <div class="mb-4">
                                <label class="block mb-2 font-medium">
                                    Satuan
                                </label>

                                <input type="text"
                                       id="unit_display"
                                       class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100"
                                       value="-"
                                       readonly>

                                <p class="text-sm text-gray-500 mt-1">
                                    Satuan otomatis mengikuti master bahan.
                                </p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Harga Satuan
                            </label>

                            <input type="number"
                                   name="unit_price"
                                   id="unit_price"
                                   value="{{ old('unit_price', 0) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   placeholder="Contoh: 15000"
                                   min="0"
                                   required>

                            <p class="text-sm text-gray-500 mt-1">
                                Untuk transaksi keluar, harga satuan boleh 0.
                            </p>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Total Harga
                            </label>

                            <input type="text"
                                   id="total_price_display"
                                   value="Rp0"
                                   class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100"
                                   readonly>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Tanggal Transaksi
                            </label>

                            <input type="date"
                                   name="transaction_date"
                                   value="{{ old('transaction_date', now()->toDateString()) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Deskripsi
                            </label>

                            <textarea name="description"
                                      rows="4"
                                      class="w-full border-gray-300 rounded-md shadow-sm"
                                      placeholder="Keterangan tambahan">{{ old('description') }}</textarea>
                        </div>

                        <div class="flex justify-between items-center mt-6">
                            <a href="{{ route('stock-transactions.index') }}"
                               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                               style="background-color: #4b5563; color: #ffffff;">
                                Back
                            </a>

                            <button type="submit"
                                    class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                                    style="background-color: #2563eb; color: #ffffff;">
                                Simpan Transaksi
                            </button>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>

    <script>
        function formatRupiah(number) {
            return 'Rp' + new Intl.NumberFormat('id-ID').format(number);
        }

        function updateIngredientInfo() {
            const select = document.getElementById('ingredient_id');
            const selected = select.options[select.selectedIndex];
            const unit = selected.getAttribute('data-unit') || '-';
            const stock = selected.getAttribute('data-stock') || '0';

            document.getElementById('unit_display').value = unit;
            document.getElementById('ingredient_info').innerHTML = 'Stok saat ini: ' + stock + ' ' + unit;
        }

        function updateTotalPrice() {
            const type = document.getElementById('type').value;
            const quantity = parseFloat(document.getElementById('quantity').value || 0);
            const unitPrice = parseFloat(document.getElementById('unit_price').value || 0);

            const total = type === 'in' ? quantity * unitPrice : 0;

            document.getElementById('total_price_display').value = formatRupiah(total);
        }

        function handleTypeChange() {
            const type = document.getElementById('type').value;
            const unitPrice = document.getElementById('unit_price');

            if (type === 'out') {
                unitPrice.value = 0;
            }

            updateTotalPrice();
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('ingredient_id').addEventListener('change', updateIngredientInfo);
            document.getElementById('type').addEventListener('change', handleTypeChange);
            document.getElementById('quantity').addEventListener('input', updateTotalPrice);
            document.getElementById('unit_price').addEventListener('input', updateTotalPrice);

            updateIngredientInfo();
            updateTotalPrice();
        });
    </script>
</x-app-layout>