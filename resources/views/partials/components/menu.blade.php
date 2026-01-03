@extends('partials.layouts.app')

@section('title', 'Daftar Menu - Access Coffee')

@section('content')
    <div class="min-h-screen bg-[#FDF9F3]" x-data="{ activeTab: 'Semua' }">

        <!-- HEADER SECTION -->
        <div class="bg-[#7a3939] pt-32 pb-20 rounded-b-[3rem] shadow-xl relative overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>
            <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
                <h1 class="font-serif text-4xl md:text-5xl font-bold text-white mb-4 uppercase tracking-tighter">Jelajahi Rasa Kami</h1>
                <p class="text-[#cc9966] text-lg max-w-2xl mx-auto font-medium">
                    Dari biji pilihan hingga sajian istimewa, temukan favoritmu di sini.
                </p>
            </div>
        </div>

        <!-- CONTENT SECTION -->
        <div class="max-w-7xl mx-auto px-4 -mt-10 relative z-20 pb-20">

            <!-- 1. TAB BUTTONS (DINAMIS DARI DATABASE) -->
            <div class="flex justify-center mb-12">
                <div class="bg-white p-2 rounded-full shadow-2xl border border-gray-100 inline-flex flex-wrap justify-center gap-2">

                    <button @click="activeTab = 'Semua'"
                        class="px-8 py-3 rounded-full text-xs font-black uppercase tracking-widest transition-all duration-300"
                        :class="activeTab === 'Semua' ? 'bg-[#7a3939] text-white shadow-lg scale-105' : 'text-gray-400 hover:bg-gray-50'">
                        Semua
                    </button>

                    @foreach($categories as $cat)
                    <button @click="activeTab = '{{ $cat->nama_kategori }}'"
                        class="px-8 py-3 rounded-full text-xs font-black uppercase tracking-widest transition-all duration-300"
                        :class="activeTab === '{{ $cat->nama_kategori }}' ? 'bg-[#7a3939] text-white shadow-lg scale-105' : 'text-gray-400 hover:bg-gray-50'">
                        {{ $cat->nama_kategori }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- 2. GRID MENU -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($menus as $menu)
                    @php
                        // Cari varian termurah untuk ditampilkan harganya
                        $cheapestVariant = $menu->variants->sortBy('harga')->first();
                        $hargaAsli = $cheapestVariant->harga ?? 0;
                        $hargaAkhir = $hargaAsli;

                        // Cek promo aktif untuk varian termurah ini
                        $promo = $cheapestVariant ? $cheapestVariant->promos->first() : null;
                        if ($promo) {
                            $diskon = $promo->jenis_promo == 'persen'
                                ? ($hargaAsli * $promo->nilai_diskon / 100)
                                : $promo->nilai_diskon;
                            $hargaAkhir = $hargaAsli - $diskon;
                        }
                    @endphp

                    <a href="{{ route('menu.show', $menu->slug) }}"
                        x-show="activeTab === 'Semua' || activeTab === '{{ $menu->category->nama_kategori }}'"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="bg-white rounded-[2.5rem] p-5 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group border border-gray-50 flex flex-col h-full relative">

                        <!-- Gambar -->
                        <div class="relative h-52 rounded-[2rem] overflow-hidden mb-5 bg-gray-100">
                            <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-700">

                            <!-- Badge Kategori -->
                            <span class="absolute top-3 left-3 bg-white/90 backdrop-blur text-[#7a3939] text-[9px] font-black px-3 py-1 rounded-full shadow-sm uppercase tracking-tighter">
                                {{ $menu->category->nama_kategori }}
                            </span>

                            <!-- Badge Promo -->
                            @if ($promo)
                                <div class="absolute top-3 right-3 bg-red-600 text-white text-[9px] font-black px-3 py-1 rounded-full shadow-md animate-pulse uppercase">
                                    Special Offer
                                </div>
                            @endif
                        </div>

                        <!-- Info Menu -->
                        <div class="flex-grow px-2 text-center">
                            <h3 class="font-serif text-xl font-bold text-gray-800 leading-tight mb-2 group-hover:text-[#7a3939] transition-colors uppercase tracking-tight">
                                {{ $menu->nama_menu }}
                            </h3>
                            <p class="text-[11px] text-gray-400 line-clamp-2 mb-4 italic leading-relaxed">
                                "{{ $menu->deskripsi ?? 'Racikan istimewa dari Access Coffee Station.' }}"
                            </p>
                        </div>

                        <!-- Harga & Footer -->
                        <div class="mt-auto pt-4 border-t border-gray-50 text-center">
                            <p class="text-[10px] text-gray-400 font-bold uppercase mb-1 tracking-widest">Mulai Dari</p>
                            <div class="flex flex-col items-center justify-center">
                                @if ($promo)
                                    <span class="text-xs text-gray-300 line-through font-bold">
                                        Rp {{ number_format($hargaAsli, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xl font-black text-[#7a3939]">
                                        Rp {{ number_format($hargaAkhir, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-xl font-black text-[#7a3939]">
                                        Rp {{ number_format($hargaAsli, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pesan Jika Kosong -->
            <div x-show="activeTab !== 'Semua' && !document.querySelector(`.grid a[x-show*='${activeTab}']`)"
                class="py-24 text-center">
                <div class="text-5xl mb-4 grayscale">☕</div>
                <p class="text-gray-400 font-black uppercase tracking-widest text-sm">Menu belum tersedia di kategori ini.</p>
            </div>

        </div>
    </div>
@endsection

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush
