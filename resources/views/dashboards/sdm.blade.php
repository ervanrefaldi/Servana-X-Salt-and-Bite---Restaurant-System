@extends('layouts.pos')

@section('title', 'Dashboard SDM - Servana POS')

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    <!-- Page Header -->
    <div class="px-8 pt-8 pb-6 flex justify-between items-end border-b border-gray-100 shrink-0">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Dasbor SDM</h2>
            <p class="text-gray-500 text-sm">Kelola akun staf, data karyawan, dan pantau status penggajian.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('employees.create') }}" class="px-4 py-2 bg-brand-red text-white rounded-lg text-sm font-medium shadow-sm hover:bg-[#8B121A] transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Tambah Karyawan
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl text-sm">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- HR Overview -->
        <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Tenaga Kerja</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#FDEAE8] text-brand-red flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Karyawan</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ $totalEmployees ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Staf Aktif</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ $activeEmployees ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Akun Sistem</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ $totalStaffAccounts ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-red-100 flex items-center gap-4 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-16 h-16 bg-[#FDEAE8] rounded-bl-full -z-0"></div>
                <div class="w-12 h-12 rounded-xl bg-brand-red text-white flex items-center justify-center shrink-0 z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="z-10">
                    <p class="text-sm text-gray-500 font-medium">Gaji Belum Dibayar</p>
                    <h3 class="text-xl font-bold text-brand-red">{{ $unpaidSalaries ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <h3 class="text-lg font-bold text-gray-900 mb-4">Pengelolaan SDM</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Card 1 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Akun Sistem Staf</h4>
                    <p class="text-sm text-gray-500 mb-6">Kelola kredensial masuk dan role staf untuk mengakses SERVANA POS.</p>
                    <a href="{{ route('staff-accounts.index') }}" class="inline-flex items-center justify-center w-full py-2.5 bg-gray-50 hover:bg-blue-50 text-blue-600 font-semibold rounded-xl text-sm transition-colors border border-transparent hover:border-blue-100">
                        Manage Accounts
                    </a>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Data Karyawan</h4>
                    <p class="text-sm text-gray-500 mb-6">Kelola profil, posisi, dan informasi kontak seluruh karyawan.</p>
                    <a href="{{ route('employees.index') }}" class="inline-flex items-center justify-center w-full py-2.5 bg-gray-50 hover:bg-green-50 text-green-600 font-semibold rounded-xl text-sm transition-colors border border-transparent hover:border-green-100">
                        Manage Employees
                    </a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="w-12 h-12 rounded-xl bg-[#FDEAE8] text-brand-red flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Pemantauan Penggajian</h4>
                    <p class="text-sm text-gray-500 mb-6">Tinjau detail gaji karyawan. Catatan: pembayaran diproses oleh bagian Keuangan.</p>
                    <a href="{{ route('salary-payments.index') }}" class="inline-flex items-center justify-center w-full py-2.5 bg-gray-50 hover:bg-[#FDEAE8] text-brand-red font-semibold rounded-xl text-sm transition-colors border border-transparent hover:border-red-100">
                        View Salaries
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
