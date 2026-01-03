@extends('layouts.app')

@section('title', 'Buat Promo Baru')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('promo.index') }}" class="text-[#cc9966] text-sm font-bold flex items-center gap-1 mb-2">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2"/></svg> Kembali
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Buat Promo Baru</h2>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <form action="{{ route('promo.store') }}" method="POST" class="p-8 space-y-5">
            @csrf

            <!-- Pilih Varian Menu -->
            <div>
                <label class="block text-xs font-bold text-[#7a3939] uppercase mb-2">Pilih Menu & Variasi</label>
                <select name="menu_variant_id" required class="w-full border-gray-200 rounded-xl focus:ring-[#cc9966] focus:border-[#cc9966] text-sm">
                    <option value="">-- Pilih Menu (Variasi Harga) --</option>
                    @foreach($variants as $variant)
                        <option value="{{ $variant->id }}">
                            {{ $variant->menu->nama_menu }} - {{ $variant->nama_variasi }} (Rp {{ number_format($variant->harga) }})
                        </option>
                    @endforeach
                </select>
                @error('menu_variant_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Jenis Promo -->
                <div>
                    <label class="block text-xs font-bold text-[#7a3939] uppercase mb-2">Jenis Promo</label>
                    <select name="jenis_promo" required class="w-full border-gray-200 rounded-xl focus:ring-[#cc9966] focus:border-[#cc9966] text-sm">
                        <option value="persen">Persentase (%)</option>
                        <option value="nominal">Potongan Harga (Rp)</option>
                    </select>
                </div>
                <!-- Nilai Diskon -->
                <div>
                    <label class="block text-xs font-bold text-[#7a3939] uppercase mb-2">Nilai Diskon</label>
                    <input type="number" name="nilai_diskon" required placeholder="Contoh: 10 atau 5000"
                           class="w-full border-gray-200 rounded-xl focus:ring-[#cc9966] focus:border-[#cc9966] text-sm">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Tanggal Mulai -->
                <div>
                    <label class="block text-xs font-bold text-[#7a3939] uppercase mb-2">Tanggal Mulai</label>
                    <input type="datetime-local" name="tanggal_mulai" required
                           class="w-full border-gray-200 rounded-xl focus:ring-[#cc9966] focus:border-[#cc9966] text-sm">
                </div>
                <!-- Tanggal Selesai -->
                <div>
                    <label class="block text-xs font-bold text-[#7a3939] uppercase mb-2">Tanggal Selesai</label>
                    <input type="datetime-local" name="tanggal_selesai" required
                           class="w-full border-gray-200 rounded-xl focus:ring-[#cc9966] focus:border-[#cc9966] text-sm">
                </div>
            </div>

            <button type="submit" class="w-full bg-[#7a3939] hover:bg-[#5a2a2a] text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-lg transition-all transform active:scale-95">
                Simpan & Aktifkan Promo
            </button>
        </form>
    </div>
</div>
@endsection
