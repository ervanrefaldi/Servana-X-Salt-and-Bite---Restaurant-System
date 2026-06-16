<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kelola Transaksi
            </h2>

            <a href="{{ route('kasir.dashboard') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #2563eb; color: #ffffff;">
                Kembali ke Dashboard Kasir
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex justify-end">
                <a href="{{ route('orders.create') }}"
                   class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                   style="background-color: #16a34a; color: #ffffff;">
                    Tambah Transaksi
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-4 border">No</th>
                            <th class="p-4 border">Kode Order</th>
                            <th class="p-4 border">Customer</th>
                            <th class="p-4 border">Member</th>
                            <th class="p-4 border">Total</th>
                            <th class="p-4 border">Metode Bayar</th>
                            <th class="p-4 border">Status</th>
                            <th class="p-4 border">Tanggal</th>
                            <th class="p-4 border">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($orders as $index => $order)
                            <tr>
                                <td class="p-4 border">
                                    {{ $index + 1 }}
                                </td>

                                <td class="p-4 border">
                                    {{ $order->order_code }}
                                </td>

                                <td class="p-4 border">
                                    <div class="font-semibold">
                                        {{ $order->customer_name }}
                                    </div>

                                    <div class="text-sm text-gray-500">
                                        {{ $order->customer_phone ?? '-' }}
                                    </div>
                                </td>

                                <td class="p-4 border">
                                    @if ($order->is_member)
                                        <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">
                                            Member
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">
                                            Non-Member
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>

                                <td class="p-4 border">
                                    {{ strtoupper($order->payment_method) }}
                                </td>

                                <td class="p-4 border">
                                    @if ($order->payment_status === 'paid')
                                        <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">
                                            Lunas
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-700">
                                            Belum Lunas
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    {{ $order->created_at->format('d-m-Y H:i') }}
                                </td>

                                <td class="p-4 border">
                                    <a href="{{ route('orders.show', $order) }}"
                                       class="text-blue-600 hover:underline">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="p-4 border text-center text-gray-500">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>