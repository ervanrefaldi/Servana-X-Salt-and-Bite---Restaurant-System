<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Invoice Transaksi
            </h2>

            <a href="{{ route('kasir.dashboard') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #2563eb; color: #ffffff;">
                Kembali ke Dashboard Kasir
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="border-b pb-4 mb-6">
                    <h1 class="text-2xl font-bold">
                        Servana
                    </h1>

                    <p class="text-gray-500">
                        Invoice Transaksi Restoran
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500">
                            Kode Transaksi
                        </p>

                        <p class="font-semibold">
                            {{ $order->order_code }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Tanggal
                        </p>

                        <p class="font-semibold">
                            {{ $order->created_at->format('d-m-Y H:i') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Atas Nama
                        </p>

                        <p class="font-semibold">
                            {{ $order->customer_name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Nomor HP
                        </p>

                        <p class="font-semibold">
                            {{ $order->customer_phone ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Kasir
                        </p>

                        <p class="font-semibold">
                            {{ $order->cashier->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Status Customer
                        </p>

                        <p class="font-semibold">
                            {{ $order->is_member ? 'Member' : 'Non-Member' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Metode Pembayaran
                        </p>

                        <p class="font-semibold">
                            {{ strtoupper($order->payment_method) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Status Pembayaran
                        </p>

                        <p class="font-semibold">
                            {{ $order->payment_status === 'paid' ? 'Lunas' : 'Belum Lunas' }}
                        </p>
                    </div>
                </div>

                <table class="w-full border-collapse mb-6">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">Menu</th>
                            <th class="p-3 border">Qty</th>
                            <th class="p-3 border">Harga</th>
                            <th class="p-3 border">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($order->details as $detail)
                            <tr>
                                <td class="p-3 border">
                                    {{ $detail->menu->name ?? '-' }}
                                </td>

                                <td class="p-3 border">
                                    {{ $detail->quantity }}
                                </td>

                                <td class="p-3 border">
                                    Rp{{ number_format($detail->price, 0, ',', '.') }}
                                </td>

                                <td class="p-3 border">
                                    Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="max-w-sm ml-auto">
                    <div class="flex justify-between border-b py-2">
                        <span>Subtotal</span>

                        <span>
                            Rp{{ number_format($order->subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between border-b py-2">
                        <span>Diskon Member {{ $order->discount_percent }}%</span>

                        <span>
                            Rp{{ number_format($order->discount_amount, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between py-2 font-bold text-lg">
                        <span>Total Bayar</span>

                        <span>
                            Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                @if ($order->is_member)
                    <div class="mt-6 p-4 bg-green-50 text-green-700 rounded">
                        Invoice ini tercatat sebagai transaksi member dan mendapatkan diskon 5%.
                    </div>
                @endif

                <div class="mt-6 flex flex-wrap gap-3">
                    <button onclick="window.print()"
                            class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                            style="background-color: #2563eb; color: #ffffff;">
                        Cetak Invoice
                    </button>

                    <a href="{{ route('orders.create') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #16a34a; color: #ffffff;">
                        Transaksi Baru
                    </a>

                    <a href="{{ route('orders.index') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #4b5563; color: #ffffff;">
                        Kembali ke Kelola Transaksi
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>