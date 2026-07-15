<nav class="bg-white sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <!-- Logo -->
        <div class="shrink-0">
            <x-servana-logo variant="compact" :href="url('/')" class="h-10 md:h-14 w-auto max-w-28 md:max-w-40" />
        </div>

        <!-- Desktop Menu Links -->
        <div class="hidden md:flex items-center gap-8">
            <a href="{{ url('/') }}"
               class="text-sm font-medium {{ request()->is('/') ? 'text-[#991B1B]' : 'text-gray-500 hover:text-[#991B1B] transition-colors' }}">
                Beranda
            </a>

            <a href="{{ route('public.menu') }}"
               class="text-sm font-medium {{ request()->routeIs('public.menu') ? 'text-[#991B1B]' : 'text-gray-500 hover:text-[#991B1B] transition-colors' }}">
                Menu
            </a>
        </div>

        <!-- Right Side (Auth & Actions) -->
        <div class="flex items-center gap-4">
            <!-- Desktop Auth Links -->
            <div class="hidden md:flex items-center gap-6">
                @auth
                    @if (auth()->user()->role === 'member')
                        <a href="{{ route('member.dashboard') }}"
                           class="text-sm font-medium {{ request()->routeIs('member.dashboard') ? 'text-[#991B1B]' : 'text-gray-500 hover:text-[#991B1B] transition-colors' }}">
                            Dasbor
                        </a>
                        <a href="{{ route('member.profile') }}"
                           class="text-sm font-medium {{ request()->routeIs('member.profile') ? 'text-[#991B1B]' : 'text-gray-500 hover:text-[#991B1B] transition-colors' }}">
                            Profil
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}"
                           class="text-sm font-medium text-gray-500 hover:text-[#991B1B] transition-colors">
                            Dasbor
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium text-gray-500 hover:text-[#991B1B] transition-colors">
                        Masuk
                    </a>
                @endauth
            </div>

            <!-- CTA Button -->
            <a href="{{ route('reservations.create') }}"
               class="px-4 py-2 sm:px-5 sm:py-2.5 bg-[#991B1B] text-white rounded-md text-sm font-medium hover:bg-[#7f1616] transition-all duration-300 shadow-sm flex items-center gap-2">
                <span class="hidden sm:inline">Reservasi Meja</span>
                <span class="sm:hidden">Reservasi</span>
                <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>

            <!-- Mobile Hamburger Button -->
            <button type="button" id="mobile-menu-btn" class="md:hidden p-2 -mr-2 text-gray-500 hover:text-gray-900 focus:outline-none rounded-md transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path id="mobile-menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 shadow-lg absolute w-full">
        <div class="px-6 py-4 flex flex-col gap-4">
            <a href="{{ url('/') }}" class="text-base font-medium {{ request()->is('/') ? 'text-[#991B1B]' : 'text-gray-600 hover:text-[#991B1B]' }}">Beranda</a>
            <a href="{{ route('public.menu') }}" class="text-base font-medium {{ request()->routeIs('public.menu') ? 'text-[#991B1B]' : 'text-gray-600 hover:text-[#991B1B]' }}">Menu</a>
            
            <div class="h-px bg-gray-100 w-full my-1"></div>
            
            @auth
                @if (auth()->user()->role === 'member')
                    <a href="{{ route('member.dashboard') }}" class="text-base font-medium {{ request()->routeIs('member.dashboard') ? 'text-[#991B1B]' : 'text-gray-600 hover:text-[#991B1B]' }}">Dasbor</a>
                    <a href="{{ route('member.profile') }}" class="text-base font-medium {{ request()->routeIs('member.profile') ? 'text-[#991B1B]' : 'text-gray-600 hover:text-[#991B1B]' }}">Profil</a>
                @else
                    <a href="{{ route('dashboard') }}" class="text-base font-medium text-gray-600 hover:text-[#991B1B]">Dasbor</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="text-base font-medium text-gray-600 hover:text-[#991B1B]">Masuk</a>
                <a href="{{ route('member.register') }}" class="text-base font-medium text-gray-600 hover:text-[#991B1B]">Daftar Member</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('mobile-menu-icon');

        if(btn && menu && icon) {
            btn.addEventListener('click', function() {
                menu.classList.toggle('hidden');
                
                // Toggle hamburger and close icon
                if (menu.classList.contains('hidden')) {
                    icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
                } else {
                    icon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
                }
            });
        }
    });
</script>
