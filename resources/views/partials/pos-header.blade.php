<header class="h-20 border-b border-gray-100 px-4 sm:px-8 flex items-center justify-between gap-4 bg-white shrink-0">
    <div class="lg:hidden shrink-0">
        <x-servana-logo variant="icon" :href="route('dashboard')" class="h-12 w-auto max-w-20" />
    </div>
    <!-- Search Form -->
    <form action="{{ route('reservations.index') }}" method="GET" class="relative hidden sm:block w-96 max-w-full">
        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search guests, reservations..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border-transparent rounded-full focus:bg-white focus:border-gray-200 focus:ring-0 text-sm">
    </form>

    <!-- Right Icons & Profile -->
    <div class="flex items-center gap-5 text-gray-500">
        <button class="relative hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
        </button>
        <button class="hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </button>
        <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden ml-2 border border-gray-200">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=F3F4F6&color=A31621" alt="Profile" class="w-full h-full object-cover">
        </div>
    </div>
</header>
