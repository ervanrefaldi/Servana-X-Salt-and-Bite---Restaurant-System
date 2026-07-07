@extends('layouts.pos')

@section('title', 'Dashboard Dapur - Servana POS')

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    <!-- Page Header -->
    <div class="px-8 pt-8 pb-6 flex justify-between items-end border-b border-gray-100 shrink-0">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Kitchen Dashboard</h2>
            <p class="text-gray-500 text-sm">Monitor stock, manage menu recipes, and handle purchase requests.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('stock-transactions.create') }}" class="px-4 py-2 bg-brand-red text-white rounded-lg text-sm font-medium shadow-sm hover:bg-[#8B121A] transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Stock Request
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
        
        <!-- Inventory Overview -->
        <h3 class="text-lg font-bold text-gray-900 mb-4">Inventory Overview</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#FDEAE8] text-brand-red flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Ingredients</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalIngredients ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-yellow-100 flex items-center gap-4 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-16 h-16 bg-yellow-50 rounded-bl-full -z-0"></div>
                <div class="w-12 h-12 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center shrink-0 z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div class="z-10">
                    <p class="text-sm text-gray-500 font-medium">Low Stock</p>
                    <h3 class="text-2xl font-bold text-yellow-600">{{ $lowStockIngredients ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-red-100 flex items-center gap-4 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-16 h-16 bg-[#FDEAE8] rounded-bl-full -z-0"></div>
                <div class="w-12 h-12 rounded-xl bg-brand-red text-white flex items-center justify-center shrink-0 z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="z-10">
                    <p class="text-sm text-gray-500 font-medium">Out of Stock</p>
                    <h3 class="text-2xl font-bold text-brand-red">{{ $emptyStockIngredients ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Transaction Stats -->
        <h3 class="text-lg font-bold text-gray-900 mb-4">Activity Overview</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Stock In (Transactions)</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ $stockIn ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#FDEAE8] text-brand-red flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Stock Out (Transactions)</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ $stockOut ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Monthly Purchase</p>
                    <h3 class="text-xl font-bold text-gray-900">Rp{{ number_format($monthlyPurchaseCost ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Links</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('menus.index') }}" class="group bg-white border border-gray-200 rounded-xl p-5 hover:border-brand-red hover:shadow-md transition-all flex flex-col items-center justify-center text-center gap-3">
                <div class="w-12 h-12 rounded-full bg-gray-50 group-hover:bg-[#FDEAE8] group-hover:text-brand-red text-gray-400 flex items-center justify-center transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="font-semibold text-gray-700 group-hover:text-brand-red">Manage Menus</span>
            </a>
            
            <a href="{{ route('stock-transactions.create') }}" class="group bg-brand-red border border-transparent rounded-xl p-5 hover:bg-[#8B121A] hover:shadow-md transition-all flex flex-col items-center justify-center text-center gap-3">
                <div class="w-12 h-12 rounded-full bg-white/20 text-white flex items-center justify-center transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <span class="font-semibold text-white">New Request</span>
            </a>
        </div>

    </div>
</div>
@endsection