@extends('partials.layouts.app')

@section('title', 'Tentang Kami - Access Coffee')

@section('content')
    <div class="bg-[#FDF9F3] overflow-x-hidden">

        <!-- ============================================== -->
        <!-- 1. HERO SECTION (Simple & Bold)                -->
        <!-- ============================================== -->
        <section class="relative pt-32 pb-20 px-4">
            <div class="max-w-7xl mx-auto text-center relative z-10">
                <span class="text-coffee-secondary font-bold tracking-[0.2em] uppercase text-sm mb-4 block animate-fade-in-up">
                    Siapa Kami
                </span>
                <h1 class="font-serif text-5xl md:text-7xl font-bold text-coffee-primary mb-6 leading-tight">
                    Lebih Dari Sekadar <br>
                    <span class="relative inline-block">
                        Secangkir Kopi.
                        <svg class="absolute w-full h-3 -bottom-1 left-0 text-coffee-secondary opacity-40" viewBox="0 0 100 10" preserveAspectRatio="none">
                            <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="8" fill="none" />
                        </svg>
                    </span>
                </h1>
                <p class="text-gray-500 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
                    Access Coffee hadir untuk menjembatani jarak antara kopi berkualitas tinggi dengan momen-momen berharga dalam hidup Anda.
                </p>
            </div>

            <!-- Background Decor -->
            <div class="absolute top-0 left-0 w-64 h-64 bg-coffee-primary/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-coffee-secondary/10 rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>
        </section>

        <!-- ============================================== -->
        <!-- 2. THE STORY (Asymmetrical Layout)             -->
        <!-- ============================================== -->
        <section class="py-20 px-4">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                <!-- Image Composition (Left) -->
                <div class="relative h-[500px] w-full hidden lg:block">
                    <!-- Gambar Belakang -->
                    <div class="absolute top-0 left-0 w-3/4 h-3/4 rounded-[3rem] overflow-hidden transform -rotate-3 border-4 border-white shadow-xl z-0">
                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover opacity-90">
                    </div>
                    <!-- Gambar Depan -->
                    <div class="absolute bottom-0 right-0 w-3/4 h-3/4 rounded-[3rem] overflow-hidden border-8 border-[#FDF9F3] shadow-2xl z-10">
                        <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover hover:scale-110 transition duration-700">
                    </div>
                    <!-- Badge -->
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-full shadow-xl z-20 animate-pulse-slow">
                        <div class="text-center">
                            <span class="block text-3xl font-bold text-coffee-primary">2024</span>
                            <span class="text-xs uppercase tracking-widest text-gray-400">Established</span>
                        </div>
                    </div>
                </div>

                <!-- Text Content (Right) -->
                <div class="space-y-8">
                    <h2 class="font-serif text-4xl font-bold text-coffee-primary">
                        Filosofi "Access"
                    </h2>
                    <div class="space-y-6 text-gray-600 text-lg leading-relaxed">
                        <p>
                            Nama <strong>Access Coffee</strong> tidak dipilih secara sembarangan. Kami percaya bahwa kopi enak seharusnya tidak eksklusif. Kopi enak adalah hak setiap orang.
                        </p>
                        <p>
                            Kami ingin menjadi <em>"akses"</em> Anda menuju ketenangan di tengah hiruk pikuk kota. Tempat di mana ide-ide besar lahir, persahabatan terjalin, dan rasa lelah terbayarkan oleh aroma Arabica lokal yang kami seduh dengan hati.
                        </p>
                    </div>

                    <!-- Signature / Quote -->
                    <div class="border-l-4 border-coffee-secondary pl-6 py-2 bg-white/50 rounded-r-xl">
                        <p class="font-serif italic text-coffee-dark text-xl">
                            "We brew memories, not just coffee beans."
                        </p>
                        <p class="text-sm text-gray-400 mt-2 font-bold uppercase tracking-wide">— Founder Access Coffee</p>
                    </div>

                    <!-- Image for Mobile Only -->
                    <div class="lg:hidden rounded-2xl overflow-hidden shadow-lg mt-8">
                        <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=800&q=80" class="w-full object-cover">
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================== -->
        <!-- 3. OUR VALUES (3 Grid Cards)                   -->
        <!-- ============================================== -->
        <section class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="font-serif text-4xl font-bold text-coffee-primary mb-4">Kenapa Kami Berbeda?</h2>
                    <div class="w-24 h-1 bg-coffee-secondary mx-auto rounded-full"></div>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Value 1 -->
                    <div class="group p-8 rounded-[2rem] bg-[#FDF9F3] hover:bg-coffee-primary hover:text-white transition-all duration-500 hover:-translate-y-2 cursor-default">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm group-hover:scale-110 transition duration-500 text-coffee-primary">
                            🌱
                        </div>
                        <h3 class="font-serif text-2xl font-bold mb-3 text-coffee-primary group-hover:text-white">Direct Trade</h3>
                        <p class="text-gray-500 group-hover:text-white/90 leading-relaxed">
                            Kami mengambil biji kopi langsung dari petani lokal di Jawa & Sumatera untuk memastikan kualitas terbaik dan kesejahteraan petani.
                        </p>
                    </div>

                    <!-- Value 2 -->
                    <div class="group p-8 rounded-[2rem] bg-[#FDF9F3] hover:bg-coffee-primary hover:text-white transition-all duration-500 hover:-translate-y-2 cursor-default">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm group-hover:scale-110 transition duration-500 text-coffee-primary">
                            🤝
                        </div>
                        <h3 class="font-serif text-2xl font-bold mb-3 text-coffee-primary group-hover:text-white">Community</h3>
                        <p class="text-gray-500 group-hover:text-white/90 leading-relaxed">
                            Lebih dari sekadar kedai kopi, kami adalah ruang untuk komunitas. Tempat nyaman untuk bekerja, berdiskusi, dan berkarya.
                        </p>
                    </div>

                    <!-- Value 3 -->
                    <div class="group p-8 rounded-[2rem] bg-[#FDF9F3] hover:bg-coffee-primary hover:text-white transition-all duration-500 hover:-translate-y-2 cursor-default">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm group-hover:scale-110 transition duration-500 text-coffee-primary">
                            ✨
                        </div>
                        <h3 class="font-serif text-2xl font-bold mb-3 text-coffee-primary group-hover:text-white">Quality First</h3>
                        <p class="text-gray-500 group-hover:text-white/90 leading-relaxed">
                            Setiap gram kopi ditimbang presisi, setiap detik ekstraksi dihitung. Kami tidak kompromi soal rasa demi kecepatan.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================== -->
        <!-- 4. GALLERY / AMBIENCE (Masonry Style)          -->
        <!-- ============================================== -->
        <section class="py-24 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                    <div>
                        <span class="text-coffee-secondary font-bold tracking-widest uppercase text-sm">Gallery</span>
                        <h2 class="font-serif text-4xl font-bold text-coffee-primary mt-2">Suasana di Access.</h2>
                    </div>
                    <a href="https://instagram.com" target="_blank" class="hidden md:inline-flex items-center gap-2 text-coffee-primary font-bold hover:text-coffee-secondary transition border-b-2 border-transparent hover:border-coffee-secondary pb-1">
                        Lihat Instagram Kami <span>→</span>
                    </a>
                </div>

                <!-- Grid Foto -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 h-[500px] md:h-[600px]">

                    <!-- Foto Besar Kiri -->
                    <div class="col-span-2 row-span-2 rounded-[2rem] overflow-hidden relative group">
                        <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition"></div>
                    </div>

                    <!-- Foto Kecil Atas -->
                    <div class="col-span-1 row-span-1 rounded-[2rem] overflow-hidden relative group">
                        <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    </div>

                    <!-- Foto Kecil Atas Kanan -->
                    <div class="col-span-1 row-span-1 rounded-[2rem] overflow-hidden relative group">
                        <img src="https://images.unsplash.com/photo-1511537632536-b7a7277154fb?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    </div>

                    <!-- Foto Panjang Bawah -->
                    <div class="col-span-2 row-span-1 rounded-[2rem] overflow-hidden relative group">
                        <img src="https://images.unsplash.com/photo-1445116572660-236099ec97a0?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================== -->
        <!-- 5. CTA (Call to Action)                        -->
        <!-- ============================================== -->
        <section class="py-20 px-4">
            <div class="max-w-5xl mx-auto bg-coffee-primary rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl shadow-coffee-primary/30">
                <!-- Decorative Pattern -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-coffee-secondary/10 rounded-full blur-3xl -translate-x-1/2 translate-y-1/2"></div>

                <div class="relative z-10">
                    <h2 class="font-serif text-3xl md:text-5xl font-bold text-white mb-6">
                        Mari Berbincang Sambil Ngopi.
                    </h2>
                    <p class="text-white/80 text-lg mb-10 max-w-2xl mx-auto">
                        Pintu kami selalu terbuka untuk Anda. Datanglah, rasakan suasananya, dan nikmati kopi terbaik hari ini.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('menu') }}" class="px-8 py-4 bg-coffee-secondary text-coffee-primary font-bold rounded-full hover:bg-white transition shadow-lg hover:scale-105 transform duration-300">
                            Lihat Menu Kami
                        </a>
                        <a href="{{ route('contact') }}" class="px-8 py-4 bg-transparent border-2 border-coffee-secondary text-coffee-secondary font-bold rounded-full hover:bg-coffee-secondary hover:text-coffee-primary transition">
                            Lihat Lokasi
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
