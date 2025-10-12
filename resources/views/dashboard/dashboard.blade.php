@extends('layouts.app')

@section('content')
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
@endsection
