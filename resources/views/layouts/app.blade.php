<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-sans antialiased">
    @php
        $navLinks = [
            [
                'label' => 'Beranda',
                'route' => 'dashboard',
                'icon' =>
                    '<path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />',
            ],
            [
                'label' => 'Produk',
                'route' => 'produk.index',
                'icon' =>
                    '<path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />',
            ],
            [
                'label' => 'Promo',
                'route' => 'promo.index',
                'icon' =>
                    '<path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" /><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />',
            ],
            [
                'label' => 'Gaji', // Nama diperpendek agar muat di HP
                'route' => 'gaji.index', // Pastikan route ini ada di web.php
                'icon' =>
                    '<path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />',
            ],
            [
                'label' => 'Laporan', // MENU BARU
                'route' => 'laporan.keuangan',
                'icon' =>
                    '<path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />',
            ],
        ];
    @endphp

    <div class="flex min-h-screen bg-gray-100" x-data="{ sidebarOpen: false, mobileMenuOpen: false }">
        <!-- Sidebar (desktop) -->
        <aside
            class="hidden lg:flex bg-[#7a3939] text-white flex-col justify-between p-4 shadow-xl sticky top-0 h-screen overflow-hidden transition-all duration-300 z-20"
            :class="sidebarOpen ? 'w-64' : 'w-20'" @mouseenter="sidebarOpen = true" @mouseleave="sidebarOpen = false">
            <div>
                <div class="mb-10 mt-2 flex items-center justify-center">
                    <template x-if="sidebarOpen">
                        <img src="{{ asset('asset/Logo 2.png') }}" alt="Logo"
                            class="h-10 w-auto transition duration-300" />
                    </template>
                    <template x-if="!sidebarOpen">
                        <div class="text-3xl font-bold uppercase text-[#cc9966]">AC</div>
                    </template>
                </div>

                <nav class="space-y-2">
                    @foreach ($navLinks as $link)
                        <a href="{{ route($link['route']) }}"
                            class="flex items-center p-3 rounded-lg transition duration-300 group hover:shadow-lg hover:font-bold {{ request()->routeIs($link['route']) ? 'bg-[#cc9966] text-white font-semibold' : 'text-white hover:bg-[#cc9966]' }}"
                            :class="sidebarOpen ? 'justify-start' : 'justify-center'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0"
                                viewBox="0 0 20 20" fill="currentColor" :class="sidebarOpen ? '' : 'mr-0'">
                                {!! $link['icon'] !!}
                            </svg>
                            <span class="whitespace-nowrap transition-opacity duration-300"
                                x-show="sidebarOpen">{{ $link['label'] }}</span>
                        </a>
                    @endforeach
                </nav>

                <!-- Transaksi dropdown -->
                <div x-data="{ open: false }" class="text-white mt-4">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full p-3 rounded-lg hover:bg-[#cc9966] transition duration-300"
                        :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                        <div class="flex items-center space-x-3" :class="sidebarOpen ? '' : 'justify-center'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path d="M3 3a1 1 0 000 2h1l1 9h10l1-9h1a1 1 0 100-2H3zm5 12a2 2 0 104 0H8z" />
                            </svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Transaksi</span>
                        </div>
                        <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" :class="open ? 'rotate-180' : ''"
                            class="h-4 w-4 transform transition-transform" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition class="ml-6 mt-1 space-y-1" x-cloak>
                        <a href="{{ route('penjualan.index') }}"
                            class="block px-3 py-2 rounded-md text-sm hover:bg-[#cc9966] hover:font-semibold {{ request()->routeIs('penjualan.*') ? 'bg-[#cc9966] font-bold' : '' }}">
                            Penjualan
                        </a>

                        <a href="{{ route('pembelian.index') }}"
                            class="block px-3 py-2 rounded-md text-sm hover:bg-[#cc9966] hover:font-semibold {{ request()->routeIs('pembelian.*') ? 'bg-[#cc9966] font-bold' : '' }}">
                            Pembelian
                        </a>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full p-3 rounded-xl bg-[#cc9966] text-white font-semibold shadow-lg hover:bg-[#e6b88a] transition duration-200">
                    <span x-show="sidebarOpen">Keluar</span>
                    <span x-show="!sidebarOpen">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </button>
            </form>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col pb-16 lg:pb-0">
            <header
                class="bg-gradient-to-r from-white via-[#f7e0c4]/20 to-white backdrop-blur-md shadow-lg sticky top-0 z-10 border-b-2 border-[#cc9966]/30">
                <div class="px-4 sm:px-6 lg:px-8 py-3 sm:py-4 flex justify-between items-center">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#7a3939]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-[#7a3939] to-[#cc9966] rounded-xl flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-white"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>

                        <h2
                            class="text-lg sm:text-2xl font-bold bg-gradient-to-r from-[#7a3939] to-[#cc9966] bg-clip-text text-transparent">
                            Ringkasan Beranda</h2>
                    </div>

                    <div class="flex items-center space-x-3 sm:space-x-6">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 sm:h-6 sm:w-6 text-gray-500 hover:text-[#cc9966] cursor-pointer transition duration-150"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>

                        <div class="relative cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 sm:h-6 sm:w-6 text-gray-500 hover:text-[#cc9966] transition duration-150"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.405L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span
                                class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white bg-red-500"></span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Mobile menu -->
            <div x-show="mobileMenuOpen" x-transition @click.away="mobileMenuOpen = false"
                class="lg:hidden bg-white shadow-lg border-b-2 border-[#cc9966]/30 sticky top-[60px] z-10">
                <nav class="p-4 space-y-2">
                    @foreach ($navLinks as $link)
                        <a href="{{ route($link['route']) }}"
                            class="flex items-center p-3 rounded-lg transition duration-300 {{ request()->routeIs($link['route']) ? 'bg-[#cc9966] text-white font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0"
                                viewBox="0 0 20 20" fill="currentColor">{!! $link['icon'] !!}</svg>
                            {{ $link['label'] }}
                        </a>
                    @endforeach

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center p-3 rounded-lg bg-red-500 text-white font-semibold hover:bg-red-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </nav>
            </div>

            <main class="p-4 flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>

        <!-- Bottom mobile nav -->
        <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t-2 border-[#cc9966]/30 shadow-2xl z-30">
            <div class="grid grid-cols-3 h-16">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                        class="flex flex-col items-center justify-center transition duration-200 {{ request()->routeIs($link['route']) ? 'text-[#cc9966] font-semibold' : 'text-gray-500 hover:text-[#7a3939]' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20"
                            fill="currentColor">{!! $link['icon'] !!}</svg>
                        <span class="text-xs mt-1">{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </nav>
    </div>

    @stack('scripts')
</body>

</html>
