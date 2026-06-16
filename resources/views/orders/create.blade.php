<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Buat Transaksi
            </h2>

            <a href="{{ route('kasir.dashboard') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #2563eb; color: #ffffff;">
                Kembali ke Dashboard Kasir
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
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

                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-2 font-medium">
                                Status Customer
                            </label>

                            <select name="customer_type"
                                    id="customer_type"
                                    class="w-full border-gray-300 rounded-md shadow-sm"
                                    required>
                                <option value="non_member" {{ old('customer_type') == 'non_member' ? 'selected' : '' }}>
                                    Non-Member
                                </option>

                                <option value="member" {{ old('customer_type') == 'member' ? 'selected' : '' }}>
                                    Member
                                </option>
                            </select>

                            <p class="text-sm text-gray-500 mt-1">
                                Jika member, diskon 5% otomatis diterapkan.
                            </p>
                        </div>

                        <div id="member_code_box" style="display: none;">
                            <label class="block mb-2 font-medium">
                                Kode Membership
                            </label>

                            <input type="text"
                                   name="member_code"
                                   id="member_code"
                                   value="{{ old('member_code') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   placeholder="Contoh: MBR002">

                            <p id="member_message" class="text-sm mt-1"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-2 font-medium">
                                Atas Nama
                            </label>

                            <input type="text"
                                   name="customer_name"
                                   id="customer_name"
                                   value="{{ old('customer_name') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   placeholder="Nama customer"
                                   required>
                        </div>

                        <div>
                            <label class="block mb-2 font-medium">
                                Nomor HP
                            </label>

                            <input type="text"
                                   name="customer_phone"
                                   id="customer_phone"
                                   value="{{ old('customer_phone') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   placeholder="Opsional">
                        </div>
                    </div>

                    <hr class="my-6">

                    <h3 class="text-lg font-semibold mb-4">
                        Pilih Menu
                    </h3>

                    <div class="space-y-4">
                        @forelse ($menus as $menu)
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center border p-4 rounded-md">
                                <div class="md:col-span-2">
                                    <p class="font-semibold">
                                        {{ $menu->name }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        {{ $menu->category }} |
                                        Rp{{ number_format($menu->price, 0, ',', '.') }}
                                    </p>

                                    <p class="text-sm mt-1">
                                        Stok:
                                        @if ($menu->stock > 0)
                                            <span class="text-green-600 font-semibold">
                                                {{ $menu->stock }}
                                            </span>
                                        @else
                                            <span class="text-red-600 font-semibold">
                                                Habis
                                            </span>
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">Harga</p>
                                    <p class="font-semibold">
                                        Rp{{ number_format($menu->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm text-gray-500 mb-1">
                                        Jumlah
                                    </label>

                                    <div class="flex items-center gap-2">
                                        <button type="button"
                                                class="px-3 py-2 rounded-md shadow"
                                                style="background-color: #4b5563; color: #ffffff;"
                                                onclick="decreaseQty({{ $menu->id }})"
                                                {{ $menu->stock <= 0 ? 'disabled' : '' }}>
                                            -
                                        </button>

                                        <input type="number"
                                               name="quantities[{{ $menu->id }}]"
                                               id="qty_{{ $menu->id }}"
                                               value="{{ old('quantities.' . $menu->id, 0) }}"
                                               min="0"
                                               max="{{ $menu->stock }}"
                                               data-price="{{ $menu->price }}"
                                               data-stock="{{ $menu->stock }}"
                                               class="w-20 border-gray-300 rounded-md shadow-sm text-center qty-input"
                                               onchange="validateQty({{ $menu->id }}); updateSummary();"
                                               {{ $menu->stock <= 0 ? 'readonly' : '' }}>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">Subtotal</p>
                                    <p class="font-semibold" id="subtotal_{{ $menu->id }}">
                                        Rp0
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 border rounded-md text-center text-gray-500">
                                Belum ada menu tersedia.
                            </div>
                        @endforelse
                    </div>

                    <hr class="my-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block mb-2 font-medium">
                                Metode Pembayaran
                            </label>

                            <select name="payment_method"
                                    class="w-full border-gray-300 rounded-md shadow-sm"
                                    required>
                                <option value="cash">Cash</option>
                                <option value="debit">Debit</option>
                                <option value="qris">QRIS</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <h3 class="font-semibold mb-3">
                                Ringkasan Transaksi
                            </h3>

                            <div class="flex justify-between mb-2">
                                <span>Subtotal</span>
                                <span id="summary_subtotal">Rp0</span>
                            </div>

                            <div class="flex justify-between mb-2">
                                <span>Diskon Member 5%</span>
                                <span id="summary_discount">Rp0</span>
                            </div>

                            <div class="flex justify-between font-bold text-lg border-t pt-2">
                                <span>Total Bayar</span>
                                <span id="summary_total">Rp0</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('orders.index') }}"
                           class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                           style="background-color: #4b5563; color: #ffffff;">
                            Kembali ke Kelola Transaksi
                        </a>

                        <button type="submit"
                                class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                                style="background-color: #2563eb; color: #ffffff;">
                            Selesaikan Pemesanan & Tampilkan Invoice
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function formatRupiah(number) {
            return 'Rp' + new Intl.NumberFormat('id-ID').format(number);
        }

        function decreaseQty(menuId) {
            const input = document.getElementById('qty_' + menuId);
            let value = parseInt(input.value || 0);

            if (value > 0) {
                input.value = value - 1;
            }

            updateSummary();
        }

        function validateQty(menuId) {
            const input = document.getElementById('qty_' + menuId);
            const stock = parseInt(input.dataset.stock || 0);
            let value = parseInt(input.value || 0);

            if (value < 0) {
                value = 0;
            }

            if (value > stock) {
                value = stock;
            }

            input.value = value;
        }

        function updateSummary() {
            let subtotal = 0;

            document.querySelectorAll('.qty-input').forEach(function(input) {
                const menuId = input.id.replace('qty_', '');
                const qty = parseInt(input.value || 0);
                const price = parseFloat(input.dataset.price || 0);
                const itemSubtotal = qty * price;

                subtotal += itemSubtotal;

                const subtotalElement = document.getElementById('subtotal_' + menuId);

                if (subtotalElement) {
                    subtotalElement.textContent = formatRupiah(itemSubtotal);
                }
            });

            const customerType = document.getElementById('customer_type').value;
            const discount = customerType === 'member' ? subtotal * 0.05 : 0;
            const total = subtotal - discount;

            document.getElementById('summary_subtotal').textContent = formatRupiah(subtotal);
            document.getElementById('summary_discount').textContent = formatRupiah(discount);
            document.getElementById('summary_total').textContent = formatRupiah(total);
        }

        function toggleMemberInput() {
            const customerType = document.getElementById('customer_type').value;
            const memberBox = document.getElementById('member_code_box');
            const memberCodeInput = document.getElementById('member_code');
            const nameInput = document.getElementById('customer_name');
            const phoneInput = document.getElementById('customer_phone');
            const message = document.getElementById('member_message');

            if (customerType === 'member') {
                memberBox.style.display = 'block';

                nameInput.readOnly = true;
                phoneInput.readOnly = true;

                nameInput.classList.add('bg-gray-100');
                phoneInput.classList.add('bg-gray-100');

                message.innerHTML = 'Masukkan kode membership customer.';
                message.className = 'text-sm mt-1 text-gray-500';
            } else {
                memberBox.style.display = 'none';
                memberCodeInput.value = '';

                nameInput.readOnly = false;
                phoneInput.readOnly = false;

                nameInput.classList.remove('bg-gray-100');
                phoneInput.classList.remove('bg-gray-100');

                nameInput.value = '';
                phoneInput.value = '';

                message.innerHTML = '';

                updateSummary();
            }
        }

        function checkMemberCode() {
            const customerType = document.getElementById('customer_type').value;

            if (customerType !== 'member') {
                return;
            }

            const memberCode = document.getElementById('member_code').value.trim();
            const nameInput = document.getElementById('customer_name');
            const phoneInput = document.getElementById('customer_phone');
            const message = document.getElementById('member_message');

            if (memberCode.length < 3) {
                nameInput.value = '';
                phoneInput.value = '';
                message.innerHTML = 'Masukkan kode membership customer.';
                message.className = 'text-sm mt-1 text-gray-500';
                updateSummary();
                return;
            }

            fetch(`/orders/check-member/${encodeURIComponent(memberCode)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        nameInput.value = data.customer.name;
                        phoneInput.value = data.customer.phone ?? '';

                        message.innerHTML = 'Member ditemukan. Diskon 5% otomatis diterapkan.';
                        message.className = 'text-sm mt-1 text-green-600';
                    } else {
                        nameInput.value = '';
                        phoneInput.value = '';

                        message.innerHTML = 'Kode membership tidak ditemukan.';
                        message.className = 'text-sm mt-1 text-red-600';
                    }

                    updateSummary();
                })
                .catch(() => {
                    nameInput.value = '';
                    phoneInput.value = '';

                    message.innerHTML = 'Kode membership tidak ditemukan.';
                    message.className = 'text-sm mt-1 text-red-600';

                    updateSummary();
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('customer_type').addEventListener('change', toggleMemberInput);
            document.getElementById('member_code').addEventListener('keyup', checkMemberCode);
            document.getElementById('member_code').addEventListener('change', checkMemberCode);

            toggleMemberInput();
            updateSummary();
        });
    </script>
</x-app-layout>