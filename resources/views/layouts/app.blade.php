<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LisyModas') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('imgs/lisysouza.jpg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen">

        <button
            @click="sidebarOpen = !sidebarOpen"
            class="lg:hidden fixed top-4 right-4 z-50 p-3 bg-white rounded-full shadow-lg border border-slate-200 text-slate-600 transition-all duration-300"
            :class="sidebarOpen ? 'mr-64 opacity-0 pointer-events-none' : 'mr-0 opacity-100'">
            <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        @include('layouts.sidebar')

        <main class="lg:ml-64 pt-4 lg:pt-8 min-h-screen">
            @yield('content')
        </main>

        <div x-show="sidebarOpen"
            @click="sidebarOpen = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="fixed inset-0 bg-slate-900/40 z-30 lg:hidden">
        </div>
    </div>
</body>

</html>