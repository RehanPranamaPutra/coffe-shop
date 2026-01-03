@extends('partials.layouts.app')

@section('title', $menu->nama_menu . ' - Access Coffee')

@section('content')
    <!-- x-data: Inisialisasi dengan varian pertama -->
    <div class="min-h-screen bg-[#FDF9F3] pt-28 pb-20"
         x-data="{
            selectedVariant: @js($menu->variants->first()),
            count: 1,
            calculatePrice(variant) {
                let hargaAsli = parseFloat(variant.harga);
                if (variant.promos && variant.promos.length > 0) {
                    let promo = variant.promos[0];
                    let diskon = promo.jenis_promo === 'persen' ? (hargaAsli * promo.nilai_diskon / 100) : promo.nilai_diskon;
                    return hargaAsli - diskon;
                }
                return hargaAsli;
            }
         }">

        <div class="max-w-7xl mx-auto px-4">

            <!-- BREADCRUMB -->
            <nav class="flex text-sm text-gray-500 mb-8">
                <a href="{{ route('home') }}" class="hover:text-[#7a3939] transition">Beranda</a>
                <span class="mx-2">/</span>
                <a href="{{ route('menu') }}" class="hover:text-[#7a3939] transition">Menu</a>
                <span class="mx-2">/</span>
                <span class="text-[#7a3939] font-bold">{{ $menu->nama_menu }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

                <!-- 1. LEFT COLUMN: IMAGE -->
                <div class="relative">
                    <div class="aspect-square rounded-[3rem] overflow-hidden bg-white shadow-2xl border border-gray-100 relative group">
                        <img src="{{ asset('storage/'.$menu->gambar) }}"
                             alt="{{ $menu->nama_menu }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-700">

                        <!-- Badge Promo (Hanya Muncul Jika Varian Terpilih Ada Promo) -->
                        <template x-if="selectedVariant.promos.length > 0">
                            <div class="absolute top-6 left-6 bg-red-600 text-white px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg animate-bounce">
                                Special Offer
                            </div>
                        </template>
                    </div>
                </div>

                <!-- 2. RIGHT COLUMN: INFO -->
                <div class="space-y-8">
                    <div>
                        <span class="text-[#cc9966] font-black uppercase text-xs tracking-[0.3em] mb-2 block">
                            {{ $menu->category->nama_kategori }}
                        </span>
                        <h1 class="font-serif text-4xl md:text-5xl font-bold text-[#7a3939] mb-4 uppercase tracking-tighter">
                            {{ $menu->nama_menu }}
                        </h1>

                        <!-- Dynamic Price Display -->
                        <div class="flex items-end gap-3">
                            <span class="text-4xl font-black text-[#7a3939]"
                                  x-text="'Rp ' + calculatePrice(selectedVariant).toLocaleString('id-ID')">
                            </span>
                            <template x-if="selectedVariant.promos.length > 0">
                                <span class="text-xl text-gray-300 line-through font-bold mb-1"
                                      x-text="'Rp ' + parseInt(selectedVariant.harga).toLocaleString('id-ID')">
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- VARIANT SELECTOR (Kunci Utama) -->
                    <div>
                        <h3 class="font-black text-[#7a3939] uppercase text-xs tracking-widest mb-4">Pilih Variasi:</h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($menu->variants as $variant)
                                <button @click="selectedVariant = @js($variant); count = 1"
                                        class="px-6 py-3 rounded-2xl border-2 font-bold transition-all duration-300 text-sm"
                                        :class="selectedVariant.id === {{ $variant->id }}
                                                ? 'bg-[#7a3939] border-[#7a3939] text-white shadow-xl scale-105'
                                                : 'bg-white border-gray-100 text-gray-400 hover:border-[#cc9966]'">
                                    {{ $variant->nama_variasi }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Meta Info (Dinamis Berdasarkan Stok Varian) -->
                    <div class="flex gap-6">
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-50 flex items-center gap-3">
                            <div class="p-2 bg-emerald-50 rounded-xl text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="2"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase">Stok</p>
                                <p class="font-black text-gray-800" x-text="selectedVariant.stok + ' Tersedia'"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Area -->
                   

                    <div>
                        <h3 class="font-black text-[#7a3939] uppercase text-xs tracking-widest mb-2">Deskripsi Produk</h3>
                        <p class="text-gray-500 leading-relaxed italic text-sm">
                            "{{ $menu->deskripsi ?? 'Nikmati kesempurnaan rasa dari biji kopi pilihan yang diproses dengan dedikasi tinggi oleh barista kami.' }}"
                        </p>
                    </div>
                </div>
            </div>

            <!-- RELATED MENU -->
            @if($relatedMenus->count() > 0)
                <div class="mt-32">
                    <h2 class="font-serif text-3xl font-bold text-[#7a3939] mb-10 uppercase tracking-tighter">Mungkin Kamu Juga Suka</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($relatedMenus as $related)
                            @php $minPrice = $related->variants->min('harga'); @endphp
                            <a href="{{ route('menu.show', $related->slug) }}" class="group bg-white p-5 rounded-[2rem] shadow-sm hover:shadow-2xl transition-all duration-500 border border-transparent hover:border-[#cc9966]/20">
                                <div class="h-48 rounded-[1.5rem] overflow-hidden mb-4 bg-gray-50">
                                    <img src="{{ asset('storage/'.$related->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                </div>
                                <h3 class="font-black text-gray-800 uppercase text-xs truncate group-hover:text-[#7a3939] transition-colors">
                                    {{ $related->nama_menu }}
                                </h3>
                                <p class="text-[10px] text-[#cc9966] font-bold mt-1 uppercase tracking-widest">
                                    Mulai Rp {{ number_format($minPrice, 0, ',', '.') }}
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
