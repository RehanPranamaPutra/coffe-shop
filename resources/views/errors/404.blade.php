<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan - 404</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="max-w-md w-full text-center bg-white rounded-3xl shadow-2xl p-10 border-t-8 border-[#cc9966]">

            <!-- Icon Search/Not Found -->
            <div class="flex justify-center mb-6">
                <div class="bg-amber-50 p-6 rounded-full animate-bounce">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-[#cc9966]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Error Message -->
            <h1 class="text-6xl font-black text-[#7a3939] mb-2">404</h1>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Waduh! Halaman Hilang</h2>
            <p class="text-gray-500 mb-8 leading-relaxed">
                Halaman yang Anda cari tidak dapat ditemukan atau mungkin sudah dipindahkan ke tempat lain.
            </p>

            <!-- Buttons -->
            <div class="flex flex-col gap-3">
                
                <a href="{{ route('dashboard') }}" class="w-full py-3 px-6 border-2 border-[#cc9966] text-[#cc9966] rounded-xl font-bold hover:bg-[#cc9966] hover:text-white transition duration-200">
                    Ke Beranda Utama
                </a>
            </div>

            <!-- Footer Logo -->
            <div class="mt-8 pt-6 border-t border-gray-100 italic text-sm text-gray-400">
                &copy; {{ date('Y') }} {{ config('app.name') }}
            </div>
        </div>
    </div>
</body>
</html>
