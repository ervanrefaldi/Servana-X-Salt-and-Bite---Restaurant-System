<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Reservasi
            </h2>

            <a href="{{ route('reservations.index') }}"
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

        $selectionLabels = [
            'manual' => 'Manual',
            'automatic' => 'Otomatis',
        ];

        $typeLabels = [
            'member' => 'Member',
            'non_member' => 'Non-Member',
        ];
    @endphp

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Kode Reservasi</p>
                    <p class="text-lg font-semibold">{{ $reservation->reservation_code }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Nama Customer</p>
                    <p class="text-lg font-semibold">{{ $reservation->customer_name }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Nomor HP</p>
                    <p class="text-lg font-semibold">{{ $reservation->customer_phone }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Tanggal Reservasi</p>
                    <p class="text-lg font-semibold">
                        {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d-m-Y') }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Jam Reservasi</p>
                    <p class="text-lg font-semibold">
                        {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Jumlah Tamu</p>
                    <p class="text-lg font-semibold">
                        {{ $reservation->total_guest }} Orang
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Meja</p>
                    <p class="text-lg font-semibold">
                        @if ($reservation->table)
                            {{ $reservation->table->table_number }}
                            -
                            {{ ucfirst($reservation->table->area) }}
                            -
                            Kapasitas {{ $reservation->table->capacity }} Orang
                        @else
                            -
                        @endif
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Tipe Reservasi</p>
                    <p class="text-lg font-semibold">
                        {{ $typeLabels[$reservation->reservation_type] ?? $reservation->reservation_type }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Pemilihan Meja</p>
                    <p class="text-lg font-semibold">
                        {{ $selectionLabels[$reservation->table_selection_type] ?? $reservation->table_selection_type }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Status</p>

                    <form action="{{ route('reservations.updateStatus', $reservation) }}"
                          method="POST"
                          class="mt-2">
                        @csrf
                        @method('PATCH')

                        <select name="status"
                                class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>
                                Menunggu
                            </option>
                            <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>
                                Dikonfirmasi
                            </option>
                            <option value="completed" {{ $reservation->status == 'completed' ? 'selected' : '' }}>
                                Selesai
                            </option>
                            <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>
                                Dibatalkan
                            </option>
                            <option value="no_show" {{ $reservation->status == 'no_show' ? 'selected' : '' }}>
                                Tidak Datang
                            </option>
                        </select>

                        <div class="mt-4">
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Catatan</p>
                    <p class="text-lg">
                        {{ $reservation->note ?? '-' }}
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>