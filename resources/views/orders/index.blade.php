@extends('layouts.pos')

@section('title', 'Kelola Transaksi - Servana POS')

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    <!-- Page Header -->
    <div class="px-8 pt-8 pb-6 flex justify-between items-end border-b border-gray-100 shrink-0">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Order History</h2>
            <p class="text-gray-500 text-sm">Review past transactions and order details.</p>
        </div>
        <a href="{{ route('orders.create') }}" class="px-4 py-2 bg-brand-red text-white rounded-lg text-sm font-medium shadow-sm hover:bg-[#8B121A] transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            New Order
        </a>
    </div>

    <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif



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
    </div>
</div>
@endsection