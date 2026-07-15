@extends('layouts.pos')

@section('title', 'Kasir POS - Servana POS')

@section('content')
<div class="flex-1 flex overflow-hidden bg-gray-50 h-full">
    
    <!-- Left Section: Menu Items -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Categories -->
        <div class="px-8 py-6 flex gap-3 overflow-x-auto shrink-0 hide-scrollbar">
            <button class="px-6 py-2 bg-brand-red text-white rounded-full text-sm font-semibold shrink-0">Semua Menu</button>
            <button class="px-6 py-2 bg-white text-gray-600 border border-gray-200 rounded-full text-sm font-semibold hover:border-gray-300 shrink-0">Hidangan Pembuka</button>
            <button class="px-6 py-2 bg-white text-gray-600 border border-gray-200 rounded-full text-sm font-semibold hover:border-gray-300 shrink-0">Hidangan Utama</button>
            <button class="px-6 py-2 bg-white text-gray-600 border border-gray-200 rounded-full text-sm font-semibold hover:border-gray-300 shrink-0">Hidangan Penutup</button>
            <button class="px-6 py-2 bg-white text-gray-600 border border-gray-200 rounded-full text-sm font-semibold hover:border-gray-300 shrink-0">Minuman</button>
        </div>

        @if (session('success'))
            <div class="mx-8 mb-4 p-3 bg-green-50 text-green-700 text-sm rounded-lg border border-green-100 shrink-0">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mx-8 mb-4 p-3 bg-red-50 text-red-700 text-sm rounded-lg border border-red-100 shrink-0">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Menu Grid -->
        <div class="flex-1 overflow-y-auto px-8 pb-8 custom-scrollbar">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($menus as $menu)
                <div class="bg-white rounded-2xl p-3 shadow-sm border border-gray-100 flex flex-col relative group cursor-pointer hover:shadow-md transition-shadow">
                    <!-- Price Tag -->
                    <div class="absolute top-5 right-5 bg-white/90 backdrop-blur-sm px-2 py-1 rounded text-xs font-bold text-gray-800 z-10 shadow-sm">
                        ${{ number_format($menu->price / 15000, 2) }} <!-- Displaying in USD roughly for design parity, actual logic remains Rp -->
                    </div>
                    
                    <!-- Image -->
                    <div class="aspect-video w-full rounded-xl bg-gray-100 mb-4 overflow-hidden">
                        @if ($menu->has_image)
                            <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <img src="{{ asset('images/logo/servana-logo.png') }}" alt="Gambar {{ $menu->name }} belum tersedia" class="w-full h-full object-contain p-6 bg-white">
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="flex-1 px-1">
                        <h3 class="font-bold text-gray-900 mb-1 leading-tight">{{ $menu->name }}</h3>
                        <p class="text-xs text-gray-500 line-clamp-2">{{ $menu->category }} - {{ $menu->stock > 0 ? 'Stok: ' . $menu->stock : 'Stok Habis' }}</p>
                    </div>

                    <!-- Action -->
                    <div class="mt-4 flex justify-between items-center px-1 pb-1">
                        <span class="font-bold text-brand-red">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
                        
                        <div class="flex items-center gap-2">
                            <button type="button" class="w-8 h-8 rounded-full bg-[#FDEAE8] text-brand-red flex items-center justify-center hover:bg-brand-red hover:text-white transition-colors" onclick="decreaseQty({{ $menu->id }})">
                                -
                            </button>
                            <input type="number" 
                                id="qty_{{ $menu->id }}" 
                                value="0" 
                                min="0" 
                                max="{{ $menu->stock }}" 
                                data-price="{{ $menu->price }}"
                                data-stock="{{ $menu->stock }}"
                                data-name="{{ $menu->name }}"
                                class="w-10 text-center bg-transparent border-none text-sm font-bold p-0 focus:ring-0 qty-input"
                                onchange="validateQty({{ $menu->id }}); updateSummary();"
                                readonly>
                            <button type="button" class="w-8 h-8 rounded-full bg-[#FDEAE8] text-brand-red flex items-center justify-center hover:bg-brand-red hover:text-white transition-colors" onclick="increaseQty({{ $menu->id }})" {{ $menu->stock <= 0 ? 'disabled' : '' }}>
                                +
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 text-gray-400">Belum ada menu tersedia.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Section: Cart -->
    <div class="w-[400px] bg-white border-l border-gray-100 flex flex-col shrink-0">
        <form action="{{ route('orders.store') }}" method="POST" class="flex flex-col h-full" id="orderForm">
            @csrf
            
            <div class="p-6 border-b border-gray-100">
                <div class="flex justify-between items-start mb-2">
                    <h2 class="text-2xl font-bold text-gray-900">Pesanan Saat Ini</h2>
                    <button type="button" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                    </button>
                </div>
                <p class="text-sm text-gray-500">Bawa Pulang / Makan di Tempat</p>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar" id="cart_items_container">
                <div class="text-center py-8 text-gray-400 text-sm" id="empty_cart_msg">
                    No items in cart.
                </div>
                <!-- Cart items will be injected here via JS -->
            </div>

            <!-- Customer & Payment Details (Hidden inputs populated by JS or fixed inputs) -->
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                
                <!-- Customer Name & Phone -->
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <input type="text" name="customer_name" id="customer_name" class="w-full border-gray-200 rounded-lg text-sm focus:ring-brand-red focus:border-brand-red" placeholder="Customer Name" required>
                    <input type="text" name="customer_phone" id="customer_phone" class="w-full border-gray-200 rounded-lg text-sm focus:ring-brand-red focus:border-brand-red" placeholder="Phone (Opt)">
                </div>

                <div class="flex gap-2 mb-4">
                    <select name="customer_type" id="customer_type" class="w-1/3 border-gray-200 rounded-lg text-sm focus:ring-brand-red focus:border-brand-red" required>
                        <option value="non_member">Reguler</option>
                        <option value="member">Member</option>
                    </select>
                    <input type="text" name="member_code" id="member_code" class="flex-1 border-gray-200 rounded-lg text-sm focus:ring-brand-red focus:border-brand-red bg-white" placeholder="Member ID or Promo" style="display: none;">
                    <select name="payment_method" id="payment_method" class="flex-1 border-gray-200 rounded-lg text-sm focus:ring-brand-red focus:border-brand-red" required>
                        <option value="cash">Tunai</option>
                        <option value="debit">Debit</option>
                        <option value="qris">QRIS</option>
                        <option value="transfer">Transfer</option>
                    </select>
                </div>
                <p id="member_message" class="text-xs mt-1 mb-3 text-gray-500 hidden"></p>

                <!-- Hidden inputs for quantities so they submit correctly -->
                <div id="hidden_quantities"></div>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-500">
                        <span>Subtotal</span>
                        <span id="summary_subtotal">Rp0</span>
                    </div>
                    <div class="flex justify-between text-brand-red">
                        <span>Diskon Member (5%)</span>
                        <span id="summary_discount">-Rp0</span>
                    </div>
                    <!-- Assuming Tax is included or 0, showing it statically for design parity -->
                    <div class="flex justify-between text-gray-500">
                        <span>Pajak (0%)</span>
                        <span>Rp0</span>
                    </div>
                </div>

                <div class="flex justify-between items-end mt-4 mb-6">
                    <span class="text-xl font-bold text-gray-900">Total</span>
                    <span class="text-3xl font-bold text-brand-red" id="summary_total">Rp0</span>
                </div>

                <div class="flex gap-3">
                    <button type="button" class="px-4 py-3 border border-gray-200 rounded-xl text-gray-600 font-semibold text-sm hover:bg-gray-100 transition-colors bg-white">
                        Save for<br>Later
                    </button>
                    <button type="submit" class="flex-1 bg-brand-red text-white rounded-xl font-bold text-lg flex items-center justify-center gap-2 hover:bg-[#8B121A] transition-colors shadow-md">
                        Proceed to Payment
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    /* Remove arrows from number input */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
</style>

@push('scripts')
<script>
    function formatRupiah(number) {
        return 'Rp' + new Intl.NumberFormat('id-ID').format(number);
    }

    function increaseQty(menuId) {
        const input = document.getElementById('qty_' + menuId);
        const stock = parseInt(input.dataset.stock || 0);
        let value = parseInt(input.value || 0);

        if (value < stock) {
            input.value = value + 1;
            updateSummary();
        }
    }

    function decreaseQty(menuId) {
        const input = document.getElementById('qty_' + menuId);
        let value = parseInt(input.value || 0);

        if (value > 0) {
            input.value = value - 1;
            updateSummary();
        }
    }

    function validateQty(menuId) {
        const input = document.getElementById('qty_' + menuId);
        const stock = parseInt(input.dataset.stock || 0);
        let value = parseInt(input.value || 0);

        if (value < 0) value = 0;
        if (value > stock) value = stock;

        input.value = value;
    }

    function updateSummary() {
        let subtotal = 0;
        const cartContainer = document.getElementById('cart_items_container');
        const emptyMsg = document.getElementById('empty_cart_msg');
        const hiddenQuantities = document.getElementById('hidden_quantities');
        
        // Clear cart display
        let cartHtml = '';
        let hiddenHtml = '';
        let hasItems = false;

        document.querySelectorAll('.qty-input').forEach(function(input) {
            const menuId = input.id.replace('qty_', '');
            const qty = parseInt(input.value || 0);
            
            if (qty > 0) {
                hasItems = true;
                const price = parseFloat(input.dataset.price || 0);
                const name = input.dataset.name;
                const itemSubtotal = qty * price;
                subtotal += itemSubtotal;

                // Build cart item HTML
                cartHtml += `
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 flex gap-3 relative">
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900 text-sm mb-1">${name}</h4>
                        <p class="text-xs text-gray-500 mb-2">${formatRupiah(price)} x ${qty}</p>
                        <p class="font-bold text-gray-900">${formatRupiah(itemSubtotal)}</p>
                    </div>
                    <div class="flex flex-col items-center justify-between bg-white rounded-lg border border-gray-200 px-1 py-1">
                        <button type="button" class="w-6 h-6 text-gray-500 hover:text-brand-red flex items-center justify-center" onclick="increaseQty(${menuId})">+</button>
                        <span class="text-xs font-bold">${qty}</span>
                        <button type="button" class="w-6 h-6 text-gray-500 hover:text-brand-red flex items-center justify-center" onclick="decreaseQty(${menuId})">-</button>
                    </div>
                </div>
                `;

                // Add hidden inputs for form submission
                hiddenHtml += `<input type="hidden" name="quantities[${menuId}]" value="${qty}">`;
            }
        });

        if (hasItems) {
            emptyMsg.style.display = 'none';
            // Remove previous items (keep the empty msg hidden)
            const existingItems = cartContainer.querySelectorAll('.bg-gray-50.rounded-xl');
            existingItems.forEach(item => item.remove());
            cartContainer.insertAdjacentHTML('beforeend', cartHtml);
        } else {
            emptyMsg.style.display = 'block';
            const existingItems = cartContainer.querySelectorAll('.bg-gray-50.rounded-xl');
            existingItems.forEach(item => item.remove());
        }

        hiddenQuantities.innerHTML = hiddenHtml;

        const customerType = document.getElementById('customer_type').value;
        const discount = customerType === 'member' ? subtotal * 0.05 : 0;
        const total = subtotal - discount;

        document.getElementById('summary_subtotal').textContent = formatRupiah(subtotal);
        document.getElementById('summary_discount').textContent = '-' + formatRupiah(discount);
        document.getElementById('summary_total').textContent = formatRupiah(total);
    }

    function toggleMemberInput() {
        const customerType = document.getElementById('customer_type').value;
        const memberCodeInput = document.getElementById('member_code');
        const nameInput = document.getElementById('customer_name');
        const phoneInput = document.getElementById('customer_phone');
        const message = document.getElementById('member_message');

        if (customerType === 'member') {
            memberCodeInput.style.display = 'block';
            nameInput.readOnly = true;
            phoneInput.readOnly = true;
            nameInput.classList.add('bg-gray-100');
            phoneInput.classList.add('bg-gray-100');
            
            message.style.display = 'block';
            message.innerHTML = 'Masukkan ID Member.';
            message.className = 'text-xs mt-1 mb-3 text-gray-500';
        } else {
            memberCodeInput.style.display = 'none';
            memberCodeInput.value = '';
            
            nameInput.readOnly = false;
            phoneInput.readOnly = false;
            nameInput.classList.remove('bg-gray-100');
            phoneInput.classList.remove('bg-gray-100');
            
            nameInput.value = '';
            phoneInput.value = '';
            
            message.style.display = 'none';
            message.innerHTML = '';
            
            updateSummary();
        }
    }

    function checkMemberCode() {
        const customerType = document.getElementById('customer_type').value;
        if (customerType !== 'member') return;

        const memberCode = document.getElementById('member_code').value.trim();
        const nameInput = document.getElementById('customer_name');
        const phoneInput = document.getElementById('customer_phone');
        const message = document.getElementById('member_message');

        if (memberCode.length < 3) {
            nameInput.value = '';
            phoneInput.value = '';
            message.innerHTML = 'Masukkan ID Member.';
            message.className = 'text-xs mt-1 mb-3 text-gray-500';
            updateSummary();
            return;
        }

        fetch(`/orders/check-member/${encodeURIComponent(memberCode)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    nameInput.value = data.customer.name;
                    phoneInput.value = data.customer.phone ?? '';
                    message.innerHTML = 'Member ditemukan. Diskon 5%.';
                    message.className = 'text-xs mt-1 mb-3 text-green-600';
                } else {
                    nameInput.value = '';
                    phoneInput.value = '';
                    message.innerHTML = 'Member tidak ditemukan.';
                    message.className = 'text-xs mt-1 mb-3 text-red-600';
                }
                updateSummary();
            })
            .catch(() => {
                nameInput.value = '';
                phoneInput.value = '';
                message.innerHTML = 'Member tidak ditemukan.';
                message.className = 'text-xs mt-1 mb-3 text-red-600';
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
@endpush
@endsection
