@extends('partials.layouts.app')

@section('title', 'Hubungi Kami - Access Coffee')

@section('content')
    <!-- HEADER SECTION -->
    <section class="pt-20 pb-10 bg-coffee-gray/30">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <span class="text-coffee-secondary font-bold uppercase tracking-widest text-xs">Contact Us</span>
            <h1 class="font-serif text-5xl md:text-6xl font-bold text-coffee-primary mt-4">Mari Terhubung</h1>
            <p class="text-gray-500 mt-6 text-lg max-w-2xl mx-auto">
                Punya pertanyaan seputar kopi, kemitraan, atau sekadar ingin menyapa? Kami selalu siap menyambut Anda di
                Access Coffee Station.
            </p>
        </div>
    </section>

    <!-- CONTACT CARDS SECTION -->
    <section class="py-16 bg-white relative">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-3 gap-8">

                <!-- Card 1: Lokasi -->
                <div
                    class="group p-10 rounded-[2.5rem] bg-[#FDF9F3] border border-transparent hover:border-coffee-secondary/30 hover:bg-white hover:shadow-2xl transition-all duration-500">
                    <div
                        class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-8 group-hover:scale-110 group-hover:bg-coffee-primary group-hover:text-white transition-all duration-500 text-3xl">
                        📍
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-coffee-primary mb-4">Lokasi Kami</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Jl. Akses Bandara Internasional Minangkabau No.9, Katapiang, Kab. Padang Pariaman, Sumatera Barat
                        25586
                    </p>
                    <div class="mt-8">
                        <a href="https://maps.app.goo.gl/8FPyGxHvjfoKbgSg7" target="_blank"
                            class="text-coffee-secondary font-bold text-sm border-b-2 border-coffee-secondary/20 hover:border-coffee-secondary transition pb-1">
                            Petunjuk Jalan →
                        </a>
                    </div>
                </div>

                <!-- Card 2: Kontak Langsung -->
                <div
                    class="group p-10 rounded-[2.5rem] bg-[#FDF9F3] border border-transparent hover:border-coffee-secondary/30 hover:bg-white hover:shadow-2xl transition-all duration-500">
                    <div
                        class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-8 group-hover:scale-110 group-hover:bg-coffee-primary group-hover:text-white transition-all duration-500 text-3xl">
                        📞
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-coffee-primary mb-4">Kontak</h3>
                    <p class="text-gray-500 leading-relaxed text-sm mb-2">
                        <strong>WhatsApp:</strong> +62 812-7056-2674
                    </p>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        <strong>Email:</strong> hello@accesscoffee.id
                    </p>
                    <div class="mt-8">
                        <a href="https://wa.me/6281270562674"
                            class="inline-flex items-center gap-2 bg-emerald-500 text-white px-6 py-3 rounded-full font-bold text-sm hover:bg-emerald-600 transition shadow-lg shadow-emerald-500/20">
                            Chat via WhatsApp
                        </a>
                    </div>
                </div>

                <!-- Card 3: Jam Operasional -->
                <div
                    class="group p-10 rounded-[2.5rem] bg-[#FDF9F3] border border-transparent hover:border-coffee-secondary/30 hover:bg-white hover:shadow-2xl transition-all duration-500">
                    <div
                        class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-8 group-hover:scale-110 group-hover:bg-coffee-primary group-hover:text-white transition-all duration-500 text-3xl">
                        🕒
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-coffee-primary mb-4">Jam Buka</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between text-gray-500">
                            <span>Senin - Jumat</span>
                            <span class="font-bold text-coffee-primary">09:00 - 22:00</span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span>Sabtu - Minggu</span>
                            <span class="font-bold text-coffee-primary">10:00 - 23:00</span>
                        </div>
                    </div>
                    <p class="mt-6 text-[10px] text-orange-400 font-bold uppercase tracking-widest italic">
                        *Waktu dapat berubah saat hari libur nasional
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- GOOGLE MAPS SECTION -->
    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Frame Peta dengan Border Estetik -->
            <div
                class="w-full h-[500px] rounded-[3rem] overflow-hidden shadow-2xl border-8 border-coffee-gray/20 relative group">

                <!-- Badge Petunjuk di Atas Peta -->
                <div
                    class="absolute top-6 left-6 z-10 bg-white/90 backdrop-blur-md px-5 py-3 rounded-2xl shadow-lg border border-coffee-secondary/20 transition-all group-hover:-translate-y-2">
                    <p class="text-[10px] font-black uppercase tracking-widest text-coffee-secondary mb-1">Lokasi Kami</p>
                    <p class="text-sm font-bold text-coffee-primary">Access Coffee Station - BIM</p>
                </div>

                <!-- Iframe Google Maps Asli -->
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.3758362649363!2d100.30596397435198!3d-0.7885440352932906!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b8aef459954d%3A0x6b2e3f5f68b75f8a!2sAccess%20Coffee!5e0!3m2!1sid!2sid!4v1710000000000!5m2!1sid!2sid"
                    class="w-full h-full border-0 grayscale hover:grayscale-0 transition-all duration-700 ease-in-out"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>

                <!-- Overlay Klik untuk Navigasi Mobile -->
                <a href="https://maps.app.goo.gl/8FPyGxHvjfoKbgSg7" target="_blank"
                    class="absolute bottom-6 right-6 bg-coffee-primary text-white px-6 py-3 rounded-2xl font-bold text-xs shadow-xl hover:bg-coffee-secondary hover:text-coffee-primary transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Buka di Google Maps
                </a>
            </div>
        </div>
    </section>
    <!-- SOCIAL MEDIA FOOTER -->
    <section class="py-20 text-center">
        <h2 class="font-serif text-2xl font-bold text-coffee-primary mb-8">Ikuti Perjalanan Kami</h2>
        <div class="flex justify-center gap-6">
            <a href="#"
                class="w-14 h-14 rounded-2xl bg-coffee-primary text-coffee-secondary flex items-center justify-center text-xl hover:scale-110 hover:-rotate-6 transition-all shadow-xl">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="#"
                class="w-14 h-14 rounded-2xl bg-coffee-primary text-coffee-secondary flex items-center justify-center text-xl hover:scale-110 hover:rotate-6 transition-all shadow-xl">
                <i class="fab fa-tiktok"></i>
            </a>
            <a href="#"
                class="w-14 h-14 rounded-2xl bg-coffee-primary text-coffee-secondary flex items-center justify-center text-xl hover:scale-110 hover:-rotate-6 transition-all shadow-xl">
                <i class="fab fa-facebook-f"></i>
            </a>
        </div>
    </section>
@endsection
