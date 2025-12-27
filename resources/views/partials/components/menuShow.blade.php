@extends('partials.layouts.app')

@section('title', $menu->nama_menu . ' - Access Coffee')

@section('content')
    <!-- x-data untuk mengatur jumlah pesanan -->
    <div class="min-h-screen bg-[#FDF9F3] pt-28 pb-20" x-data="{ count: 1, maxStok: {{ $menu->stok }} }">

        <div class="max-w-7xl mx-auto px-4">

            <!-- BREADCRUMB (Navigasi Kecil) -->
            <nav class="flex text-sm text-gray-500 mb-8 animate-fade-in-down">
                <a href="{{ route('home') }}" class="hover:text-coffee-primary transition">Beranda</a>
                <span class="mx-2">/</span>
                <a href="{{ route('menu') }}" class="hover:text-coffee-primary transition">Menu</a>
                <span class="mx-2">/</span>
                <span class="text-coffee-primary font-bold">{{ $menu->nama_menu }}</span>
            </nav>

            <!-- MAIN CONTENT GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

                <!-- 1. LEFT COLUMN: IMAGE GALLERY -->
                <div class="relative">
                    <div class="aspect-square rounded-[2.5rem] overflow-hidden bg-white shadow-xl border border-coffee-secondary/20 relative group">
                        <img src="{{ asset('storage/'.$menu->gambar) }}"
                             alt="{{ $menu->nama_menu }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-700">

                        <!-- Badges -->
                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            <!-- Kategori -->
                            <span class="bg-white/90 backdrop-blur text-coffee-primary px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm">
                                {{ $menu->kategori }}
                            </span>

                            <!-- Promo -->
                            @if($menu->activePromo)
                                <span class="bg-red-500 text-white px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm animate-pulse">
                                    {{ $menu->label_diskon }} OFF
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Decorative Blob -->
                    <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-coffee-secondary/20 rounded-full blur-3xl -z-10"></div>
                </div>

                <!-- 2. RIGHT COLUMN: PRODUCT INFO -->
                <div class="space-y-8 lg:sticky lg:top-32">

                    <!-- Title & Price -->
                    <div class="border-b border-coffee-primary/10 pb-6">
                        <h1 class="font-serif text-4xl md:text-5xl font-bold text-coffee-primary mb-4 leading-tight">
                            {{ $menu->nama_menu }}
                        </h1>

                        <div class="flex items-center gap-4">
                            @if($menu->activePromo)
                                <span class="text-3xl font-bold text-red-600">
                                    Rp {{ number_format($menu->harga_akhir, 0, ',', '.') }}
                                </span>
                                <span class="text-lg text-gray-400 line-through decoration-red-500/50">
                                    Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-3xl font-bold text-coffee-dark">
                                    Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <h3 class="font-bold text-coffee-primary mb-2 text-lg">Deskripsi</h3>
                        <p class="text-gray-500 leading-relaxed text-lg">
                            {{ $menu->deskripsi }}
                        </p>
                    </div>

                    <!-- Meta Info (Stok & Terjual) -->
                    <div class="flex gap-6">
                        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-xl border border-gray-100 shadow-sm">
                            <span class="text-xl">📦</span>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">Stok</p>
                                <p class="font-bold {{ $menu->stok < 5 ? 'text-red-500' : 'text-coffee-dark' }}">
                                    {{ $menu->stok }} Tersedia
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-xl border border-gray-100 shadow-sm">
                            <span class="text-xl">🔥</span>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">Terjual</p>
                                <p class="font-bold text-coffee-dark">
                                    {{ $menu->total_terjual ?? 0 }} Porsi
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- <!-- ACTION AREA (Alpine Logic) -->
                    @if($menu->status == 'Tersedia' && $menu->stok > 0)
                        <div class="pt-4 space-y-4">
                            <!-- Quantity Selector -->
                            <div class="flex items-center gap-4">
                                <span class="font-bold text-coffee-primary">Jumlah:</span>
                                <div class="flex items-center bg-white border-2 border-coffee-primary/10 rounded-full p-1 shadow-sm">
                                    <button @click="if(count > 1) count--"
                                            class="w-10 h-10 rounded-full hover:bg-coffee-secondary/20 text-coffee-primary flex items-center justify-center transition text-xl font-bold">
                                        -
                                    </button>
                                    <input type="text" x-model="count" readonly
                                           class="w-12 text-center bg-transparent font-bold text-coffee-dark outline-none">
                                    <button @click="if(count < maxStok) count++"
                                            class="w-10 h-10 rounded-full bg-coffee-primary text-white flex items-center justify-center hover:bg-coffee-primary/90 transition text-xl font-bold shadow-md">
                                        +
                                    </button>
                                </div>
                                <span class="text-xs text-red-500 font-medium" x-show="count >= maxStok" style="display: none;">
                                    *Maksimal stok tercapai
                                </span>
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-4">
                                <button class="flex-1 bg-white border-2 border-coffee-primary text-coffee-primary py-4 rounded-2xl font-bold hover:bg-coffee-secondary/10 transition flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    Masuk Keranjang
                                </button>
                                <button class="flex-1 bg-coffee-primary text-white py-4 rounded-2xl font-bold hover:bg-[#6d3333] transition shadow-lg shadow-coffee-primary/20 flex items-center justify-center gap-2">
                                    Pesan Sekarang
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Sold Out State -->
                        <div class="bg-gray-100 p-6 rounded-2xl text-center border border-gray-200">
                            <span class="text-3xl block mb-2">🚫</span>
                            <h3 class="font-bold text-gray-500 text-lg">Maaf, Stok Habis</h3>
                            <p class="text-sm text-gray-400">Silakan cek kembali nanti.</p>
                        </div>
                    @endif --}}

                </div>
            </div>

            <!-- ====================================== -->
            <!-- 3. RELATED MENU SECTION                -->
            <!-- ====================================== -->
            @if($relatedMenus->count() > 0)
                <div class="mt-24 border-t border-coffee-primary/5 pt-16">
                    <h2 class="font-serif text-3xl font-bold text-coffee-primary mb-8">Mungkin Anda juga suka</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedMenus as $related)
                            <a href="{{ route('menu.show', $related->slug) }}" class="group bg-white p-4 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                                <div class="h-40 rounded-xl overflow-hidden bg-gray-100 mb-4">
                                    <img src="{{ asset('storage/'.$related->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                </div>
                                <h3 class="font-bold text-coffee-primary line-clamp-1 group-hover:text-coffee-secondary transition">
                                    {{ $related->nama_menu }}
                                </h3>
                                <p class="text-sm text-gray-400 mt-1">Rp {{ number_format($related->harga, 0, ',', '.') }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
