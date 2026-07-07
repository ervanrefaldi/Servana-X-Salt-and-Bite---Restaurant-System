<aside class="w-64 border-r border-gray-100 flex flex-col bg-[#FDFDFD]">
    <!-- Logo Area -->
    <div class="p-6 flex items-center gap-3">
        <div class="w-10 h-10 bg-brand-red rounded flex items-center justify-center text-white font-bold text-lg">
            S
        </div>
        <div>
            <h1 class="font-bold text-gray-900 leading-tight">Servana<br>POS</h1>
            <p class="text-[10px] text-gray-500 uppercase tracking-wider">Management Suite</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-4 space-y-1">
        @php
            $role = auth()->user()->role ?? '';
            $isDashboard = request()->routeIs('*.dashboard') || request()->routeIs('dashboard');
        @endphp

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ $isDashboard ? 'bg-brand-red text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
            <svg class="w-5 h-5 {{ $isDashboard ? '' : 'opacity-70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>
        
        @if(in_array($role, ['kasir', 'admin']))
            @php $isOrders = request()->routeIs('orders.*'); @endphp
            <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ $isOrders ? 'bg-brand-red text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 {{ $isOrders ? '' : 'opacity-70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Orders
            </a>
        @endif

        @if(in_array($role, ['dapur', 'admin']))
            @php $isMenus = request()->routeIs('menus.*'); @endphp
            <a href="{{ route('menus.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ $isMenus ? 'bg-brand-red text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 {{ $isMenus ? '' : 'opacity-70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Manage Menus
            </a>

            @php $isIngredients = request()->routeIs('ingredients.*'); @endphp
            <a href="{{ route('ingredients.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ $isIngredients ? 'bg-brand-red text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 {{ $isIngredients ? '' : 'opacity-70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Manage Ingredients
            </a>

            @php $isStockHistory = request()->routeIs('stock-transactions.*'); @endphp
            <a href="{{ route('stock-transactions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ $isStockHistory ? 'bg-brand-red text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 {{ $isStockHistory ? '' : 'opacity-70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Stock History
            </a>
        @endif

        @if(in_array($role, ['keuangan', 'admin']))
            @php $isFinance = request()->routeIs('financial-transactions.*') || request()->routeIs('stock-transactions.index'); @endphp
            <a href="{{ route('financial-transactions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ $isFinance ? 'bg-brand-red text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 {{ $isFinance ? '' : 'opacity-70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Finance
            </a>
        @endif

        @if(in_array($role, ['sdm', 'admin']))
            @php $isStaff = request()->routeIs('employees.*') || request()->routeIs('salaries.*'); @endphp
            <a href="{{ route('employees.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ $isStaff ? 'bg-brand-red text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 {{ $isStaff ? '' : 'opacity-70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Staff & HR
            </a>
        @endif

        @if(in_array($role, ['resepsionis', 'admin']))
            @php $isReservations = request()->routeIs('reservations.*'); $isTables = request()->routeIs('tables.*'); @endphp
            <a href="{{ route('reservations.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ $isReservations ? 'bg-brand-red text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 {{ $isReservations ? '' : 'opacity-70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Reservations
            </a>
            <a href="{{ route('tables.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ $isTables ? 'bg-brand-red text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 {{ $isTables ? '' : 'opacity-70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                Tables
            </a>
        @endif
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-gray-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-4 py-3 w-full text-left rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </form>
    </div>
</aside>
