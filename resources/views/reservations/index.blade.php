<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Reservasi
            </h2>

            <a href="{{ route('dashboard') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back
            </a>
        </div>
    </x-slot>

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
            <form method="GET" action="{{ route('reservations.index') }}" class="mb-6">
                <div class="flex gap-3">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        placeholder="Cari kode reservasi, nama customer, nomor HP, status..."
                        class="w-full border-gray-300 rounded-md shadow-sm">

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Cari
                    </button>

                    <a href="{{ route('reservations.index') }}"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                        Reset
                    </a>
                </div>
            </form>
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
</x-app-layout>
