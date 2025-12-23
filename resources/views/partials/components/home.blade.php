@extends('partials.layouts.app')

@section('title', 'Access Coffee - Unlock the True Taste')

@section('content')

    <!-- ============================================================ -->
    <!-- SECTION 1: HERO (Code Pilihan Anda) -->
    <!-- ============================================================ -->
    <section class="relative min-h-[80vh] flex items-center bg-coffee-gray overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 w-full grid md:grid-cols-2 gap-12 items-center">

            <!-- Text -->
            <div class="order-2 md:order-1 space-y-6">
                <span class="text-coffee-secondary font-bold tracking-widest text-xs uppercase">Premium Coffee Beans</span>
                <h1 class="font-serif text-5xl md:text-6xl font-bold text-coffee-primary leading-tight">
                    Awali Harimu dengan <br>
                    <span class="relative inline-block">
                        Rasa Terbaik
                        <!-- Garis bawah estetik -->
                        <span class="absolute bottom-1 left-0 w-full h-3 bg-coffee-secondary/30 -z-10"></span>
                    </span>
                </h1>
                <p class="text-gray-500 text-lg leading-relaxed max-w-md">
                    Tempat di mana kenyamanan bertemu dengan kualitas rasa. Nikmati setiap tegukan dari biji kopi pilihan
                    lokal.
                </p>
                <div class="pt-4">
                    <a href="{{ route('menu') }}"
                        class="inline-block px-8 py-3 bg-coffee-primary text-white rounded-full font-medium hover:bg-opacity-90 transition shadow-lg shadow-coffee-primary/20">
                        Lihat Menu Kami
                    </a>
                </div>
            </div>

            <!-- Image (Clean Shape) -->
            <div class="order-1 md:order-2 flex justify-end relative">
                <div class="relative w-full max-w-md aspect-square bg-gray-200 rounded-[3rem] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=800&q=80"
                        alt="Coffee" class="object-cover w-full h-full hover:scale-105 transition duration-700">
                </div>
                <!-- Badge Floating -->
                <div
                    class="absolute bottom-10 -left-6 bg-white p-4 rounded-xl shadow-xl border-l-4 border-coffee-secondary max-w-xs">
                    <p class="text-coffee-primary font-bold text-lg">100% Arabica & Robusta</p>
                    <p class="text-xs text-gray-500">Dipetik langsung dari petani lokal.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- SECTION 2: VALUE PROPOSITION (Bersih & Informatif) -->
    <!-- ============================================================ -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-coffee-secondary font-bold uppercase tracking-wider text-xs">Why Access Coffee?</span>
                <h2 class="font-serif text-3xl md:text-4xl font-bold text-coffee-primary mt-2">More Than Just a Coffee Cup
                </h2>
                <p class="text-gray-500 mt-4">Kami percaya kopi adalah jembatan untuk inspirasi. Inilah mengapa Access
                    Coffee berbeda.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div
                    class="group p-8 rounded-[2rem] bg-[#FDF9F3] border border-transparent hover:border-coffee-secondary/50 hover:bg-white hover:shadow-xl transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-md mb-6 text-2xl group-hover:scale-110 transition text-coffee-primary">
                        🌱</div>
                    <h3 class="font-serif text-xl font-bold text-coffee-primary mb-3">Direct Trade Beans</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Kami mengambil biji kopi langsung dari petani lokal terpilih untuk memastikan kesegaran dan
                        kesejahteraan petani.
                    </p>
                </div>

                <!-- Card 2 -->
                <div
                    class="group p-8 rounded-[2rem] bg-[#FDF9F3] border border-transparent hover:border-coffee-secondary/50 hover:bg-white hover:shadow-xl transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-md mb-6 text-2xl group-hover:scale-110 transition text-coffee-primary">
                        ✨</div>
                    <h3 class="font-serif text-xl font-bold text-coffee-primary mb-3">Premium Ambience</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Desain interior modern dan playlist lagu terkurasi, menciptakan suasana sempurna untuk bekerja atau
                        bersantai.
                    </p>
                </div>

                <!-- Card 3 -->
                <div
                    class="group p-8 rounded-[2rem] bg-[#FDF9F3] border border-transparent hover:border-coffee-secondary/50 hover:bg-white hover:shadow-xl transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-md mb-6 text-2xl group-hover:scale-110 transition text-coffee-primary">
                        🚀</div>
                    <h3 class="font-serif text-xl font-bold text-coffee-primary mb-3">Fast Access</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Pesan lewat website, ambil di toko, atau nikmati layanan antar. Kami menghargai waktu berharga Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- SECTION 3: MENU HIGHLIGHT (Estetik & Menggugah Selera) -->
    <!-- ============================================================ -->
    <section class="py-24 bg-[#FAFAFA] relative">
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div>
                    <h2 class="font-serif text-4xl font-bold text-coffee-primary uppercase tracking-tight">Our Signature
                    </h2>
                    <div class="h-1.5 w-20 bg-coffee-secondary mt-3 rounded-full"></div>
                </div>
                <a href="{{ route('menu') }}"
                    class="text-coffee-primary font-bold hover:text-coffee-secondary transition flex items-center gap-2 group">
                    Lihat Menu Lengkap <span class="group-hover:translate-x-1 transition">→</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($signatureMenus as $menu)
                    @php
                        $promo = $menu->activePromo; // Menggunakan relasi hasOne yang kita buat sebelumnya
                        $hargaAsli = $menu->harga;
                        $hargaAkhir = $hargaAsli;

                        if ($promo) {
                            if ($promo->jenis_promo == 'persen') {
                                $hargaAkhir = $hargaAsli - $hargaAsli * ($promo->nilai_diskon / 100);
                            } else {
                                $hargaAkhir = $hargaAsli - $promo->nilai_diskon;
                            }
                        }
                    @endphp

                    <div
                        class="bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-xl transition-all duration-500 group border border-gray-100">
                        <!-- Image Wrapper -->
                        <div class="h-56 rounded-[1.5rem] overflow-hidden relative mb-5">
                            <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-700">

                            <!-- Badge Logika -->
                            @if ($promo)
                                <div
                                    class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-black px-3 py-1.5 rounded-full shadow-lg animate-pulse">
                                    SPECIAL PROMO
                                </div>
                            @else
                                <div
                                    class="absolute top-3 left-3 bg-coffee-primary/80 backdrop-blur-sm text-coffee-secondary text-[10px] font-black px-3 py-1.5 rounded-full shadow-lg">
                                    BEST SELLER
                                </div>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="px-2">
                            <span
                                class="text-[10px] font-bold text-coffee-secondary uppercase tracking-[0.2em]">{{ $menu->kategori }}</span>
                            <h3 class="font-serif text-xl font-bold text-coffee-primary mb-2 mt-1">{{ $menu->nama_menu }}
                            </h3>
                            <p class="text-gray-400 text-xs mb-5 line-clamp-2 leading-relaxed italic">
                                "{{ $menu->deskripsi }}"</p>

                            <div class="flex justify-between items-center pt-4 border-t border-gray-50">
                                <div>
                                    @if ($promo)
                                        <span class="block text-[10px] text-gray-400 line-through tracking-wider">Rp
                                            {{ number_format($hargaAsli, 0, ',', '.') }}</span>
                                        <span class="text-lg font-bold text-coffee-dark font-serif">Rp
                                            {{ number_format($hargaAkhir, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-lg font-bold text-coffee-dark font-serif">Rp
                                            {{ number_format($hargaAsli, 0, ',', '.') }}</span>
                                    @endif
                                </div>

                                <!-- Tombol Tambah Minimalis -->
                                <button
                                    class="w-10 h-10 rounded-xl bg-coffee-primary text-coffee-secondary flex items-center justify-center hover:bg-coffee-secondary hover:text-coffee-primary transition-all duration-300 shadow-lg shadow-coffee-primary/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- ============================================================ -->
    <!-- SECTION 4: STORY (Tentang Access Coffee) -->
    <!-- ============================================================ -->
    <section id="story" class="py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Image Grid -->
                <div class="relative">
                    <div class="absolute -top-10 -left-10 w-40 h-40 bg-coffee-secondary/20 rounded-full blur-2xl"></div>
                    <div class="grid grid-cols-2 gap-4 relative z-10">
                        <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?w=500&q=80"
                            class="rounded-[20px] w-full h-64 object-cover transform translate-y-8 shadow-xl">
                        <img src="https://images.unsplash.com/photo-1507133750069-bef72f3707a9?w=500&q=80"
                            class="rounded-[20px] w-full h-64 object-cover shadow-xl">
                    </div>
                </div>

                <!-- Text Content -->
                <div>
                    <h2 class="font-serif text-4xl font-bold text-coffee-primary mb-6">
                        Making Coffee <br>
                        <span class="text-coffee-secondary">Accessible</span> to Everyone.
                    </h2>
                    <p class="text-gray-500 mb-6 leading-relaxed">
                        Nama <strong>"Access"</strong> lahir dari keinginan kami untuk membuat kopi berkualitas tinggi bisa
                        diakses oleh siapa saja. Tanpa istilah rumit, tanpa pretensi. Hanya kopi enak, tempat nyaman, dan
                        pelayanan hangat.
                    </p>
                    <p class="text-gray-500 mb-8 leading-relaxed">
                        Setiap cangkir yang kami sajikan adalah hasil kurasi ketat dari biji kopi lokal Indonesia, disangrai
                        dengan presisi untuk mengeluarkan karakter rasa terbaiknya.
                    </p>

                    <a href="{{ route('about') }}"
                        class="inline-block border-b-2 border-coffee-primary pb-1 text-coffee-primary font-bold hover:text-coffee-secondary hover:border-coffee-secondary transition">
                        Baca Cerita Lengkap Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- SECTION 5: CALL TO ACTION (Clean & Strong) -->
    <!-- ============================================================ -->
    <section class="py-20 px-4 mb-10">
        <div
            class="max-w-6xl mx-auto bg-coffee-primary rounded-[3rem] p-10 md:p-16 text-center relative overflow-hidden shadow-2xl shadow-coffee-primary/30">
            <!-- Background Pattern -->
            <div class="absolute top-0 left-0 w-full h-full opacity-5"
                style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>

            <div class="relative z-10">
                <h2 class="font-serif text-3xl md:text-5xl font-bold text-white mb-6">Siap untuk Rasa yang Baru?</h2>
                <p class="text-white/80 text-lg mb-10 max-w-xl mx-auto">
                    Kunjungi Access Coffee hari ini atau pesan online untuk mendapatkan pengalaman kopi terbaik di kotamu.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('menu') }}"
                        class="px-8 py-4 bg-coffee-secondary text-coffee-primary font-bold rounded-full hover:bg-white hover:scale-105 transition shadow-lg">
                        Lihat Menu Lengkap
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
