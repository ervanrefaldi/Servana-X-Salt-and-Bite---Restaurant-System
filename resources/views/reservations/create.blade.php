<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Book a Table - Servana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 font-sans antialiased selection:bg-[#991B1B] selection:text-white">

    @include('partials.public-navbar')

    <main class="py-12">
        <div class="max-w-4xl mx-auto px-6">

            <div class="text-center mb-10">
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">
                    Book a <span class="text-[#991B1B]">Table</span>
                </h1>
                <p class="text-gray-500 mt-3 text-lg max-w-2xl mx-auto">
                    Reservations are available from 09:00 to 19:00 with a duration of 60 minutes. Please book at least one day in advance.
                </p>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl shadow-sm text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl shadow-sm text-sm">
                    <ul class="list-disc ml-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($activeReservation)
                {{-- Tampilan jika masih punya reservasi aktif --}}
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-lg border border-gray-100 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-[#991B1B]"></div>
                    
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 mb-3">
                        Active Reservation Found
                    </h2>

                    <p class="text-gray-500 mb-8 max-w-lg mx-auto">
                        You currently have an active reservation. You cannot create a new one until this is completed, cancelled, or the date has passed.
                    </p>

                    <div class="p-8 bg-[#FDEAE8] text-[#991B1B] rounded-2xl mb-8 border border-[#f5d0cb] inline-block w-full max-w-sm">
                        <p class="font-semibold text-sm uppercase tracking-widest opacity-80">
                            Reservation Code
                        </p>
                        <p class="text-4xl font-black mt-2 font-mono tracking-wider">
                            {{ $activeReservation->reservation_code }}
                        </p>
                        @if ($activeReservation->reservation_type === 'non_member')
                            <p class="text-xs mt-4 opacity-80 leading-relaxed font-medium">
                                Please take a screenshot of this page. Show this code to the receptionist upon arrival.
                            </p>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-left mb-8">
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Name</p>
                            <p class="font-bold text-gray-900">{{ $activeReservation->customer_name }}</p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Phone</p>
                            <p class="font-bold text-gray-900">{{ $activeReservation->customer_phone }}</p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Date</p>
                            <p class="font-bold text-gray-900">
                                {{ \Carbon\Carbon::parse($activeReservation->reservation_date)->format('d M Y') }}
                            </p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Time</p>
                            <p class="font-bold text-gray-900">
                                {{ \Carbon\Carbon::parse($activeReservation->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($activeReservation->end_time)->format('H:i') }}
                            </p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Guests & Table</p>
                            <p class="font-bold text-gray-900">
                                {{ $activeReservation->total_guest }} Pax
                                @if ($activeReservation->table)
                                    • Tbl {{ $activeReservation->table->table_number }}
                                @endif
                            </p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Status</p>
                            @php
                                $statusLabels = [
                                    'pending' => 'Pending',
                                    'confirmed' => 'Confirmed',
                                    'completed' => 'Completed',
                                    'no_show' => 'No Show',
                                ];
                                $statusColors = [
                                    'pending' => 'text-yellow-600',
                                    'confirmed' => 'text-blue-600',
                                    'completed' => 'text-green-600',
                                    'no_show' => 'text-red-600',
                                ];
                            @endphp
                            <p class="font-bold {{ $statusColors[$activeReservation->status] ?? 'text-gray-900' }}">
                                {{ $statusLabels[$activeReservation->status] ?? $activeReservation->status }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ url('/') }}"
                            class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                            Return Home
                        </a>

                        @auth
                            @if (auth()->user()->role === 'member')
                                <a href="{{ route('member.profile') }}"
                                    class="px-6 py-2.5 bg-[#991B1B] text-white font-semibold rounded-xl hover:bg-[#8B121A] transition-colors shadow-sm">
                                    View Profile
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            @else
                {{-- Form Reservasi --}}
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-lg border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-[#991B1B]"></div>
                    
                    <form action="{{ route('reservations.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            {{-- Nama Customer --}}
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">
                                    Full Name
                                </label>
                                <input type="text" name="customer_name"
                                    value="{{ old('customer_name', $isMember && $customer ? $customer->name : '') }}"
                                    class="w-full border-gray-200 rounded-xl shadow-sm focus:border-[#991B1B] focus:ring focus:ring-[#991B1B] focus:ring-opacity-20 transition-all {{ $isMember ? 'bg-gray-50 text-gray-500' : '' }}"
                                    {{ $isMember ? 'readonly' : '' }} required placeholder="Enter your full name">
                                @if ($isMember)
                                    <p class="text-xs text-gray-500 mt-2">Linked to member profile.</p>
                                @endif
                            </div>

                            {{-- Nomor HP --}}
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">
                                    Phone Number
                                </label>
                                <input type="text" name="customer_phone"
                                    value="{{ old('customer_phone', $isMember && $customer ? $customer->phone : '') }}"
                                    class="w-full border-gray-200 rounded-xl shadow-sm focus:border-[#991B1B] focus:ring focus:ring-[#991B1B] focus:ring-opacity-20 transition-all {{ $isMember ? 'bg-gray-50 text-gray-500' : '' }}"
                                    {{ $isMember ? 'readonly' : '' }} required placeholder="e.g. 081234567890">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            {{-- Tanggal Reservasi --}}
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">
                                    Reservation Date
                                </label>
                                <input type="date" name="reservation_date" id="reservation_date" value="{{ old('reservation_date') }}"
                                    min="{{ now()->addDay()->toDateString() }}"
                                    class="w-full border-gray-200 rounded-xl shadow-sm focus:border-[#991B1B] focus:ring focus:ring-[#991B1B] focus:ring-opacity-20 transition-all" required>
                            </div>

                            {{-- Jam Reservasi --}}
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">
                                    Reservation Time (1 Hour)
                                </label>
                                <select name="start_time" id="start_time" class="w-full border-gray-200 rounded-xl shadow-sm focus:border-[#991B1B] focus:ring focus:ring-[#991B1B] focus:ring-opacity-20 transition-all" required>
                                    @for ($hour = 9; $hour <= 19; $hour++)
                                        @php
                                            $time = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
                                        @endphp
                                        <option value="{{ $time }}" {{ old('start_time') == $time ? 'selected' : '' }}>
                                            {{ $time }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            {{-- Jumlah Tamu --}}
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">
                                    Number of Guests
                                </label>
                                <select name="guest_count" id="guest_count" class="w-full border-gray-200 rounded-xl shadow-sm focus:border-[#991B1B] focus:ring focus:ring-[#991B1B] focus:ring-opacity-20 transition-all" required>
                                    @for ($i = 1; $i <= 20; $i++)
                                        <option value="{{ $i }}" {{ old('guest_count') == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ $i == 1 ? 'Person' : 'People' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            {{-- Pilih Meja khusus Member --}}
                            @if ($isMember)
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                                        Select Table (Member Perk)
                                    </label>
                                    <select name="table_id" id="table_id" class="w-full border-gray-200 rounded-xl shadow-sm focus:border-[#991B1B] focus:ring focus:ring-[#991B1B] focus:ring-opacity-20 transition-all bg-yellow-50" required>
                                        <option value="">-- Select Date & Time First --</option>
                                    </select>
                                    <p class="text-xs text-yellow-600 mt-2 font-medium">As a member, you can choose your exact table.</p>
                                </div>
                            @else
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                                        Table Assignment
                                    </label>
                                    <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-500 text-sm">
                                        Auto-assigned based on availability.
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2"><a href="{{ route('member.register') }}" class="text-[#991B1B] hover:underline font-semibold">Become a member</a> to choose your table.</p>
                                </div>
                            @endif
                        </div>

                        {{-- Catatan --}}
                        <div class="mb-8">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">
                                Special Requests / Notes
                            </label>
                            <textarea name="note" rows="3" class="w-full border-gray-200 rounded-xl shadow-sm focus:border-[#991B1B] focus:ring focus:ring-[#991B1B] focus:ring-opacity-20 transition-all resize-none"
                                placeholder="E.g. Window seat preferred, celebrating a birthday...">{{ old('note') }}</textarea>
                        </div>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                            <p class="text-sm text-gray-500 hidden sm:block">Please verify your details before submitting.</p>
                            <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-[#991B1B] text-white rounded-xl hover:bg-[#8B121A] font-bold shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                Confirm Reservation
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            @endif

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const guestCountSelect = document.getElementById('guest_count');
            const tableIdSelect = document.getElementById('table_id');
            const dateInput = document.getElementById('reservation_date');
            const startTimeSelect = document.getElementById('start_time');
            
            if (guestCountSelect && tableIdSelect && dateInput && startTimeSelect) {
                const allTables = @json($tables ?? []);
                const allReservations = @json($reservations ?? []);
                const oldTableId = "{{ old('table_id') }}";
                
                function updateTableOptions() {
                    const guestCount = parseInt(guestCountSelect.value) || 1;
                    const date = dateInput.value;
                    const startTime = startTimeSelect.value;
                    
                    tableIdSelect.innerHTML = '<option value="">-- Select Table --</option>';
                    
                    if (!date || !startTime) {
                        const option = document.createElement('option');
                        option.value = "";
                        option.disabled = true;
                        option.textContent = "Please select Date and Time first";
                        tableIdSelect.appendChild(option);
                        return;
                    }
                    
                    // Hitung end time berdasarkan start time (+1 jam)
                    const startHour = parseInt(startTime.split(':')[0]);
                    const endTime = (startHour + 1).toString().padStart(2, '0') + ':00';
                    const formattedStartTime = startTime + ':00';
                    const formattedEndTime = endTime + ':00';
                    
                    // Cari meja yang bentrok
                    const conflictingTableIds = allReservations.filter(r => {
                        if (!r.reservation_date || !r.start_time || !r.end_time) return false;
                        const rDate = r.reservation_date.split('T')[0];
                        const rStartTime = r.start_time.length === 5 ? r.start_time + ':00' : r.start_time;
                        const rEndTime = r.end_time.length === 5 ? r.end_time + ':00' : r.end_time;
                        
                        return rDate === date && rStartTime < formattedEndTime && rEndTime > formattedStartTime;
                    }).map(r => r.table_id);
                    
                    // Meja yang secara global available dan tidak bentrok waktu
                    const availableTables = allTables.filter(t => !conflictingTableIds.includes(t.id));
                    
                    // Find tables with capacity >= guest_count
                    const validTables = availableTables.filter(t => t.capacity >= guestCount);
                    
                    if (validTables.length > 0) {
                        // Find the smallest capacity among valid tables
                        const minCapacity = Math.min(...validTables.map(t => t.capacity));
                        
                        // Filter tables to only show those with minCapacity
                        const bestFitTables = validTables.filter(t => t.capacity === minCapacity);
                        
                        bestFitTables.forEach(table => {
                            const option = document.createElement('option');
                            option.value = table.id;
                            option.textContent = `Table ${table.table_number} - ${table.area.charAt(0).toUpperCase() + table.area.slice(1)} (Cap: ${table.capacity})`;
                            
                            if (oldTableId && oldTableId == table.id) {
                                option.selected = true;
                            }
                            
                            tableIdSelect.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.value = "";
                        option.disabled = true;
                        option.textContent = "No tables available for this time/capacity";
                        tableIdSelect.appendChild(option);
                    }
                }
                
                guestCountSelect.addEventListener('change', updateTableOptions);
                dateInput.addEventListener('change', updateTableOptions);
                startTimeSelect.addEventListener('change', updateTableOptions);
                
                // Initial call
                updateTableOptions();
            }
        });
    </script>
</body>
</html>
