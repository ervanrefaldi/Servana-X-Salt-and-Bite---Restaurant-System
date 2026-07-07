<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Member - Servana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 font-sans antialiased selection:bg-[#991B1B] selection:text-white">

    @include('partials.public-navbar')

    <main class="py-12">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Welcome Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">
                        Welcome back, <span class="text-[#991B1B]">{{ auth()->user()->name }}</span>
                    </h1>
                    <p class="text-gray-500 mt-2 text-lg">
                        Manage your membership, explore menus, and book your next dining experience.
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
                <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl shadow-sm text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Main Action Card -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-[#FDEAE8] rounded-bl-full -z-0 opacity-50"></div>
                        <div class="relative z-10">
                            <div class="w-14 h-14 bg-[#FDEAE8] text-[#991B1B] rounded-2xl flex items-center justify-center mb-6">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Craving Something Special?</h3>
                            <p class="text-gray-500 mb-8 max-w-lg">
                                Discover our latest culinary creations, explore current promotions, and secure your favorite table for an unforgettable experience.
                            </p>
                            
                            <div class="flex flex-wrap gap-4">
                                <a href="{{ route('reservations.create') }}" class="px-6 py-3 bg-[#991B1B] text-white font-semibold rounded-xl hover:bg-[#8B121A] transition-colors shadow-md flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Book a Table
                                </a>
                                <a href="{{ route('public.menu') }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-colors shadow-sm flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    Explore Menu
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Member Benefits -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Your Exclusive Benefits</h3>
                            <a href="{{ route('member.profile') }}" class="text-sm font-semibold text-[#991B1B] hover:underline">View Profile</a>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-start gap-4 p-5 rounded-xl border border-gray-100 bg-gray-50 hover:bg-white hover:border-[#FDEAE8] hover:shadow-md transition-all">
                                <div class="w-10 h-10 rounded-full bg-[#FDEAE8] text-[#991B1B] flex items-center justify-center shrink-0 mt-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">5% Instant Discount</h4>
                                    <p class="text-sm text-gray-500 mt-1">Automatically applied to all your dining bills when using your member code.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4 p-5 rounded-xl border border-gray-100 bg-gray-50 hover:bg-white hover:border-[#FDEAE8] hover:shadow-md transition-all">
                                <div class="w-10 h-10 rounded-full bg-[#FDEAE8] text-[#991B1B] flex items-center justify-center shrink-0 mt-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Priority Seating</h4>
                                    <p class="text-sm text-gray-500 mt-1">Choose your preferred table manually during the reservation process.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Digital Member Card -->
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-br from-[#991B1B] to-[#5a1010] rounded-2xl shadow-xl overflow-hidden relative text-white">
                        <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/3"></div>
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-black/20 rounded-full blur-xl translate-y-1/3 -translate-x-1/4"></div>
                        
                        <div class="relative z-10 p-8">
                            <div class="flex justify-between items-start mb-10">
                                <div>
                                    <h3 class="text-white/80 text-sm font-semibold tracking-widest uppercase">Servana Elite</h3>
                                    <p class="font-bold text-lg mt-1">Membership</p>
                                </div>
                                <svg class="w-8 h-8 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                            </div>

                            @if (isset($customer) && $customer)
                                <div class="mb-8">
                                    <p class="text-white/60 text-xs uppercase tracking-widest mb-2">Member ID</p>
                                    <p class="text-3xl font-mono tracking-widest font-bold">{{ $customer->member_code }}</p>
                                </div>
                                
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-white/60 text-xs uppercase tracking-widest mb-1">Card Holder</p>
                                        <p class="font-semibold text-lg tracking-wide uppercase">{{ auth()->user()->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-white/60 text-xs uppercase tracking-widest mb-1">Status</p>
                                        <p class="font-bold text-green-400">ACTIVE</p>
                                    </div>
                                </div>
                            @else
                                <div class="py-8 text-center bg-black/20 rounded-xl backdrop-blur-sm border border-white/10">
                                    <svg class="w-10 h-10 mx-auto text-yellow-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <p class="font-semibold">Membership Pending</p>
                                    <p class="text-sm text-white/70 mt-1">Please contact admin to activate.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if (isset($customer) && $customer)
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-500 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-[#991B1B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Show this card at the cashier to claim your 5% discount
                        </p>
                    </div>
                    @endif
                </div>

            </div>

        </div>
    </main>

</body>
</html>