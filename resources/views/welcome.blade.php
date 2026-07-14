<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servana - Fine Dining</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .bg-red-doff { background-color: #991B1B; }
        .text-red-doff { color: #991B1B; }
        .border-red-doff { border-color: #991B1B; }
    </style>
    @include('partials.favicon')
</head>
<body class="bg-[#faf9f8] text-gray-800 antialiased">

    @include('partials.public-navbar')

    {{-- Hero Section --}}
    <section class="max-w-7xl mx-auto px-6 pt-10 md:pt-16 pb-16 md:pb-24">
        <div class="flex flex-col lg:grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">
            <div class="w-full">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#fde8e8] text-red-doff text-xs font-semibold mb-4 md:mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-doff"></span>
                    Now taking reservations for Spring
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif font-bold text-gray-900 leading-[1.1] mb-4 md:mb-6">
                    Sistem manajemen restoran <br class="hidden sm:block">
                    <span class="text-red-doff italic">terintegrasi.</span>
                </h1>
                
                <p class="text-base md:text-lg text-gray-600 mb-6 md:mb-8 max-w-lg leading-relaxed">
                    SERVANA adalah platform yang menyatukan reservasi, pemesanan, kasir, dapur, stok, keuangan, keanggotaan, dan SDM dalam satu sistem untuk membantu operasional restoran berjalan lebih mudah dan terorganisir.
                </p>
                
                <div class="flex flex-wrap gap-3 md:gap-4">
                    <a href="{{ route('reservations.create') }}" class="px-6 md:px-8 py-3 bg-red-doff text-white rounded-md font-medium hover:bg-[#7f1616] transition-colors shadow-sm text-sm md:text-base w-full sm:w-auto text-center">
                        Reserve Now
                    </a>
                    <a href="{{ route('public.menu') }}" class="px-6 md:px-8 py-3 bg-white text-gray-800 border border-gray-300 rounded-md font-medium hover:border-gray-400 transition-colors shadow-sm text-sm md:text-base w-full sm:w-auto text-center">
                        View Menus
                    </a>
                </div>
            </div>
            
            <div class="w-full relative mt-8 lg:mt-0">
                <div class="rounded-2xl overflow-hidden shadow-2xl aspect-[4/3] relative">
                    @if(isset($heroMenu) && $heroMenu->image)
                        <img src="{{ asset('storage/' . $heroMenu->image) }}" alt="{{ $heroMenu->name }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=1200&q=80" alt="Exquisite Burger" class="w-full h-full object-cover">
                    @endif
                </div>
                <!-- Floating Badge -->
                <div class="absolute -bottom-4 -left-4 md:-bottom-6 md:-left-6 bg-white p-3 md:p-4 rounded-xl shadow-xl flex items-center gap-3 md:gap-4 scale-90 md:scale-100 origin-bottom-left">
                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-[#fde8e8] flex items-center justify-center text-red-doff">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] md:text-xs text-gray-500 font-medium">Ervan Refaldi</p>
                        <p class="font-bold text-gray-900 text-sm md:text-base">Featured 2024</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- A Taste of Perfection --}}
    <section class="max-w-7xl mx-auto px-6 py-20 text-center">
        <h2 class="text-3xl font-serif font-bold text-gray-900 mb-4">A Taste of Perfection</h2>
        <p class="text-gray-600 max-w-2xl mx-auto mb-12">Our menu is a living document, adapting to the micro-seasons and highlighting the purest ingredients available.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-left">
            @foreach($featuredMenus as $menu)
            <!-- Item -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="aspect-square rounded-xl overflow-hidden mb-4 bg-gray-100">
                    @if ($menu->image)
                        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=600&auto=format&fit=crop" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-bold text-gray-900 line-clamp-1" title="{{ $menu->name }}">{{ $menu->name }}</h4>
                    <span class="text-red-doff font-semibold">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
                </div>
                <p class="text-sm text-gray-500 line-clamp-2">{{ $menu->description ?: 'Delicious culinary creation prepared with the finest ingredients.' }}</p>
            </div>
            @endforeach

            <!-- Explore More -->
            <a href="{{ route('public.menu') }}" class="bg-[#faf9f8] rounded-2xl p-6 border border-[#fde8e8] flex flex-col items-center justify-center text-center group hover:bg-[#fde8e8] transition-colors">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-red-doff shadow-sm mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h4 class="font-bold text-gray-900 mb-2">Explore the Full Menu</h4>
                <p class="text-sm text-gray-500 mb-6">Discover our seasonal offerings and extensive menu options.</p>
                <span class="text-xs font-bold text-red-doff tracking-wider uppercase">View Menu</span>
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-[#3e2e2e] text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-1">
                    <div class="mb-4 inline-flex rounded-lg bg-white p-2">
                        <x-servana-logo variant="compact" :href="url('/')" class="h-16 w-auto max-w-40" />
                    </div>
                    <p class="text-gray-400 text-sm">Redefining modern hospitality with precision, passion, and elegance.</p>
                </div>
                
                <div>
                    <h4 class="font-bold mb-4">Location</h4>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        123 Culinary Boulevard<br>
                        Metropolis, NY 10012<br>
                        +1 (212) 555-0199
                    </p>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Hours</h4>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Tue - Thu: 5pm - 10pm<br>
                        Fri - Sat: 5pm - 11pm<br>
                        Sun: 4pm - 9pm<br>
                        Mon: Closed
                    </p>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Connect</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500">
                <p>© {{ date('Y') }} Servana Hospitality Group. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-gray-300">Privacy Policy</a>
                    <a href="#" class="hover:text-gray-300">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
