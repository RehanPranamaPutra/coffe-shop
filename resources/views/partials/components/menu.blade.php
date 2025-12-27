@extends('partials.layouts.app')

@section('title', 'Daftar Menu - Access Coffee')

@section('content')
    <div class="min-h-screen bg-[#FDF9F3]" x-data="{ activeCategory: 'Semua' }">

        <!-- HEADER SECTION -->
        <div class="bg-coffee-primary pt-32 pb-16 rounded-b-[3rem] shadow-xl relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10"
                style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>

            <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
                <h1 class="font-serif text-4xl md:text-5xl font-bold text-white mb-4">Jelajahi Rasa Kami</h1>
                <p class="text-coffee-secondary text-lg max-w-2xl mx-auto">
                    Temukan minuman dan makanan favoritmu dari koleksi terbaik Access Coffee.
                </p>
            </div>
        </div>

        <!-- CONTENT SECTION -->
        <div class="min-h-screen bg-[#FDF9F3]" x-data="{ activeTab: 'Semua' }">


            <div class="max-w-7xl mx-auto px-4 -mt-8 relative z-20 pb-20">

                <!-- ============================================== -->
                <!-- 1. TAB BUTTONS (NAVIGASI KATEGORI)             -->
                <!-- ============================================== -->
                <div class="flex justify-center mb-10">
                    <div
                        class="bg-white p-2 rounded-full shadow-lg border border-gray-100 inline-flex flex-wrap justify-center gap-2">

                        <!-- Kita hardcode tombolnya agar sesuai urutan yang Anda minta -->

                        <!-- Tombol SEMUA -->
                        <button @click="activeTab = 'Semua'"
                            class="px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300"
                            :class="activeTab === 'Semua' ? 'bg-coffee-primary text-white shadow-md transform scale-105' :
                                'text-gray-500 hover:bg-gray-100 hover:text-coffee-primary'">
                            Semua
                        </button>

                        <!-- Tombol KOPI -->
                        <button @click="activeTab = 'Kopi'"
                            class="px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300"
                            :class="activeTab === 'Kopi' ? 'bg-coffee-primary text-white shadow-md transform scale-105' :
                                'text-gray-500 hover:bg-gray-100 hover:text-coffee-primary'">
                            Kopi
                        </button>

                        <!-- Tombol NON KOPI -->
                        <button @click="activeTab = 'Non Kopi'"
                            class="px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300"
                            :class="activeTab === 'Non Kopi' ? 'bg-coffee-primary text-white shadow-md transform scale-105' :
                                'text-gray-500 hover:bg-gray-100 hover:text-coffee-primary'">
                            Non Kopi
                        </button>

                        <!-- Tombol MAKANAN -->
                        <button @click="activeTab = 'Makanan'"
                            class="px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300"
                            :class="activeTab === 'Makanan' ? 'bg-coffee-primary text-white shadow-md transform scale-105' :
                                'text-gray-500 hover:bg-gray-100 hover:text-coffee-primary'">
                            Makanan
                        </button>

                        <!-- Tombol SNACK -->
                        <button @click="activeTab = 'Snack'"
                            class="px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300"
                            :class="activeTab === 'Snack' ? 'bg-coffee-primary text-white shadow-md transform scale-105' :
                                'text-gray-500 hover:bg-gray-100 hover:text-coffee-primary'">
                            Snack
                        </button>

                    </div>
                </div>

                <!-- ============================================== -->
                <!-- 2. GRID MENU (DAFTAR ITEM)                     -->
                <!-- ============================================== -->
                <!-- GRID MENU -->
                <!-- GRID MENU -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    @foreach ($menus as $menu)
                        <!-- PERUBAHAN DISINI: -->
                        <!-- 1. Ubah <div> menjadi <a> -->
                        <!-- 2. Tambahkan href ke route detail -->
                        <a href="{{ route('menu.show', $menu->slug) }}"
                            x-show="activeTab === 'Semua' || activeTab === '{{ $menu->kategori_final }}'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group flex flex-col h-full border border-transparent hover:border-coffee-secondary/30 relative cursor-pointer block">

                            <!-- Gambar -->
                            <div class="relative h-48 rounded-xl overflow-hidden mb-4 bg-gray-100">
                                <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-700">

                                <!-- BADGE KATEGORI (Kiri Atas) -->
                                <span
                                    class="absolute top-2 left-2 bg-white/90 backdrop-blur text-coffee-primary text-[10px] font-bold px-2 py-1 rounded shadow-sm border border-coffee-primary/10">
                                    {{ $menu->kategori_final }}
                                </span>

                                <!-- BADGE PROMO (Kanan Atas) -->
                                @if ($menu->activePromo)
                                    <div
                                        class="absolute top-2 right-2 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md animate-pulse">
                                        {{ $menu->label_diskon }} OFF
                                    </div>
                                @endif
                            </div>

                            <!-- Info Menu -->
                            <div class="flex-grow">
                                <h3
                                    class="font-serif text-lg font-bold text-coffee-primary leading-tight mb-2 group-hover:text-coffee-secondary transition-colors">
                                    {{ $menu->nama_menu }}
                                </h3>
                                <p class="text-xs text-gray-500 line-clamp-2 mb-3 h-8">
                                    {{ $menu->deskripsi }}
                                </p>

                                <div class="flex items-center gap-1 mb-3">
                                    <div
                                        class="w-4 h-4 rounded-full bg-orange-100 flex items-center justify-center text-[8px]">
                                        🔥</div>
                                    <span class="text-xs text-gray-400 font-medium">Terjual
                                        {{ $menu->total_terjual ?? 0 }}</span>
                                </div>
                            </div>

                            <!-- Harga & Action -->
                            <div class="mt-auto pt-3 border-t border-gray-50 flex items-center justify-between">

                                <!-- LOGIC TAMPILAN HARGA -->
                                <div class="flex flex-col">
                                    @if ($menu->activePromo)
                                        <span class="text-[10px] text-gray-400 line-through">
                                            Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                        </span>
                                        <span class="text-lg font-bold text-red-600">
                                            Rp {{ number_format($menu->harga_akhir, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-lg font-bold text-coffee-dark">
                                            Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Ikon Tombol (Visual Saja) -->
                                <!-- Karena pembungkusnya sudah <a>, tombol ini otomatis ikut terklik -->
                                {{-- <div
                                    class="w-9 h-9 rounded-full bg-coffee-primary text-white flex items-center justify-center hover:bg-coffee-secondary hover:text-coffee-primary transition shadow-lg shadow-coffee-primary/20 transform active:scale-95">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div> --}}
                            </div>

                        </a>
                    @endforeach

                </div>

                <!-- Pesan Kosong -->
                <div x-show="$el.querySelectorAll('.grid > div[x-show]:not([style*=\'display: none\'])').length === 0"
                    class="hidden py-20 text-center" style="display: none;">
                    <div class="text-6xl mb-4 opacity-30">☕</div>
                    <p class="text-gray-400 font-medium">Belum ada menu di kategori ini.</p>
                </div>

            </div>
        </div>
    @endsection
