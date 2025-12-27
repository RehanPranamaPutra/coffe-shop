@extends('partials.layouts.app')

@section('title', 'Hubungi Kami')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-16 grid md:grid-cols-2 gap-16">

        <!-- Info -->
        <div>
            <h2 class="font-serif text-4xl font-bold text-coffee-primary mb-6">Mari Terhubung</h2>
            <p class="text-gray-500 mb-8">Punya pertanyaan seputar kopi, kemitraan, atau sekadar ingin menyapa? Kami siap mendengar.</p>

            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-coffee-gray flex items-center justify-center text-coffee-primary">
                        <i class="fas fa-map-marker-alt"></i> <!-- Icon Placeholder -->
                        📍
                    </div>
                    <div>
                        <h4 class="font-bold text-coffee-dark">Lokasi</h4>
                        <p class="text-gray-500 text-sm">Jl. Akses Bandara Internasional Minangkabau No.9, Katapiang, Kec. Batang Anai, Kabupaten Padang Pariaman, Sumatera Barat 25586</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-coffee-gray flex items-center justify-center text-coffee-primary">
                        📞
                    </div>
                    <div>
                        <h4 class="font-bold text-coffee-dark">Telepon</h4>
                        <p class="text-gray-500 text-sm">+62 812-7056-2674</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form (Visual Only) -->
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
            <form>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                    <input type="text" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-coffee-secondary/50 focus:border-coffee-secondary transition outline-none" placeholder="Nama Anda">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                    <textarea rows="4" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-coffee-secondary/50 focus:border-coffee-secondary transition outline-none" placeholder="Tulis pesan..."></textarea>
                </div>
                <button class="w-full py-3 bg-coffee-primary text-white rounded-xl font-bold hover:bg-opacity-90 transition">
                    Kirim Pesan
                </button>
            </form>
        </div>
    </div>
@endsection
