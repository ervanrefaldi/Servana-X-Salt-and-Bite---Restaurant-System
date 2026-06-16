<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Menu - Servana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">

    @include('partials.public-navbar')

    <main class="py-8">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">
                    Daftar Menu
                </h1>

                <p class="text-gray-600 mt-2">
                    Silakan lihat pilihan menu yang tersedia di restoran kami.
                </p>
            </div>

            <div class="space-y-6">
                @forelse ($menus as $menu)
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">

                        @if ($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}"
                                 alt="{{ $menu->name }}"
                                 class="w-full h-48 object-cover rounded-md mb-4">
                        @endif

                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded text-xs mb-2">
                            {{ $menu->category }}
                        </span>

                        <h2 class="text-xl font-bold text-gray-800">
                            {{ $menu->name }}
                        </h2>

                        <p class="text-gray-600 mt-2">
                            {{ $menu->description }}
                        </p>

                        <p class="text-lg font-semibold mt-4">
                            Rp{{ number_format($menu->price, 0, ',', '.') }}
                        </p>

                        <p class="text-sm mt-2">
                            Stok:
                            @if ($menu->stock > 0)
                                <span class="text-green-600 font-semibold">
                                    {{ $menu->stock }}
                                </span>
                            @else
                                <span class="text-red-600 font-semibold">
                                    Habis
                                </span>
                            @endif
                        </p>
                    </div>
                @empty
                    <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                        <p class="text-gray-600">
                            Belum ada menu yang tersedia.
                        </p>
                    </div>
                @endforelse
            </div>

        </div>
    </main>

</body>
</html>