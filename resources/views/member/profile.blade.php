<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Profile Member - Servana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">

    @include('partials.public-navbar')

    <main class="py-10">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        Profile Member
                    </h1>
                    <p class="text-gray-600 mt-1">
                        Kelola data membership dan lihat riwayat transaksi Anda.
                    </p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-semibold">
                        Logout
                    </button>
                </form>
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

            {{-- Data Membership --}}
            <div class="bg-white p-6 shadow-sm rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    Data Membership
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Nama</p>
                        <p class="font-semibold">{{ $customer->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Kode Membership</p>
                        <p class="font-semibold text-blue-600 text-xl">
                            {{ $customer->member_code }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-semibold">{{ $customer->email }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Nomor HP</p>
                        <p class="font-semibold">{{ $customer->phone }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Status Member</p>
                        <p class="font-semibold">
                            {{ $customer->is_member ? 'Member Aktif' : 'Bukan Member' }}
                        </p>
                    </div>
                </div>

                <hr class="my-6">

                <h4 class="font-semibold mb-4">
                    Edit Email dan Nomor HP
                </h4>

                <form action="{{ route('member.profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 font-medium">
                                Email
                            </label>

                            <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div>
                            <label class="block mb-2 font-medium">
                                Nomor HP
                            </label>

                            <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
            {{-- Riwayat Reservasi --}}
            <div class="bg-white p-6 shadow-sm rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    Riwayat Reservasi
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="p-3 border">No</th>
                                <th class="p-3 border">Kode Reservasi</th>
                                <th class="p-3 border">Tanggal</th>
                                <th class="p-3 border">Jam</th>
                                <th class="p-3 border">Jumlah Tamu</th>
                                <th class="p-3 border">Meja</th>
                                <th class="p-3 border">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($reservations as $index => $reservation)
                                <tr>
                                    <td class="p-3 border">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="p-3 border font-semibold text-blue-600">
                                        {{ $reservation->reservation_code }}
                                    </td>

                                    <td class="p-3 border">
                                        {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d-m-Y') }}
                                    </td>

                                    <td class="p-3 border">
                                        {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}
                                    </td>

                                    <td class="p-3 border">
                                        {{ $reservation->total_guest }} Orang
                                    </td>

                                    <td class="p-3 border">
                                        @if ($reservation->table)
                                            Meja {{ $reservation->table->table_number }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="p-3 border">
                                        @php
                                            $statusLabels = [
                                                'pending' => 'Menunggu',
                                                'confirmed' => 'Dikonfirmasi',
                                                'completed' => 'Selesai',
                                                'no_show' => 'Tidak Datang',
                                            ];
                                        @endphp

                                        {{ $statusLabels[$reservation->status] ?? $reservation->status }} </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-3 border text-center text-gray-500">
                                        Belum ada riwayat reservasi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Riwayat Transaksi --}}
            <div class="bg-white p-6 shadow-sm rounded-lg">
                <h3 class="text-lg font-semibold mb-4">
                    Riwayat Transaksi
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="p-3 border">No</th>
                                <th class="p-3 border">Kode Order</th>
                                <th class="p-3 border">Tanggal</th>
                                <th class="p-3 border">Total</th>
                                <th class="p-3 border">Metode Bayar</th>
                                <th class="p-3 border">Status</th>
                                <th class="p-3 border">Invoice</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($orders as $index => $order)
                                <tr>
                                    <td class="p-3 border">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="p-3 border">
                                        {{ $order->order_code }}
                                    </td>

                                    <td class="p-3 border">
                                        {{ $order->created_at->format('d-m-Y H:i') }}
                                    </td>

                                    <td class="p-3 border">
                                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>

                                    <td class="p-3 border">
                                        {{ strtoupper($order->payment_method) }}
                                    </td>

                                    <td class="p-3 border">
                                        {{ ucfirst($order->payment_status) }}
                                    </td>

                                    <td class="p-3 border">
                                        <a href="{{ route('member.invoice', $order) }}"
                                            class="text-blue-600 hover:underline">
                                            Lihat Invoice
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-3 border text-center text-gray-500">
                                        Belum ada riwayat transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</body>

</html>
