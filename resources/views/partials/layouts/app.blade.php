<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coffee Shop')</title>
    <link rel="icon" href="{{ asset('asset/logo.png') }}?v=1">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    <!-- Tailwind Script (Gunakan Vite/Mix di production) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        coffee: {
                            primary: '#8B4646',
                            secondary: '#FFC47E',
                            dark: '#1F1F1F',
                            gray: '#FAFAFA'
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
</head>

<body class="font-sans text-coffee-dark antialiased bg-white flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-sm border-b border-gray-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('asset/Logo 2.png') }}" alt="Acces Coffee"
                        class="h-8 md:h-10 w-auto object-contain group-hover:opacity-80 transition">
                </a>


                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <!-- Helper Function untuk class active -->
                    @php
                        $navClass =
                            'text-sm font-medium transition duration-300 hover:text-coffee-primary hover:underline hover:decoration-coffee-secondary hover:underline-offset-4';
                        $activeClass =
                            'text-coffee-primary font-bold underline decoration-coffee-secondary underline-offset-4';
                    @endphp

                    <a href="{{ route('home') }}"
                        class="{{ request()->routeIs('home') ? $activeClass : 'text-gray-500 ' . $navClass }}">Beranda</a>
                    <a href="{{ route('menu') }}"
                        class="{{ request()->routeIs('menu') ? $activeClass : 'text-gray-500 ' . $navClass }}">Menu</a>
                    {{-- <a href="{{ route('promo.landing') }}" class="{{ request()->routeIs('promo.landing') ? $activeClass : 'text-gray-500 ' . $navClass }}">Promo</a> --}}
                    <a href="{{ route('about') }}"
                        class="{{ request()->routeIs('about') ? $activeClass : 'text-gray-500 ' . $navClass }}">Tentang</a>
                    <a href="{{ route('contact') }}"
                        class="{{ request()->routeIs('contact') ? $activeClass : 'text-gray-500 ' . $navClass }}">Kontak</a>
                </div>

                <!-- Right Side (Cart/Button) -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('login') }}"
                        class="px-5 py-2 rounded-full border border-coffee-primary text-coffee-primary text-sm font-semibold hover:bg-coffee-primary hover:text-white transition duration-300">
                        Login
                    </a>
                </div>

                <!-- Mobile Button (Hamburger) -->
                <div class="md:hidden flex items-center">
                    <button class="text-coffee-primary focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT WRAPPER -->
    <!-- pt-20 digunakan karena navbar bersifat fixed -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- FOOTER SIMPLE -->
    <footer class="bg-white border-t border-gray-100 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="font-serif text-2xl font-bold text-coffee-primary mb-4">Access Coffe<span
                    class="text-coffee-secondary">.</span></h2>
            <div class="flex justify-center space-x-6 mb-8 text-sm text-gray-500">
                <a href="#" class="hover:text-coffee-primary transition">Instagram</a>
                <a href="#" class="hover:text-coffee-primary transition">WhatsApp</a>
                <a href="#" class="hover:text-coffee-primary transition">Lokasi</a>
            </div>
            <p class="text-xs text-gray-400">&copy; {{ date('Y') }} Senja Coffee Shop. Dibuat dengan sepenuh hati.
            </p>
        </div>
    </footer>

</body>

</html>
