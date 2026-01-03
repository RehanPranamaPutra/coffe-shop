@extends('layouts.app')

@section('title', 'Edit Promo')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('promo.index') }}" class="text-[#cc9966] text-sm font-bold flex items-center gap-1 mb-2">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2"/></svg> Kembali ke Daftar
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Edit Promo</h2>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <form action="{{ route('promo.update', $promo->id) }}" method="POST" class="p-8 space-y-5">
            @csrf
            @method('PUT')

            <!-- Pilih Varian Menu -->
            <div>
                <label class="block text-xs font-bold text-[#7a3939] uppercase mb-2">Pilih Menu & Variasi</label>
                <select name="menu_variant_id" required class="w-full border-gray-200 rounded-xl focus:ring-[#cc9966] focus:border-[#cc9966] text-sm">
                    @foreach($variants as $variant)
                        <option value="{{ $variant->id }}" {{ $promo->menu_variant_id == $variant->id ? 'selected' : '' }}>
                            {{ $variant->menu->nama_menu }} - {{ $variant->nama_variasi }} (Rp {{ number_format($variant->harga) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Jenis Promo -->
                <div>
                    <label class="block text-xs font-bold text-[#7a3939] uppercase mb-2">Jenis Promo</label>
                    <select name="jenis_promo" required class="w-full border-gray-200 rounded-xl focus:ring-[#cc9966] focus:border-[#cc9966] text-sm">
                        <option value="persen" {{ $promo->jenis_promo == 'persen' ? 'selected' : '' }}>Persentase (%)</option>
                        <option value="nominal" {{ $promo->jenis_promo == 'nominal' ? 'selected' : '' }}>Potongan Harga (Rp)</option>
                    </select>
                </div>
                <!-- Nilai Diskon -->
                <div>
                    <label class="block text-xs font-bold text-[#7a3939] uppercase mb-2">Nilai Diskon</label>
                    <input type="number" name="nilai_diskon" value="{{ $promo->nilai_diskon }}" required
                           class="w-full border-gray-200 rounded-xl focus:ring-[#cc9966] focus:border-[#cc9966] text-sm">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Tanggal Mulai -->
                <div>
                    <label class="block text-xs font-bold text-[#7a3939] uppercase mb-2">Tanggal Mulai</label>
                    <input type="datetime-local" name="tanggal_mulai" value="{{ $promo->tanggal_mulai }}" required
                           class="w-full border-gray-200 rounded-xl focus:ring-[#cc9966] focus:border-[#cc9966] text-sm">
                </div>
                <!-- Tanggal Selesai -->
                <div>
                    <label class="block text-xs font-bold text-[#7a3939] uppercase mb-2">Tanggal Selesai</label>
                    <input type="datetime-local" name="tanggal_selesai" value="{{ $promo->tanggal_selesai }}" required
                           class="w-full border-gray-200 rounded-xl focus:ring-[#cc9966] focus:border-[#cc9966] text-sm">
                </div>
            </div>

            <!-- Status Promo -->
            <div>
                <label class="block text-xs font-bold text-[#7a3939] uppercase mb-2">Status Promo</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="aktif" {{ $promo->status == 'aktif' ? 'checked' : '' }} class="text-[#cc9966] focus:ring-[#cc9966]">
                        <span class="text-sm text-gray-700">Aktif</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="nonaktif" {{ $promo->status == 'nonaktif' ? 'checked' : '' }} class="text-[#cc9966] focus:ring-[#cc9966]">
                        <span class="text-sm text-gray-700">Nonaktif</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#cc9966] hover:bg-[#b38659] text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-lg transition-all transform active:scale-95">
                Perbarui Data Promo
            </button>
        </form>
    </div>
</div>
@endsection
