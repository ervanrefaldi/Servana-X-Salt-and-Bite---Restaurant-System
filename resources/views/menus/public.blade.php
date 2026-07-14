<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Our Menu - Servana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    @include('partials.favicon')
</head>

<body class="bg-gray-50 text-gray-900 font-sans antialiased selection:bg-[#991B1B] selection:text-white">

    @include('partials.public-navbar')

    <main class="py-12">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-12 max-w-2xl mx-auto">
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-4">
                    Explore Our <span class="text-[#991B1B]">Exquisite Menu</span>
                </h1>
                <p class="text-lg text-gray-600">
                    Discover a culinary journey crafted with passion, using only the finest ingredients to delight your senses.
                </p>
            </div>

            <!-- Categories Filter -->
            <div class="flex flex-wrap justify-center gap-3 mb-12" id="category-filters">
                <button data-filter="all" class="filter-btn px-6 py-2.5 rounded-full bg-[#991B1B] text-white text-sm font-semibold shadow-md transition-transform hover:scale-105">Semua Menu</button>
                <button data-filter="Makanan" class="filter-btn px-6 py-2.5 rounded-full bg-white border border-gray-200 text-gray-600 text-sm font-semibold shadow-sm hover:border-gray-300 transition-all hover:shadow-md">Makanan</button>
                <button data-filter="Minuman" class="filter-btn px-6 py-2.5 rounded-full bg-white border border-gray-200 text-gray-600 text-sm font-semibold shadow-sm hover:border-gray-300 transition-all hover:shadow-md">Minuman</button>
                <button data-filter="Snack" class="filter-btn px-6 py-2.5 rounded-full bg-white border border-gray-200 text-gray-600 text-sm font-semibold shadow-sm hover:border-gray-300 transition-all hover:shadow-md">Snack</button>
                <button data-filter="Dessert" class="filter-btn px-6 py-2.5 rounded-full bg-white border border-gray-200 text-gray-600 text-sm font-semibold shadow-sm hover:border-gray-300 transition-all hover:shadow-md">Dessert</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse ($menus as $menu)
                    <div class="menu-item bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-300 flex flex-col h-full relative transform hover:-translate-y-1" data-category="{{ $menu->category }}">
                        
                        <!-- Stock Badge -->
                        @if ($menu->stock > 0)
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-green-600 shadow-sm z-10">
                                In Stock
                            </div>
                        @else
                            <div class="absolute top-4 right-4 bg-red-500/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-white shadow-sm z-10">
                                Sold Out
                            </div>
                        @endif

                        <!-- Image Container -->
                        <div class="relative w-full h-56 bg-gray-100 overflow-hidden">
                            @if ($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=600&auto=format&fit=crop" alt="Placeholder" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <span class="inline-block px-3 py-1 bg-[#FDEAE8] text-[#991B1B] rounded-full text-xs font-bold uppercase tracking-wider">
                                    {{ $menu->category }}
                                </span>
                            </div>

                            <h2 class="text-xl font-bold text-gray-900 mb-2 line-clamp-1 group-hover:text-[#991B1B] transition-colors">
                                {{ $menu->name }}
                            </h2>

                            <p class="text-gray-500 text-sm mb-4 line-clamp-2 flex-1">
                                {{ $menu->description ?: 'Delicious culinary creation prepared with the finest ingredients.' }}
                            </p>

                            <div class="pt-4 border-t border-gray-100 flex items-center justify-between mt-auto">
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Price</span>
                                    <span class="text-2xl font-black text-[#991B1B]">
                                        Rp{{ number_format($menu->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-12 rounded-2xl shadow-sm text-center border border-gray-100">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Menu Items Available</h3>
                        <p class="text-gray-500">We are currently updating our menu. Please check back later.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const menuItems = document.querySelectorAll('.menu-item');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Update active state styles
                    filterBtns.forEach(b => {
                        b.classList.remove('bg-[#991B1B]', 'text-white', 'hover:scale-105');
                        b.classList.add('bg-white', 'text-gray-600');
                    });
                    btn.classList.remove('bg-white', 'text-gray-600');
                    btn.classList.add('bg-[#991B1B]', 'text-white', 'hover:scale-105');

                    const filterValue = btn.getAttribute('data-filter');

                    // Filter menu items
                    menuItems.forEach(item => {
                        if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                            item.style.display = 'flex';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
