@extends('partials.layouts.app')

@section('title', 'Promo Spesial')

@section('content')
    <div class="bg-coffee-gray py-16 min-h-screen">
        <div class="max-w-5xl mx-auto px-4">
            <h2 class="font-serif text-3xl font-bold text-coffee-primary mb-8 text-center">Promo Bulan Ini</h2>

            <div class="space-y-6">
                @foreach($promos as $promo)
                <!-- Promo Card (Horizontal Layout) -->
                <div class="bg-white rounded-2xl p-6 flex flex-col md:flex-row gap-6 items-center shadow-sm hover:shadow-md transition border border-transparent hover:border-coffee-secondary/30">
                    <div class="w-full md:w-48 h-32 flex-shrink-0">
                        <img src="{{ asset('storage/'.$promo->menu->gambar) }}" class="w-full h-full object-cover rounded-xl" alt="Promo">
                    </div>

                    <div class="flex-grow text-center md:text-left">
                        <div class="inline-block bg-red-50 text-red-600 text-xs font-bold px-2 py-1 rounded mb-2">
                            Berakhir: {{ \Carbon\Carbon::parse($promo->tanggal_selesai)->format('d M Y') }}
                        </div>
                        <h3 class="font-serif text-xl font-bold text-coffee-primary">{{ $promo->menu->nama_menu }}</h3>
                        <p class="text-gray-500 text-sm mt-1 mb-3">Dapatkan potongan harga spesial untuk menu favorit ini.</p>

                        <div class="flex items-center justify-center md:justify-start gap-3">
                            <span class="text-2xl font-bold text-coffee-secondary">
                                @if($promo->jenis_promo == 'persen')
                                    Diskon {{ (int)$promo->nilai_diskon }}%
                                @else
                                    Potongan Rp {{ number_format($promo->nilai_diskon, 0, ',', '.') }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('menu') }}" class="px-6 py-3 rounded-full border border-coffee-primary text-coffee-primary font-medium hover:bg-coffee-primary hover:text-white transition">
                            Ambil Promo
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
