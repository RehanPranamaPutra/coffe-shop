<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        
        {{-- Struktur utama: Menggunakan Alpine.js untuk mengontrol status sidebar --}}
        <div class="flex min-h-screen bg-gray-100" x-data="{ sidebarOpen: false }">
            
            {{-- Bagian Sidebar (Kiri) - Tetap --}}
            <div 
                class="bg-[#7a3939] text-white flex flex-col justify-between p-4 shadow-xl sticky top-0 h-screen overflow-hidden 
                       transition-all duration-300 ease-in-out z-20"
                :class="sidebarOpen ? 'w-64' : 'w-20'" 
                @mouseenter="sidebarOpen = true" 
                @mouseleave="sidebarOpen = false"
            >
                <div>
                    {{-- LOGO/NAMA APLIKASI BARU --}}
                    <div class="mb-10 mt-2 flex items-center justify-center">
                        <template x-if="sidebarOpen">
                            <img src="{{asset('./asset/Logo 2.png') }}" alt="Access Coffee Logo" class="h-10 w-auto transition duration-300">
                        </template>
                        <template x-if="!sidebarOpen">
                            <div class="text-3xl font-bold uppercase text-[#cc9966]">AC</div>
                        </template>
                    </div>
                    
                    {{-- Navigasi Sidebar - Diterjemahkan --}}
                    <nav class="space-y-2">
                        @php
                            $navLinks = [
                                ['label' => 'Beranda', 'icon' => '<path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />', 'active' => true],
                                ['label' => 'Produk', 'icon' => '<path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1h4a1 1 0 011 1v4a1 1 0 01-1 1h-1a1 1 0 00-1 1v3a1 1 0 01-1 1H8a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a1 1 0 01-1-1V5a1 1 0 011-1h4V3a1 1 0 011-1zm2 10a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />', 'active' => false],
                                ['label' => 'Pesanan', 'icon' => '<path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.54 12 5.25 12h11.5a1 1 0 000-2H6.52l-.41-1.648a1 1 0 00-.01-.042L4.22 4h11.58a1 1 0 000-2H3z" /><path d="M16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />', 'active' => false],
                                ['label' => 'Laporan', 'icon' => '<path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" /><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />', 'active' => false],
                            ];
                        @endphp
                        @foreach ($navLinks as $link)
                            <a href="#" 
                               class="flex items-center p-3 rounded-lg transition duration-300 group hover:shadow-lg hover:font-bold 
                                      {{ $link['active'] ? 'bg-[#cc9966] text-white font-semibold transform hover:scale-[1.02]' : 'text-white hover:bg-[#cc9966]' }}"
                               :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" 
                                     viewBox="0 0 20 20" fill="currentColor" 
                                     :class="sidebarOpen ? '' : 'mr-0'">
                                    {!! $link['icon'] !!}
                                </svg>
                                <span class="whitespace-nowrap transition-opacity duration-300" x-show="sidebarOpen">
                                    {{ $link['label'] }}
                                </span>
                            </a>
                        @endforeach
                    </nav>
                </div>
                {{-- Logout Button (Bawah) --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full p-3 rounded-xl bg-[#cc9966] text-white font-semibold shadow-lg hover:bg-[#e6b88a] transition duration-200 transform hover:scale-[1.02]"
                            :class="sidebarOpen ? 'w-full' : 'w-14 mx-auto'"
                    >
                        <span x-show="sidebarOpen">Keluar</span>
                        <span x-show="!sidebarOpen">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                </form>
            </div>

            {{-- Bagian Konten Utama (Kanan) --}}
            <div class="flex-1">
                {{-- Page Header / Navigation Bar --}}
                <header class="bg-gradient-to-r from-white via-[#f7e0c4]/20 to-white backdrop-blur-md shadow-lg sticky top-0 z-10 border-b-2 border-[#cc9966]/30">
                    <div class="px-8 py-4 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-[#7a3939] to-[#cc9966] rounded-xl flex items-center justify-center shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-[#7a3939] to-[#cc9966] bg-clip-text text-transparent">
                                Ringkasan Beranda
                            </h2>
                        </div>
                        {{-- Ikon Pencarian dan Notifikasi --}}
                        <div class="flex items-center space-x-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 hover:text-[#cc9966] cursor-pointer transition duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <div class="relative cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 hover:text-[#cc9966] transition duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.405L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white bg-red-500"></span>
                            </div>
                        </div>
                    </div>
                </header>
                
                <main class="p-8">
                    {{-- HEADER DAN SAMBUTAN --}}
                    <div class="bg-gradient-to-r from-[#7a3939] to-[#cc9966] rounded-2xl p-6 md:p-8 mb-8 shadow-xl">
                        <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Selamat Datang Kembali, Admin! ☕</h1>
                        <p class="text-[#f7e0c4] text-md md:text-lg">Pantau dan kelola bisnis Anda di sini.</p>
                    </div>

                    {{-- BAGIAN 1: KEY PERFORMANCE INDICATORS (KPI) --}}
                    <h3 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Metrik Keuangan Utama (Bulan Ini)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        
                        {{-- Card 1: Total Sales (Uang Masuk) --}}
                        <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 border-b-4 border-green-500">
                            <h3 class="text-gray-500 text-sm font-medium mb-1">Total Penjualan (Uang Masuk)</h3>
                            <p class="text-2xl font-bold text-gray-800">Rp 45.2M</p>
                            <div class="flex items-center mt-2">
                                <span class="text-sm font-semibold text-green-500 mr-1">+12.5%</span>
                                <span class="text-xs text-gray-400">vs Bulan Lalu</span>
                            </div>
                        </div>

                        {{-- Card 2: Total Expenses (Uang Keluar) --}}
                        <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 border-b-4 border-red-500">
                            <h3 class="text-gray-500 text-sm font-medium mb-1">Total Pengeluaran (Uang Keluar)</h3>
                            <p class="text-2xl font-bold text-gray-800">Rp 20.8M</p>
                            <div class="flex items-center mt-2">
                                <span class="text-sm font-semibold text-red-500 mr-1">+4.5%</span>
                                <span class="text-xs text-gray-400">vs Bulan Lalu</span>
                            </div>
                        </div>

                        {{-- Card 3: New Orders (Volume Penjualan) --}}
                        <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 border-b-4 border-[#cc9966]">
                            <h3 class="text-gray-500 text-sm font-medium mb-1">Pesanan Baru</h3>
                            <p class="text-2xl font-bold text-gray-800">1.248</p>
                            <div class="flex items-center mt-2">
                                <span class="text-sm font-semibold text-green-500 mr-1">+8.2%</span>
                                <span class="text-xs text-gray-400">vs Bulan Lalu</span>
                            </div>
                        </div>

                        {{-- Card 4: Total Customers --}}
                        <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 border-b-4 border-[#7a3939]">
                            <h3 class="text-gray-500 text-sm font-medium mb-1">Total Pelanggan</h3>
                            <p class="text-2xl font-bold text-gray-800">3.567</p>
                            <div class="flex items-center mt-2">
                                <span class="text-sm font-semibold text-green-500 mr-1">+15.3%</span>
                                <span class="text-xs text-gray-400">vs Bulan Lalu</span>
                            </div>
                        </div>
                    </div>

                    {{-- BAGIAN 2: DETAIL TRANSAKSI DAN OPERASIONAL (3 KOLOM) --}}
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        {{-- KOLOM 1: PESANAN TERBARU (MAJOR SPACE) --}}
                        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-bold text-gray-800">Pesanan Terbaru</h2>
                                <a href="#" class="text-[#cc9966] hover:text-[#7a3939] font-semibold text-sm transition">Lihat Semua →</a>
                            </div>
                            <div class="space-y-4">
                                @php
                                    $orders = [
                                        ['customer' => 'John Doe', 'product' => 'Biji Kopi Arabika', 'amount' => 'Rp 250.000', 'status' => 'Selesai', 'color' => 'green'],
                                        ['customer' => 'Jane Smith', 'product' => 'Mesin Espresso', 'amount' => 'Rp 3.500.000', 'status' => 'Diproses', 'color' => 'yellow'],
                                        ['customer' => 'Mike Johnson', 'product' => 'Penggiling Kopi', 'amount' => 'Rp 850.000', 'status' => 'Dikirim', 'color' => 'blue'],
                                        ['customer' => 'Sarah Williams', 'product' => 'Milk Frother', 'amount' => 'Rp 450.000', 'status' => 'Selesai', 'color' => 'green'],
                                        ['customer' => 'D. Angga', 'product' => 'Latte Premium', 'amount' => 'Rp 55.000', 'status' => 'Selesai', 'color' => 'green'],
                                    ];
                                @endphp
                                @foreach($orders as $order)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-[#f7e0c4] transition">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-[#cc9966] rounded-full flex items-center justify-center text-white font-bold text-sm">
                                            {{ substr($order['customer'], 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $order['customer'] }}</p>
                                            <p class="text-sm text-gray-500">{{ $order['product'] }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-800">{{ $order['amount'] }}</p>
                                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full 
                                            @if($order['color'] == 'green') bg-green-100 text-green-700
                                            @elseif($order['color'] == 'yellow') bg-yellow-100 text-yellow-700
                                            @else bg-blue-100 text-blue-700
                                            @endif
                                        ">
                                            {{ $order['status'] }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- KOLOM 2: RINGKASAN KEUANGAN & AKSI CEPAT --}}
                        <div class="bg-white rounded-xl shadow-lg p-6 space-y-6">
                            
                            {{-- Card Laba Kotor (GROSS MARGIN) --}}
                            <div class="p-5 rounded-xl border border-[#cc9966]/50 bg-[#fef5ee] shadow-md">
                                <h3 class="text-md font-bold text-gray-700 mb-1 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.86 5.25a2.25 2.25 0 013.374 0L15 12h3.25L12 7.5l-6.25 4.5V12h3.25z" />
                                    </svg>
                                    Laba Kotor (Profit)
                                </h3>
                                <p class="text-3xl font-extrabold text-[#7a3939]">Rp 24.4M</p>
                                <p class="text-sm text-gray-500 mt-1">Netto sebelum biaya operasional</p>
                            </div>

                            {{-- Quick Actions - Fokus ke Alur Owner --}}
                            <div>
                                <h2 class="text-md font-bold text-gray-800 mb-3 border-b pb-1">Aksi Cepat (Owner Tasks)</h2>
                                <div class="space-y-3">
                                    <button class="w-full bg-gradient-to-r from-red-600 to-red-400 text-white p-3 rounded-lg font-semibold hover:shadow-xl transform hover:scale-105 transition-all duration-200 text-sm">
                                        + Catat Pengeluaran Baru
                                    </button>
                                    <button class="w-full bg-[#f7e0c4] text-[#7a3939] p-3 rounded-lg font-semibold hover:bg-[#cc9966] hover:text-white transition-all duration-200 text-sm">
                                        Kelola Stok Bahan Baku
                                    </button>
                                    <button class="w-full bg-[#f7e0c4] text-[#7a3939] p-3 rounded-lg font-semibold hover:bg-[#cc9966] hover:text-white transition-all duration-200 text-sm">
                                        Lihat Laporan Keuangan
                                    </button>
                                </div>
                            </div>

                             {{-- Performance Chart --}}
                            <div class="mt-4 p-4 bg-gradient-to-br from-[#f7e0c4] to-[#cc9966] rounded-lg shadow-md">
                                <h3 class="text-white font-bold mb-2 text-center">Tren Penjualan Mingguan</h3>
                                <div class="flex items-end space-x-2 h-24">
                                    @foreach([60, 80, 45, 90, 70, 95, 75] as $height)
                                    <div class="flex-1 bg-white rounded-t opacity-90" style="height: {{ $height }}%"></div>
                                    @endforeach
                                </div>
                                <p class="text-white text-xs mt-2 text-center">Sen - Min</p>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html> 