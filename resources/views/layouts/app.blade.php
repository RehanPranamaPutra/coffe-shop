<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Access Coffee')</title>
      <link rel="icon" href="{{ asset('asset/logo.png') }}?v=1">
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts & Styles -->
   
    @stack('styles')
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="flex min-h-screen" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">

        <!-- SIDEBAR (DESKTOP) -->
        <aside
            class="relative hidden lg:flex bg-[#7a3939] text-white flex-col justify-between p-4 shadow-2xl sticky top-0 h-screen transition-all duration-300 ease-in-out z-40"
            :class="sidebarOpen ? 'w-64' : 'w-20'">

            <!-- FLOATING TOGGLE BUTTON -->
            <button @click="sidebarOpen = !sidebarOpen"
                class="absolute -right-3 top-10 z-50 bg-[#cc9966] text-white p-1 rounded-full border-2 border-[#7a3939] hover:bg-[#e6b88a] transition-all duration-300 shadow-lg focus:outline-none focus:ring-2 focus:ring-[#cc9966]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-500" :class="sidebarOpen ? 'rotate-0' : 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <div>
                <!-- LOGO SECTION -->
                <div class="mb-10 mt-2 flex items-center overflow-hidden transition-all duration-300" :class="sidebarOpen ? 'justify-start px-2' : 'justify-center px-0'">
                    <div class="flex-shrink-0">
                        <template x-if="sidebarOpen">
                            <img src="{{ asset('asset/Logo 2.png') }}" alt="Logo" class="h-10 w-auto" />
                        </template>
                        <template x-if="!sidebarOpen">
                            <div class="text-2xl font-extrabold text-[#cc9966] tracking-tighter">AC</div>
                        </template>
                    </div>
                </div>

                <!-- NAVIGATION LINKS -->
                <nav class="space-y-1.5">
                    <!-- Beranda -->
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-[#cc9966] shadow-md' : 'hover:bg-white/10' }}"
                        :class="sidebarOpen ? 'justify-start' : 'justify-center'" title="Beranda">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="ml-3 font-medium whitespace-nowrap">Beranda</span>
                    </a>

                    <!-- Produk -->
                    <a href="{{ route('produk.index') }}"
                        class="flex items-center p-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('produk.index') ? 'bg-[#cc9966] shadow-md' : 'hover:bg-white/10' }}"
                        :class="sidebarOpen ? 'justify-start' : 'justify-center'" title="Produk">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="ml-3 font-medium whitespace-nowrap">Produk</span>
                    </a>

                    <!-- Promo -->
                    <a href="{{ route('promo.index') }}"
                        class="flex items-center p-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('promo.index') ? 'bg-[#cc9966] shadow-md' : 'hover:bg-white/10' }}"
                        :class="sidebarOpen ? 'justify-start' : 'justify-center'" title="Promo">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" /><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="ml-3 font-medium whitespace-nowrap">Promo</span>
                    </a>

                    @can('roleOwner')
                    <!-- Gaji -->
                    <a href="{{ route('gaji.index') }}"
                        class="flex items-center p-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('gaji.index') ? 'bg-[#cc9966] shadow-md' : 'hover:bg-white/10' }}"
                        :class="sidebarOpen ? 'justify-start' : 'justify-center'" title="Gaji">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="ml-3 font-medium whitespace-nowrap">Gaji</span>
                    </a>

                    <a href="{{ route('laporan.keuangan') }}"
                        class="flex items-center p-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('laporan.keuangan') ? 'bg-[#cc9966] shadow-md' : 'hover:bg-white/10' }}"
                        :class="sidebarOpen ? 'justify-start' : 'justify-center'" title="Laporan Keuangan">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="ml-3 font-medium whitespace-nowrap">Laporan</span>
                    </a>
                    @endcan

                    <!-- Laporan -->

                    <!-- Dropdown Transaksi -->
                    <div x-data="{ dropdownOpen: false }" class="mt-4">
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="flex items-center w-full p-3 rounded-xl transition-all duration-200 hover:bg-white/10"
                            :class="sidebarOpen ? 'justify-between' : 'justify-center'" title="Transaksi">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 3a1 1 0 000 2h1l1 9h10l1-9h1a1 1 0 100-2H3zm5 12a2 2 0 104 0H8z" />
                                </svg>
                                <span x-show="sidebarOpen" class="ml-3 font-medium">Transaksi</span>
                            </div>
                            <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" :class="dropdownOpen ? 'rotate-180' : ''" class="h-4 w-4 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="dropdownOpen && sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-100" class="ml-9 mt-1 space-y-1">
                            <a href="{{ route('penjualan.index') }}" class="block p-2 text-sm text-gray-300 hover:text-white hover:font-bold transition">Penjualan</a>
                            <a href="{{ route('pembelian.index') }}" class="block p-2 text-sm text-gray-300 hover:text-white hover:font-bold transition">Pembelian</a>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- LOGOUT BUTTON -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center p-3 rounded-xl bg-white/10 hover:bg-red-600 transition-all duration-300 group shadow-inner"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'" title="Keluar dari Aplikasi">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#cc9966] group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3 font-semibold whitespace-nowrap">Keluar</span>
                </button>
            </form>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- HEADER -->
            <header class="bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-200 sticky top-0 z-30">
                <div class="px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <!-- Hamburger (Mobile Only) -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition focus:outline-none">
                            <svg class="h-6 w-6 text-[#7a3939]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>


                    </div>

                    <!-- Profile/Notif (Optional Placeholder) -->
                    <div class="flex items-center space-x-3">
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-bold text-gray-700 leading-tight">{{ Auth::user()->name ?? 'Administrator' }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>

                    </div>
                </div>
            </header>

            <!-- MAIN DYNAMIC CONTENT -->
            <main class="p-4 sm:p-6 lg:p-8 flex-1 overflow-y-auto pb-24 lg:pb-8">
                @yield('content')
            </main>
        </div>

        <!-- MOBILE OVERLAY MENU (Slide-in) -->
        <div x-show="mobileMenuOpen" x-cloak class="lg:hidden fixed inset-0 z-50 overflow-hidden">
            <!-- Backdrop -->
            <div x-show="mobileMenuOpen" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="mobileMenuOpen = false"></div>

            <div class="absolute inset-y-0 left-0 w-3/4 max-w-xs bg-[#7a3939] shadow-xl p-6 flex flex-col justify-between"
                 x-show="mobileMenuOpen"
                 x-transition:enter="transform transition ease-in-out duration-300"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0">

                <div>
                    <div class="flex justify-between items-center mb-8 pb-4 border-b border-white/10">
                        <img src="{{ asset('asset/Logo 2.png') }}" class="h-8 w-auto" alt="Logo">
                        <button @click="mobileMenuOpen = false" class="text-white hover:text-[#cc9966]">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" /></svg>
                        </button>
                    </div>

                    <nav class="space-y-4">
                        <a href="{{ route('dashboard') }}" class="flex items-center text-white p-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-[#cc9966]' : '' }}">Beranda</a>
                        <a href="{{ route('produk.index') }}" class="flex items-center text-white p-3 rounded-lg {{ request()->routeIs('produk.index') ? 'bg-[#cc9966]' : '' }}">Produk</a>
                        <a href="{{ route('promo.index') }}" class="flex items-center text-white p-3 rounded-lg {{ request()->routeIs('promo.index') ? 'bg-[#cc9966]' : '' }}">Promo</a>
                        <a href="{{ route('gaji.index') }}" class="flex items-center text-white p-3 rounded-lg {{ request()->routeIs('gaji.index') ? 'bg-[#cc9966]' : '' }}">Gaji</a>
                        <a href="{{ route('laporan.keuangan') }}" class="flex items-center text-white p-3 rounded-lg {{ request()->routeIs('laporan.keuangan') ? 'bg-[#cc9966]' : '' }}">Laporan</a>
                    </nav>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full p-4 bg-red-600 text-white rounded-xl font-bold shadow-lg">Keluar</button>
                </form>
            </div>
        </div>

        <!-- MOBILE BOTTOM NAV (Quick Access) -->
        <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-[#cc9966]/30 shadow-[0_-5px_15px_rgba(0,0,0,0.05)] z-40">
            <div class="grid grid-cols-5 h-16">
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('dashboard') ? 'text-[#cc9966]' : 'text-gray-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                    <span class="text-[10px] mt-1 font-medium">Beranda</span>
                </a>
                <a href="{{ route('produk.index') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('produk.index') ? 'text-[#cc9966]' : 'text-gray-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" /></svg>
                    <span class="text-[10px] mt-1 font-medium">Produk</span>
                </a>
                <a href="{{ route('promo.index') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('promo.index') ? 'text-[#cc9966]' : 'text-gray-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" /><path d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" /></svg>
                    <span class="text-[10px] mt-1 font-medium">Promo</span>
                </a>
                <a href="{{ route('gaji.index') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('gaji.index') ? 'text-[#cc9966]' : 'text-gray-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a1 1 0 100-2 1 1 0 000 2z" /></svg>
                    <span class="text-[10px] mt-1 font-medium">Gaji</span>
                </a>
                <a href="{{ route('laporan.keuangan') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('laporan.keuangan') ? 'text-[#cc9966]' : 'text-gray-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" /></svg>
                    <span class="text-[10px] mt-1 font-medium">Laporan</span>
                </a>
            </div>
        </nav>
    </div>

    @stack('scripts')
</body>
</html>
