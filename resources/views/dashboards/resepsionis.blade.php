@extends('layouts.pos')

@section('title', 'Dashboard Resepsionis - Servana POS')

@section('content')
@php
    $todayReservations = \App\Models\Reservation::with('table')
        ->whereDate('reservation_date', now()->toDateString())
        ->orderBy('start_time', 'asc')
        ->get();

    $pending = $todayReservations->where('status', 'pending');
    $confirmed = $todayReservations->where('status', 'confirmed');
    $completed = $todayReservations->where('status', 'completed');
@endphp

<!-- Page Header -->
<div class="px-8 pt-8 pb-6 flex justify-between items-end">
    <div>
        <h2 class="text-4xl font-bold text-gray-900 tracking-tight mb-2">Reservations Overview</h2>
        <p class="text-gray-500 text-sm">Manage today's floor flow and upcoming bookings.</p>
    </div>
    <div class="flex gap-3">
        <button class="px-4 py-2 border border-gray-200 bg-white text-gray-700 rounded-lg text-sm font-medium flex items-center gap-2 hover:bg-gray-50 shadow-sm">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            {{ now()->format('M d, Y') }}
        </button>
        <a href="{{ route('reservations.create') }}" class="px-4 py-2 bg-brand-red text-white rounded-lg text-sm font-medium shadow-sm hover:bg-[#8B121A] transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            New Reservation
        </a>
    </div>
</div>

@if(session('error'))
    <div class="mx-8 mb-4 p-3 bg-red-50 text-red-700 text-sm rounded-lg border border-red-100">
        {{ session('error') }}
    </div>
@endif
@if(session('success'))
    <div class="mx-8 mb-4 p-3 bg-green-50 text-green-700 text-sm rounded-lg border border-green-100">
        {{ session('success') }}
    </div>
@endif

<!-- Kanban Board -->
<div class="flex-1 overflow-x-auto px-8 pb-8">
    <div class="flex gap-6 h-full items-start min-w-max">

        <!-- Column: Pending -->
        <div class="w-[320px] bg-kanban rounded-xl p-4 flex flex-col max-h-full overflow-hidden border border-[#F5E6E3]">
            <div class="flex justify-between items-center mb-4 px-2">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                    <h3 class="font-bold text-gray-800">Pending</h3>
                </div>
                <span class="px-2 py-0.5 rounded-full bg-[#EFDFDB] text-brand-red text-xs font-bold">{{ $pending->count() }}</span>
            </div>
            
            <div class="flex-1 overflow-y-auto space-y-3 pr-2 custom-scrollbar">
                @forelse($pending as $res)
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $res->customer_name }}</h4>
                        </div>
                        <span class="text-xs font-semibold text-gray-500">{{ \Carbon\Carbon::parse($res->start_time)->format('g:i A') }}</span>
                    </div>
                    <div class="flex items-center gap-4 text-xs text-gray-500 font-medium mb-4">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            {{ $res->total_guest }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ substr($res->customer_phone, -4) }}
                        </span>
                    </div>
                    <form action="{{ route('reservations.updateStatus', $res) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="w-full py-2 bg-[#FDEAE8] text-brand-red rounded-lg text-xs font-semibold hover:bg-[#FADBD8] transition-colors">Confirm</button>
                    </form>
                </div>
                @empty
                <div class="text-sm text-gray-400 text-center py-4">Belum ada reservasi baru.</div>
                @endforelse
            </div>
        </div>

        <!-- Column: Confirmed -->
        <div class="w-[320px] bg-kanban rounded-xl p-4 flex flex-col max-h-full overflow-hidden border border-[#F5E6E3]">
            <div class="flex justify-between items-center mb-4 px-2">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-brand-red"></span>
                    <h3 class="font-bold text-gray-800">Confirmed</h3>
                </div>
                <span class="px-2 py-0.5 rounded-full bg-[#EFDFDB] text-brand-red text-xs font-bold">{{ $confirmed->count() }}</span>
            </div>
            
            <div class="flex-1 overflow-y-auto space-y-3 pr-2 custom-scrollbar">
                @forelse($confirmed as $res)
                @php
                    $isLate = now()->greaterThan(\Carbon\Carbon::parse($res->reservation_date . ' ' . $res->start_time)->addMinutes(15));
                @endphp
                <div class="bg-white p-4 rounded-xl shadow-sm border border-l-4 border-l-brand-red border-y-gray-100 border-r-gray-100 relative">
                    @if($isLate)
                    <div class="absolute top-0 right-4 -translate-y-1/2 bg-brand-red text-white text-[9px] font-bold px-1.5 py-0.5 rounded uppercase tracking-wider">Late</div>
                    @endif
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $res->customer_name }}</h4>
                        </div>
                        <span class="text-xs font-semibold {{ $isLate ? 'text-brand-red' : 'text-gray-500' }}">{{ \Carbon\Carbon::parse($res->start_time)->format('g:i A') }}</span>
                    </div>
                    <div class="flex items-center gap-4 text-xs text-gray-500 font-medium mb-4">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            {{ $res->total_guest }}
                        </span>
                        @if($res->reservation_type === 'member')
                        <span class="flex items-center gap-1 text-yellow-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            VIP
                        </span>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <form action="{{ route('reservations.updateStatus', $res) }}" method="POST" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="w-full py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-xs font-semibold hover:bg-gray-50 transition-colors" {{ now()->lessThan(\Carbon\Carbon::parse($res->reservation_date . ' ' . $res->start_time)) ? 'disabled' : '' }}>Seat</button>
                        </form>
                        <form action="{{ route('reservations.updateStatus', $res) }}" method="POST" class="w-24">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="no_show">
                            <button type="submit" class="w-full py-2 bg-[#FDEAE8] text-brand-red rounded-lg text-xs font-semibold hover:bg-[#FADBD8] transition-colors">No Show</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-sm text-gray-400 text-center py-4">Belum ada reservasi dikonfirmasi.</div>
                @endforelse
            </div>
        </div>

        <!-- Column: Arrived & Seated (Completed) -->
        <div class="w-[320px] bg-kanban rounded-xl p-4 flex flex-col max-h-full overflow-hidden border border-[#F5E6E3]">
            <div class="flex justify-between items-center mb-4 px-2">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                    <h3 class="font-bold text-gray-800">Arrived & Seated</h3>
                </div>
                <span class="px-2 py-0.5 rounded-full bg-[#EFDFDB] text-brand-red text-xs font-bold">{{ $completed->count() }}</span>
            </div>
            
            <div class="flex-1 overflow-y-auto space-y-3 pr-2 custom-scrollbar">
                @forelse($completed as $res)
                <div class="bg-[#FCF4F2] p-4 rounded-xl shadow-sm border border-transparent opacity-80">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-bold text-gray-500 line-through decoration-gray-300">{{ $res->customer_name }}</h4>
                        </div>
                        @if($res->table)
                        <span class="text-xs font-semibold text-gray-500">T-{{ $res->table->table_number }}</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-4 text-xs text-gray-400 font-medium">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            {{ $res->total_guest }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ \Carbon\Carbon::parse($res->start_time)->format('g:i A') }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-sm text-gray-400 text-center py-4">Belum ada tamu yang tiba.</div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection