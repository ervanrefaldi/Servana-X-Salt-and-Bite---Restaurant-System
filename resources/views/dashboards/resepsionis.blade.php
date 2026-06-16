<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Resepsionis
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-2">Selamat datang, Resepsionis</h3>
                <p>Anda dapat mengelola reservasi dan meja.</p>

                <div class="mt-4 flex gap-3">
                    <a href="{{ route('tables.index') }}"
                       class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Kelola Meja
                    </a>

                    <a href="{{ route('reservations.index') }}"
                       class="inline-block px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                        Kelola Reservasi
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>