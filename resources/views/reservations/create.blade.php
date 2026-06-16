<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reservasi - Servana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">

    @include('partials.public-navbar')

    <main class="py-10">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-6 text-center">
                <h1 class="text-3xl font-bold text-gray-800">
                    Reservasi Meja
                </h1>
                <p class="text-gray-600 mt-2">
                    Reservasi hanya dapat dilakukan minimal H-1 sebelum tanggal kedatangan.
                    Jam reservasi tersedia dari 09.00 sampai 19.00 dengan durasi 60 menit.
                </p>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($activeReservation)
                {{-- Tampilan jika masih punya reservasi aktif --}}
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">
                        Anda Memiliki Reservasi Aktif
                    </h2>

                    <p class="text-gray-600 mb-6">
                        Anda belum dapat membuat reservasi baru sampai reservasi ini selesai,
                        dibatalkan, atau tanggal reservasi sudah terlewat.
                    </p>

                    <div class="p-5 bg-blue-50 text-blue-700 rounded-lg mb-6">
                        <p class="font-semibold">
                            Kode Reservasi Anda:
                        </p>

                        <p class="text-3xl font-bold mt-2">
                            {{ $activeReservation->reservation_code }}
                        </p>
                        @if ($activeReservation->reservation_type === 'non_member')
                            <p class="text-sm mt-3 text-blue-700">
                                Harap screenshot halaman ini sebagai bukti kode reservasi Anda.
                                Kode ini digunakan saat konfirmasi reservasi di restoran.
                            </p>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left max-w-3xl mx-auto">
                        <div class="p-4 border rounded-lg">
                            <p class="text-sm text-gray-500">Nama Customer</p>
                            <p class="font-semibold">{{ $activeReservation->customer_name }}</p>
                        </div>

                        <div class="p-4 border rounded-lg">
                            <p class="text-sm text-gray-500">Nomor HP</p>
                            <p class="font-semibold">{{ $activeReservation->customer_phone }}</p>
                        </div>

                        <div class="p-4 border rounded-lg">
                            <p class="text-sm text-gray-500">Tanggal Reservasi</p>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($activeReservation->reservation_date)->format('d-m-Y') }}
                            </p>
                        </div>

                        <div class="p-4 border rounded-lg">
                            <p class="text-sm text-gray-500">Jam Reservasi</p>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($activeReservation->start_time)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($activeReservation->end_time)->format('H:i') }}
                            </p>
                        </div>

                        <div class="p-4 border rounded-lg">
                            <p class="text-sm text-gray-500">Jumlah Tamu</p>
                            <p class="font-semibold">
                                {{ $activeReservation->total_guest }} Orang
                            </p>
                        </div>

                        <div class="p-4 border rounded-lg">
                            <p class="text-sm text-gray-500">Meja</p>
                            <p class="font-semibold">
                                @if ($activeReservation->table)
                                    Meja {{ $activeReservation->table->table_number }}
                                    - {{ ucfirst($activeReservation->table->area) }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>

                        <div class="p-4 border rounded-lg">
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="font-semibold">
                                @php
                                    $statusLabels = [
                                        'pending' => 'Menunggu',
                                        'confirmed' => 'Dikonfirmasi',
                                        'seated' => 'Sudah Duduk',
                                        'completed' => 'Selesai',
                                        'no_show' => 'Tidak Datang',
                                    ];
                                @endphp

                                {{ $statusLabels[$activeReservation->status] ?? $activeReservation->status }}
                            </p>
                        </div>

                        <div class="p-4 border rounded-lg">
                            <p class="text-sm text-gray-500">Tipe Reservasi</p>
                            <p class="font-semibold">
                                {{ $activeReservation->reservation_type === 'member' ? 'Member' : 'Customer Biasa' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-center gap-3">
                        <a href="{{ url('/') }}"
                            class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                            Kembali ke Home
                        </a>

                        @auth
                            @if (auth()->user()->role === 'member')
                                <a href="{{ route('member.profile') }}"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Lihat Profile
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            @else
                {{-- Form Reservasi --}}
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <form action="{{ route('reservations.store') }}" method="POST">
                        @csrf

                        {{-- Nama Customer --}}
                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Nama Customer
                            </label>

                            <input type="text" name="customer_name"
                                value="{{ old('customer_name', $isMember && $customer ? $customer->name : '') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm {{ $isMember ? 'bg-gray-100' : '' }}"
                                {{ $isMember ? 'readonly' : '' }} required>

                            @if ($isMember)
                                <p class="text-sm text-gray-500 mt-1">
                                    Nama mengikuti data membership. Ubah melalui halaman Profile.
                                </p>
                            @endif
                        </div>

                        {{-- Nomor HP --}}
                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Nomor HP
                            </label>

                            <input type="text" name="customer_phone"
                                value="{{ old('customer_phone', $isMember && $customer ? $customer->phone : '') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm {{ $isMember ? 'bg-gray-100' : '' }}"
                                {{ $isMember ? 'readonly' : '' }} required>

                            @if ($isMember)
                                <p class="text-sm text-gray-500 mt-1">
                                    Nomor HP mengikuti data membership. Ubah melalui halaman Profile.
                                </p>
                            @endif
                        </div>

                        {{-- Tanggal Reservasi --}}
                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Tanggal Reservasi
                            </label>

                            <input type="date" name="reservation_date" value="{{ old('reservation_date') }}"
                                min="{{ now()->addDay()->toDateString() }}"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        {{-- Jam Reservasi --}}
                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Jam Reservasi
                            </label>

                            <select name="start_time" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                @for ($hour = 9; $hour <= 19; $hour++)
                                    @php
                                        $time = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
                                    @endphp

                                    <option value="{{ $time }}"
                                        {{ old('start_time') == $time ? 'selected' : '' }}>
                                        {{ $time }}
                                    </option>
                                @endfor
                            </select>

                            <p class="text-sm text-gray-500 mt-1">
                                Setiap reservasi berdurasi 60 menit.
                            </p>
                        </div>

                        {{-- Jumlah Tamu --}}
                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Jumlah Tamu
                            </label>

                            <select name="guest_count" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}"
                                        {{ old('guest_count') == $i ? 'selected' : '' }}>
                                        {{ $i }} Orang
                                    </option>
                                @endfor
                            </select>
                        </div>

                        {{-- Pilih Meja khusus Member --}}
                        @if ($isMember)
                            <div class="mb-4">
                                <label class="block mb-2 font-medium">
                                    Pilih Meja
                                </label>

                                <select name="table_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Meja --</option>

                                    @forelse ($tables as $table)
                                        <option value="{{ $table->id }}"
                                            {{ old('table_id') == $table->id ? 'selected' : '' }}>
                                            Meja {{ $table->table_number }}
                                            - {{ ucfirst($table->area) }}
                                            - Kapasitas {{ $table->capacity }} orang
                                        </option>
                                    @empty
                                        <option value="" disabled>
                                            Tidak ada meja tersedia
                                        </option>
                                    @endforelse
                                </select>

                                <p class="text-sm text-gray-500 mt-1">
                                    Member dapat memilih meja sendiri. Pastikan kapasitas meja sesuai jumlah tamu.
                                </p>
                            </div>
                        @else
                            <div class="mb-4 p-4 bg-blue-50 text-blue-700 rounded">
                                Customer biasa tidak memilih meja. Sistem akan memilih meja otomatis berdasarkan jumlah
                                tamu.
                            </div>
                        @endif

                        {{-- Catatan --}}
                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Catatan
                            </label>

                            <textarea name="note" rows="4" class="w-full border-gray-300 rounded-md shadow-sm"
                                placeholder="Contoh: ingin dekat jendela">{{ old('note') }}</textarea>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="px-5 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">
                                Buat Reservasi
                            </button>
                        </div>
                    </form>
                </div>
            @endif

        </div>
    </main>

</body>

</html>
