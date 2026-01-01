<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Access Coffee</title>

    <!-- Google Fonts: Plus Jakarta Sans (Modern Font) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="antialiased bg-[#FDF9F3]"> <!-- Background Cream -->

    <div class="min-h-screen flex items-center justify-center p-4 lg:p-0">

        <div class="w-full max-w-6xl bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(139,70,70,0.15)] overflow-hidden flex min-h-[600px] lg:min-h-[700px]">

            {{-- LEFT SIDE: LOGIN FORM --}}
            <div class="w-full lg:w-1/2 p-8 md:p-12 lg:p-16 flex flex-col justify-center relative">

                {{-- Decorative Blob Top Left --}}
                <div class="absolute top-0 left-0 w-32 h-32 bg-[#FFC47E]/20 rounded-br-full blur-2xl -z-0"></div>

                <div class="w-full max-w-sm mx-auto z-10">
                    {{-- Header --}}
                    <div class="mb-10">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-12 h-12 bg-[#8B4646] rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-[#8B4646]/20">
                                <img src="{{ asset('./asset/Logo 2.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                            </div>
                            <span class="text-2xl font-bold text-[#8B4646]">Access Coffee.</span>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang Kembali</h1>
                        <p class="text-gray-500">Silakan masukkan detail akun Anda untuk masuk.</p>
                    </div>

                    {{-- Session Status --}}
                    @if (session('status'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r-lg">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        {{-- Email --}}
                        <div class="group">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-[#8B4646] transition-colors">
                                Alamat Email
                            </label>
                            <div class="relative">
                                <input id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"

                                    autofocus
                                    autocomplete="username"
                                    placeholder="nama@accesscoffee.com"
                                    class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-[#8B4646]/10 focus:border-[#8B4646] transition-all outline-none placeholder:text-gray-400 text-gray-800 font-medium @error('email') border-red-500 bg-red-50 @enderror">

                                {{-- Icon Email --}}
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#8B4646] transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                                </div>
                            </div>
                            @error('email')
                                <p class="mt-1.5 text-sm text-red-600 font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="group">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-[#8B4646] transition-colors">
                                Password
                            </label>
                            <div class="relative">
                                <input id="password"
                                    type="password"
                                    name="password"

                                    autocomplete="current-password"
                                    placeholder="••••••••"
                                    class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-[#8B4646]/10 focus:border-[#8B4646] transition-all outline-none placeholder:text-gray-400 text-gray-800 font-medium @error('password') border-red-500 bg-red-50 @enderror">

                                {{-- Icon Lock --}}
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#8B4646] transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                </div>
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Remember & Forgot --}}
                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer select-none">
                                <input type="checkbox" name="remember" id="remember_me" class="w-5 h-5 rounded border-gray-300 text-[#8B4646] focus:ring-[#8B4646]/20 transition cursor-pointer">
                                <span class="ml-2 text-sm text-gray-600 font-medium">Ingat saya</span>
                            </label>

                            {{-- @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-[#8B4646] hover:text-[#a05252] transition underline decoration-transparent hover:decoration-[#8B4646]">
                                    Lupa Password?
                                </a>
                            @endif --}}
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" class="w-full py-4 px-6 bg-[#8B4646] hover:bg-[#723838] text-white text-lg font-bold rounded-xl shadow-lg shadow-[#8B4646]/30 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2 group">
                            Masuk Sekarang
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        </button>

                    </form>

                    {{-- Footer --}}
                    <div class="mt-10 text-center">
                        <p class="text-sm text-gray-400">
                            &copy; {{ date('Y') }} Access Coffee System.
                        </p>
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDE: IMAGE & CONTENT --}}
            <div class="hidden lg:block w-1/2 relative bg-[#2D2424]">
                {{-- Background Image --}}
                <img src="https://images.unsplash.com/photo-1497935586351-b67a49e012bf?auto=format&fit=crop&w=1000&q=80"
                     alt="Coffee Shop Vibes"
                     class="absolute inset-0 w-full h-full object-cover opacity-60">

                {{-- Overlay Gradient --}}
                <div class="absolute inset-0 bg-gradient-to-t from-[#2D2424] via-[#8B4646]/40 to-transparent"></div>

                {{-- Floating Content with Glassmorphism --}}
                <div class="absolute bottom-0 left-0 w-full p-12 z-20">
                    <div class="glass-effect rounded-3xl p-8 text-white max-w-md mx-auto lg:mx-0">
                        <div class="w-12 h-1 bg-[#FFC47E] rounded-full mb-6"></div>
                        <h2 class="text-3xl font-bold mb-4 leading-tight">
                            Manage Your Coffee Shop <br>
                            <span class="text-[#FFC47E]">Like a Pro.</span>
                        </h2>
                        <p class="text-white/80 leading-relaxed mb-6">
                            Pantau penjualan, kelola stok menu, dan atur promo dalam satu dashboard yang terintegrasi.
                        </p>

                        {{-- Mini Stats Mockup --}}
                        <div class="flex items-center gap-4 pt-4 border-t border-white/20">
                            <div>
                                <p class="text-xs text-white/60 uppercase tracking-wider">Total Orders</p>
                                <p class="text-xl font-bold">1.2k+</p>
                            </div>
                            <div class="w-px h-8 bg-white/20"></div>
                            <div>
                                <p class="text-xs text-white/60 uppercase tracking-wider">Rating</p>
                                <div class="flex items-center gap-1">
                                    <span class="text-xl font-bold">4.9</span>
                                    <span class="text-[#FFC47E]">★</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
