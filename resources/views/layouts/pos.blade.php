<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Servana POS')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #ffffff; }
        .bg-brand-red { background-color: #A31621; }
        .text-brand-red { color: #A31621; }
        .bg-kanban { background-color: #FCF4F2; }
        /* Custom scrollbar for kanban columns */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #E5E7EB;
            border-radius: 4px;
        }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background: #D1D5DB;
        }
    </style>
    @stack('styles')
</head>
<body class="flex h-screen overflow-hidden text-gray-800">

    {{-- Sidebar --}}
    @include('partials.pos-sidebar')

    {{-- Main Content Wrapper --}}
    <main class="flex-1 flex flex-col bg-white overflow-hidden">
        
        <!-- Topbar -->
        @include('partials.pos-header')

        <!-- Dynamic Content -->
        @yield('content')

    </main>

    @stack('scripts')
</body>
</html>
