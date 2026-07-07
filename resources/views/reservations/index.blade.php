@extends('layouts.pos')

@section('title', 'Manajemen Reservasi - Servana POS')

@section('content')
<div class="flex-1 flex flex-col h-full">
    <!-- Page Header -->
    <div class="px-8 pt-8 pb-6 flex justify-between items-end border-b border-gray-100">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Manajemen Reservasi</h2>
            <p class="text-gray-500 text-sm">Lihat semua riwayat reservasi pelanggan Anda.</p>
        </div>
        <a href="{{ route('reservations.create') }}" class="px-4 py-2 bg-brand-red text-white rounded-lg text-sm font-medium shadow-sm hover:bg-[#8B121A] transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            New Reservation
        </a>
    </div>

    @php
        $statusLabels = [
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'no_show' => 'Tidak Datang',
        ];

        $typeLabels = [
            'member' => 'Member',
            'non_member' => 'Non-Member',
        ];
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-4 border">No</th>
                            <th class="p-4 border">Kode</th>
                            <th class="p-4 border">Customer</th>
                            <th class="p-4 border">Meja</th>
                            <th class="p-4 border">Tanggal</th>
                            <th class="p-4 border">Jam</th>
                            <th class="p-4 border">Tipe</th>
                            <th class="p-4 border">Status</th>
                            <th class="p-4 border">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($reservations as $index => $reservation)
                            <tr>
                                <td class="p-4 border">{{ $index + 1 }}</td>

                                <td class="p-4 border">
                                    {{ $reservation->reservation_code }}
                                </td>

                                <td class="p-4 border">
                                    <div class="font-semibold">
                                        {{ $reservation->customer_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $reservation->customer_phone }}
                                    </div>
                                </td>

                                <td class="p-4 border">
                                    @if ($reservation->table)
                                        {{ $reservation->table->table_number }}
                                        <span class="text-sm text-gray-500">
                                            ({{ ucfirst($reservation->table->area) }})
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d-m-Y') }}
                                </td>

                                <td class="p-4 border">
                                    {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}
                                </td>

                                <td class="p-4 border">
                                    {{ $typeLabels[$reservation->reservation_type] ?? $reservation->reservation_type }}
                                </td>

                                <td class="p-4 border">
                                    @php
                                        $dateOnly = \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d');
                                        $reservationDateTime = \Carbon\Carbon::parse($dateOnly . ' ' . $reservation->start_time);
                                        $isTimeArrived = now()->greaterThanOrEqualTo($reservationDateTime);
                                        $isNoShow = $reservation->status === 'no_show';
                                        $isCompleted = $reservation->status === 'completed';
                                        $isDisabled = !$isTimeArrived || $isNoShow || $isCompleted;
                                        $titleText = '';
                                        if ($isNoShow) {
                                            $titleText = 'Status tidak bisa diubah karena reservasi sudah ditandai Tidak Datang';
                                        } elseif ($isCompleted) {
                                            $titleText = 'Status tidak bisa diubah karena reservasi sudah ditandai Selesai';
                                        } elseif (!$isTimeArrived) {
                                            $titleText = 'Status hanya bisa diubah setelah jam reservasi tiba';
                                        }
                                    @endphp
                                    <form action="{{ route('reservations.updateStatus', $reservation) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <select name="status" onchange="this.form.submit()"
                                            class="border-gray-300 rounded-md shadow-sm"
                                            {{ $isDisabled ? 'disabled' : '' }}
                                            title="{{ $titleText }}">
                                            <option value="pending"
                                                {{ $reservation->status === 'pending' ? 'selected' : '' }}>
                                                Menunggu
                                            </option>

                                            <option value="confirmed"
                                                {{ $reservation->status === 'confirmed' ? 'selected' : '' }}>
                                                Dikonfirmasi
                                            </option>

                                            <option value="completed"
                                                {{ $reservation->status === 'completed' ? 'selected' : '' }}>
                                                Selesai
                                            </option>

                                            <option value="no_show"
                                                {{ $reservation->status === 'no_show' ? 'selected' : '' }}>
                                                Tidak Datang
                                            </option>
                                        </select>
                                    </form>
                                </td>

                                <td class="p-4 border">
                                    <a href="{{ route('reservations.show', $reservation) }}"
                                        class="text-blue-600 hover:underline">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="p-4 border text-center">
                                    Belum ada data reservasi.
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
