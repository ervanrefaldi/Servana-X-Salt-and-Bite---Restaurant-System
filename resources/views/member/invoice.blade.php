<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Invoice Member
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-2xl font-bold">
                            Servana
                        </h3>
                        <p class="text-sm text-gray-500">
                            Restaurant Management System
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="font-semibold">
                            Invoice
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $order->order_code }}
                        </p>
                    </div>
                </div>

                <div class="mb-6">
                    <p><strong>Nama Customer:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Tanggal:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>
                    <p><strong>Metode Pembayaran:</strong> {{ strtoupper($order->payment_method) }}</p>
                    <p><strong>Status Pembayaran:</strong> {{ ucfirst($order->payment_status) }}</p>
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

                <div class="text-right space-y-1">
                    <p>
                        <strong>Subtotal:</strong>
                        Rp{{ number_format($order->subtotal, 0, ',', '.') }}
                    </p>

                    <p>
                        <strong>Diskon:</strong>
                        Rp{{ number_format($order->discount_amount, 0, ',', '.') }}
                    </p>

                    <p class="text-xl font-bold">
                        Total:
                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                    </p>
                </div>

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('member.profile') }}"
                       class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                        Kembali
                    </a>

                    <button onclick="window.print()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Cetak Invoice
                    </button>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>