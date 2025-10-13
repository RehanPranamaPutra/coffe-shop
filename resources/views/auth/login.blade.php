<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Access Coffee</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen flex">
        {{-- Left Side - Login Form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-white">
            <div class="w-full max-w-md">
                {{-- Logo & Header --}}
                <div class="text-center mb-8">
                    <div class="mx-auto w-20 h-20 mb-4">
                        <img src="{{ asset('./asset/Logo 2.png') }}" alt="Access Coffee" class="w-full h-full object-contain">
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Access Coffee</h1>
                    <p class="text-gray-600">Masuk ke Dashboard Anda</p>
                </div>

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nama@example.com"
                                required
                                autofocus
                                autocomplete="username"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7a3939] focus:border-transparent transition duration-200 @error('email') border-red-500 @enderror">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password"
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                required
                                autocomplete="current-password"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7a3939] focus:border-transparent transition duration-200 @error('password') border-red-500 @enderror">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox"
                                name="remember"
                                id="remember_me"
                                class="w-4 h-4 rounded border-gray-300 text-[#7a3939] focus:ring-[#7a3939] cursor-pointer">
                            <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-900">
                                Remember me
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-sm font-medium text-[#7a3939] hover:text-[#8d4343]">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full flex items-center justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-base font-semibold text-white bg-gradient-to-r from-[#7a3939] to-[#cc9966] hover:from-[#8d4343] hover:to-[#d4a574] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#7a3939] transition duration-200 transform hover:scale-[1.02]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Log in
                    </button>
                </form>

                {{-- Footer --}}
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        © {{ date('Y') }} Access Coffee. All rights reserved.
                    </p>
                </div>
            </div>
        </div>

        {{-- Right Side - Image/Illustration (Hidden di Mobile) --}}
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#7a3939] via-[#8d4343] to-[#cc9966] items-center justify-center p-12 relative overflow-hidden">
            {{-- Decorative circles --}}
            <div class="absolute top-10 right-10 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 left-10 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>

            {{-- Content --}}
            <div class="relative z-10 text-center text-white">
                <div class="mb-8">
                    <svg class="w-32 h-32 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h2 class="text-4xl font-bold mb-4">Selamat Datang!</h2>
                <p class="text-xl text-white/90 mb-2">Sistem Manajemen Kopi</p>
                <p class="text-white/80 max-w-md">
                    Kelola produk, promo, dan pesanan dengan mudah dalam satu platform yang powerful.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
