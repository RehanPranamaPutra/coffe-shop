<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Access Coffee')</title>
    <link rel="icon" href="{{ asset('asset/logo.png') }}?v=1">

    <!-- 1. ALPINE JS (WAJIB) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        coffee: {
                            primary: '#8B4646',    /* Maroon */
                            secondary: '#FFC47E',  /* Gold/Cream */
                            dark: '#1F1F1F',       /* Hitam */
                            gray: '#FAFAFA'        /* Background */
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'serif']
                    }
                }
            }
        }
    </script>

    <!-- 2. ANTI-FLICKER (Agar tidak kedip saat loading) -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<!-- 3. STATE MENU GLOBAL DI BODY -->
<body class="font-sans text-coffee-dark antialiased bg-white flex flex-col min-h-screen"
      x-data="{ mobileMenuOpen: false }">

    <!-- ============================================== -->
    <!-- NAVBAR FIXED -->
    <!-- ============================================== -->
    <nav class="fixed top-0 left-0 w-full z-40 bg-white/95 backdrop-blur-sm border-b border-gray-100 h-20 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex justify-between items-center h-full">

                <!-- LOGO (Z-Index 50 agar selalu di atas) -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group z-50 relative">
                    <img src="{{ asset('asset/Logo 2.png') }}" alt="Access Coffee"
                        class="h-10 w-auto object-contain">
                </a>

                <!-- DESKTOP MENU (Hidden di Mobile) -->
                <div class="hidden md:flex space-x-8 items-center">
                    @php
                        $navClass = 'text-sm font-medium transition duration-300 hover:text-coffee-primary hover:underline hover:decoration-coffee-secondary hover:underline-offset-4';
                        $activeClass = 'text-coffee-primary font-bold underline decoration-coffee-secondary underline-offset-4';
                    @endphp

                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? $activeClass : 'text-gray-500 ' . $navClass }}">Beranda</a>
                    <a href="{{ route('menu') }}" class="{{ request()->routeIs('menu') ? $activeClass : 'text-gray-500 ' . $navClass }}">Menu</a>
                    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? $activeClass : 'text-gray-500 ' . $navClass }}">Tentang</a>
                    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? $activeClass : 'text-gray-500 ' . $navClass }}">Kontak</a>
                </div>

                <!-- DESKTOP LOGIN -->
                <div class="hidden md:flex items-center">
                    <a href="{{ route('login') }}" class="px-5 py-2 rounded-full border border-coffee-primary text-coffee-primary text-sm font-semibold hover:bg-coffee-primary hover:text-white transition duration-300">
                        Login
                    </a>
                </div>

                <!-- TOMBOL TOGGLE MOBILE (Hamburger & Silang) -->
                <div class="md:hidden flex items-center z-50">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-coffee-primary focus:outline-none p-2 transition-transform duration-300">

                        <!-- Icon Garis 3 (Muncul saat Tutup) -->
                        <svg x-show="!mobileMenuOpen" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>

                        <!-- Icon Silang X (Muncul saat Buka) -->
                        <svg x-show="mobileMenuOpen" x-cloak class="w-8 h-8 rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>

                    </button>
                </div>

            </div>
        </div>
    </nav>

    <!-- ============================================== -->
    <!-- MAIN CONTENT -->
    <!-- ============================================== -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- ============================================== -->
    <!-- FOOTER -->
    <!-- ============================================== -->
    <footer class="bg-white border-t border-gray-100 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="font-serif text-2xl font-bold text-coffee-primary mb-4">Access Coffee.</h2>
            <div class="flex justify-center space-x-6 mb-8 text-sm text-gray-500">
                <a href="#" class="hover:text-coffee-primary">Instagram</a>
                <a href="#" class="hover:text-coffee-primary">WhatsApp</a>
                <a href="#" class="hover:text-coffee-primary">Lokasi</a>
            </div>
            <p class="text-xs text-gray-400">&copy; {{ date('Y') }} Access Coffee.</p>
        </div>
    </footer>

    <!-- ============================================== -->
    <!-- MOBILE MENU SIDEBAR (Fixed Overlay) -->
    <!-- ============================================== -->

    <!-- 1. BACKDROP HITAM (Z-Index 45) -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 z-[45] md:hidden backdrop-blur-sm"
         @click="mobileMenuOpen = false"
         x-cloak>
    </div>

    <!-- 2. SIDEBAR PUTIH (Z-Index 50) -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed top-0 right-0 bottom-0 w-[80%] max-w-sm bg-white z-[50] shadow-2xl md:hidden flex flex-col pt-24 pb-6 px-6"
         x-cloak>

        <!-- Link Menu -->
        <div class="space-y-3 flex-grow overflow-y-auto">
            @php
                $mLink = 'block px-5 py-4 text-lg font-medium rounded-xl transition hover:bg-gray-50 hover:text-coffee-primary hover:pl-8 border-l-4 border-transparent text-gray-600';
                $mActive = 'block px-5 py-4 text-lg font-bold text-coffee-primary bg-coffee-secondary/10 border-l-4 border-coffee-primary rounded-r-xl';
            @endphp

            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? $mActive : $mLink }}">Beranda</a>
            <a href="{{ route('menu') }}" class="{{ request()->routeIs('menu') ? $mActive : $mLink }}">Menu Series</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? $mActive : $mLink }}">Tentang Kami</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? $mActive : $mLink }}">Kontak</a>
        </div>

        <!-- Tombol Login Mobile -->
        <div class="mt-4 border-t border-gray-100 pt-6">
            <a href="{{ route('login') }}"
               class="flex items-center justify-center w-full py-4 px-4 bg-coffee-primary text-white font-bold rounded-xl shadow-lg shadow-coffee-primary/20 hover:bg-[#7a3939] transition active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Masuk / Login
            </a>
            <p class="text-center text-xs text-gray-400 mt-6">&copy; {{ date('Y') }} Access Coffee.</p>
        </div>
    </div>

</body>
</html>
