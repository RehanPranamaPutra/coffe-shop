<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - 403</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="max-w-md w-full text-center bg-white rounded-3xl shadow-2xl p-10 border-t-8 border-[#7a3939]">

            <!-- Icon Lock -->
            <div class="flex justify-center mb-6">
                <div class="bg-red-50 p-6 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-[#7a3939]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>

            <!-- Error Message -->
            <h1 class="text-6xl font-black text-[#7a3939] mb-2">403</h1>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Akses Terbatas!</h2>
            <p class="text-gray-500 mb-8 leading-relaxed">
                Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
            </p>

            <!-- Buttons -->
            <div class="flex flex-col gap-3">
                <a href="{{ route('dashboard') }}" class="w-full py-3 px-6 bg-[#cc9966] text-white rounded-xl font-bold hover:bg-[#b38659] transition duration-200 shadow-lg">
                    Beranda Utama
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
