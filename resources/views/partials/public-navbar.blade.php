<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <div>
            <a href="{{ url('/') }}" class="text-lg font-bold text-gray-800">
                Servana
            </a>
            <p class="text-xs text-gray-500">
                Restaurant Management System
            </p>
        </div>

        <div class="flex items-center gap-6">
            <a href="{{ url('/') }}"
               class="text-sm {{ request()->is('/') ? 'font-bold text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                Home
            </a>

            <a href="{{ route('public.menu') }}"
               class="text-sm {{ request()->routeIs('public.menu') ? 'font-bold text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                Menu
            </a>

            <a href="{{ route('reservations.create') }}"
               class="text-sm {{ request()->routeIs('reservations.create') ? 'font-bold text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                Reservasi
            </a>

            @auth
                @if (auth()->user()->role === 'member')
                    <a href="{{ route('member.profile') }}"
                       class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm hover:bg-gray-700">
                        Profile
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm hover:bg-gray-700">
                        Dashboard
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm hover:bg-gray-700">
                    Login
                </a>
            @endauth
        </div>

    </div>
</nav>