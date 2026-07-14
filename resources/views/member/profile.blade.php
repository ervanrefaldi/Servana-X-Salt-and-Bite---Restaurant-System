<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Member Profile - Servana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.favicon')
</head>

<body class="bg-gray-50 text-gray-900 font-sans antialiased selection:bg-[#991B1B] selection:text-white">

    @include('partials.public-navbar')

    <main class="py-12">
        <div class="max-w-7xl mx-auto px-6">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-4">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">
                        Your <span class="text-[#991B1B]">Profile</span>
                    </h1>
                    <p class="text-gray-500 mt-2 text-lg">
                        Manage your account details and view your activity history.
                    </p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-red-50 hover:text-red-700 hover:border-red-200 transition-all shadow-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Log Out
                    </button>
                </form>
            </div>

            @if (session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl shadow-sm text-sm font-medium flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-8 p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl shadow-sm text-sm">
                    <ul class="list-disc ml-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Kiri: Profil & Edit --}}
                <div class="lg:col-span-1 space-y-8">
                    
                    {{-- Membership Card --}}
                    <div class="bg-gradient-to-br from-[#991B1B] to-[#5a1010] rounded-2xl shadow-xl overflow-hidden relative text-white">
                        <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/3"></div>
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-black/20 rounded-full blur-xl translate-y-1/3 -translate-x-1/4"></div>
                        
                        <div class="relative z-10 p-8">
                            <div class="flex justify-between items-start mb-8">
                                <div>
                                    <h3 class="text-white/80 text-sm font-semibold tracking-widest uppercase">Servana</h3>
                                    <p class="font-bold text-lg mt-1">{{ $customer->is_member ? 'Elite Member' : 'Customer' }}</p>
                                </div>
                                <div class="w-12 h-12 bg-white/20 rounded-full backdrop-blur-sm flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                            </div>

                            <div class="mb-8">
                                <p class="text-white/60 text-xs uppercase tracking-widest mb-2">Member ID</p>
                                <p class="text-2xl font-mono tracking-widest font-bold">{{ $customer->member_code }}</p>
                            </div>
                            
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-white/60 text-xs uppercase tracking-widest mb-1">Card Holder</p>
                                    <p class="font-semibold tracking-wide uppercase">{{ $customer->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-white/60 text-xs uppercase tracking-widest mb-1">Status</p>
                                    <p class="font-bold {{ $customer->is_member ? 'text-green-400' : 'text-yellow-400' }}">
                                        {{ $customer->is_member ? 'ACTIVE' : 'INACTIVE' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Edit Data --}}
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-[#FDEAE8] text-[#991B1B] flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Contact Details</h3>
                        </div>

                        <form action="{{ route('member.profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="space-y-5">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-gray-700">Email Address</label>
                                    <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                                        class="w-full border-gray-200 rounded-xl shadow-sm focus:border-[#991B1B] focus:ring focus:ring-[#991B1B] focus:ring-opacity-20 transition-all" required>
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-gray-700">Phone Number</label>
                                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                                        class="w-full border-gray-200 rounded-xl shadow-sm focus:border-[#991B1B] focus:ring focus:ring-[#991B1B] focus:ring-opacity-20 transition-all" required>
                                </div>
                            </div>

                            <button type="submit" class="mt-8 w-full px-4 py-3 bg-[#991B1B] text-white font-bold rounded-xl hover:bg-[#8B121A] transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Kanan: Riwayat Aktivitas --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- Riwayat Reservasi --}}
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Recent Reservations</h3>
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-gray-100">
                            <table class="w-full text-left border-collapse whitespace-nowrap">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                        <th class="p-4 font-semibold">Res. Code</th>
                                        <th class="p-4 font-semibold">Date & Time</th>
                                        <th class="p-4 font-semibold">Guests & Table</th>
                                        <th class="p-4 font-semibold">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse ($reservations as $reservation)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="p-4 font-mono font-medium text-blue-600">
                                                {{ $reservation->reservation_code }}
                                            </td>
                                            <td class="p-4 text-gray-700">
                                                <div class="font-medium">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }}</div>
                                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}</div>
                                            </td>
                                            <td class="p-4 text-gray-700">
                                                {{ $reservation->total_guest }} Pax
                                                @if ($reservation->table)
                                                    <span class="text-gray-400 mx-1">•</span> Tbl {{ $reservation->table->table_number }}
                                                @endif
                                            </td>
                                            <td class="p-4">
                                                @php
                                                    $statusStyles = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                        'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                        'completed' => 'bg-green-100 text-green-800 border-green-200',
                                                        'no_show' => 'bg-red-100 text-red-800 border-red-200',
                                                    ];
                                                    $statusLabels = [
                                                        'pending' => 'Pending',
                                                        'confirmed' => 'Confirmed',
                                                        'completed' => 'Completed',
                                                        'no_show' => 'No Show',
                                                    ];
                                                @endphp
                                                <span class="px-2.5 py-1 text-xs font-bold rounded-full border {{ $statusStyles[$reservation->status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                                                    {{ $statusLabels[$reservation->status] ?? ucfirst($reservation->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-8 text-center text-gray-500">
                                                No reservations found. <a href="{{ route('reservations.create') }}" class="text-[#991B1B] hover:underline">Book a table now.</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Riwayat Transaksi --}}
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Order History</h3>
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-gray-100">
                            <table class="w-full text-left border-collapse whitespace-nowrap">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                        <th class="p-4 font-semibold">Order ID</th>
                                        <th class="p-4 font-semibold">Date</th>
                                        <th class="p-4 font-semibold">Amount</th>
                                        <th class="p-4 font-semibold">Status</th>
                                        <th class="p-4 font-semibold text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse ($orders as $order)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="p-4 font-mono font-medium text-gray-900">
                                                {{ $order->order_code }}
                                            </td>
                                            <td class="p-4 text-gray-700 text-sm">
                                                {{ $order->created_at->format('d M Y, H:i') }}
                                            </td>
                                            <td class="p-4 font-bold text-gray-900">
                                                Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                            </td>
                                            <td class="p-4">
                                                @php
                                                    $payStyles = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                        'paid' => 'bg-green-100 text-green-800 border-green-200',
                                                        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                                    ];
                                                @endphp
                                                <span class="px-2.5 py-1 text-xs font-bold rounded-full border {{ $payStyles[$order->payment_status] ?? 'bg-gray-100' }}">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-right">
                                                <a href="{{ route('member.invoice', $order) }}"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-200 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-50 hover:text-[#991B1B] hover:border-[#991B1B] transition-all">
                                                    Invoice
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="p-8 text-center text-gray-500">
                                                No orders found.
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
    </main>

</body>
</html>
