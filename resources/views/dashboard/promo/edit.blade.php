@extends('layouts.app')

@php
    $pageTitle = 'Edit Promo: ' . ($promo->menu->nama_menu ?? 'Produk Dihapus');
    $headerIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
    </svg>';
@endphp

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('promo.index') }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-[#7a3939] font-semibold transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Promo
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-[#7a3939] to-[#cc9966] p-6">
                <h3 class="text-2xl font-bold text-white">Edit Promo</h3>
                <p class="text-white/80 text-sm mt-1">Perbarui detail diskon untuk produk: {{ $promo->menu->nama_menu ?? 'Produk Dihapus' }}</p>
            </div>

            {{-- Form Promo --}}
            <form action="{{ route('promo.update', $promo->id) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT') {{-- Wajib menggunakan method PUT/PATCH untuk update --}}

                {{-- Pilih Produk (Menu ID) --}}
                <div class="space-y-2">
                    <label for="menu_id" class="block text-sm font-bold text-gray-700">
                        Pilih Produk <span class="text-red-500">*</span>
                    </label>
                    <select name="menu_id" id="menu_id" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7a3939] focus:border-transparent transition duration-200 @error('menu_id') border-red-500 @enderror">
                        <option value="">-- Pilih Produk yang Dikenai Promo --</option>
                        {{-- Loop daftar menu yang dilempar dari controller --}}
                        @foreach ($menus as $menu)
                            {{-- Menggunakan old() untuk error, atau nilai promo yang sudah ada --}}
                            <option value="{{ $menu->id }}"
                                {{ old('menu_id', $promo->menu_id) == $menu->id ? 'selected' : '' }}>
                                {{ $menu->nama_menu }} (ID: {{ $menu->id }})
                            </option>
                        @endforeach
                    </select>
                    @error('menu_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Row: Jenis Promo & Nilai Diskon --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Jenis Promo (Enum: persen, nominal) --}}
                    <div class="space-y-2">
                        <label for="jenis_promo" class="block text-sm font-bold text-gray-700">
                            Jenis Diskon <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_promo" id="jenis_promo" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7a3939] focus:border-transparent transition duration-200 @error('jenis_promo') border-red-500 @enderror">
                            <option value="">Pilih Jenis Diskon</option>
                            <option value="persen" {{ old('jenis_promo', $promo->jenis_promo) == 'persen' ? 'selected' : '' }}>Persentase (%)</option>
                            <option value="nominal" {{ old('jenis_promo', $promo->jenis_promo) == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                        </select>
                        @error('jenis_promo')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nilai Diskon (decimal 12,2) --}}
                    <div class="space-y-2">
                        <label for="nilai_diskon" class="block text-sm font-bold text-gray-700">
                            Nilai Diskon <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            {{-- Teks petunjuk akan berubah tergantung pilihan jenis_promo (via JS) --}}
                            <span id="label_diskon" class="absolute right-4 top-3.5 text-gray-500 font-semibold text-sm"></span>
                            <input type="number" name="nilai_diskon" id="nilai_diskon"
                                value="{{ old('nilai_diskon', $promo->nilai_diskon) }}"
                                class="w-full pr-14 pl-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7a3939] focus:border-transparent transition duration-200 @error('nilai_diskon') border-red-500 @enderror"
                                placeholder="Cth: 10 atau 5000" min="0" step="0.01" required>
                        </div>
                        @error('nilai_diskon')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Row: Tanggal Mulai & Tanggal Selesai --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Tanggal Mulai --}}
                    <div class="space-y-2">
                        <label for="tanggal_mulai" class="block text-sm font-bold text-gray-700">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        {{-- Format datetime-local harus YYYY-MM-DDTHH:MM --}}
                        <input type="datetime-local" name="tanggal_mulai" id="tanggal_mulai"
                            value="{{ old('tanggal_mulai', \Carbon\Carbon::parse($promo->tanggal_mulai)->format('Y-m-d\TH:i')) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7a3939] focus:border-transparent transition duration-200 @error('tanggal_mulai') border-red-500 @enderror"
                            required>
                        @error('tanggal_mulai')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div class="space-y-2">
                        <label for="tanggal_selesai" class="block text-sm font-bold text-gray-700">
                            Tanggal Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" name="tanggal_selesai" id="tanggal_selesai"
                            value="{{ old('tanggal_selesai', \Carbon\Carbon::parse($promo->tanggal_selesai)->format('Y-m-d\TH:i')) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7a3939] focus:border-transparent transition duration-200 @error('tanggal_selesai') border-red-500 @enderror"
                            required>
                        @error('tanggal_selesai')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('promo.index') }}"
                        class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-bold rounded-lg hover:shadow-lg transform hover:scale-105 transition duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Update Promo
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script untuk mengubah label diskon --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisPromoSelect = document.getElementById('jenis_promo');
            const nilaiDiskonInput = document.getElementById('nilai_diskon');
            const labelDiskon = document.getElementById('label_diskon');

            function updateDiskonLabel() {
                const jenis = jenisPromoSelect.value;
                if (jenis === 'persen') {
                    labelDiskon.textContent = '%';
                    nilaiDiskonInput.setAttribute('max', 100);
                } else if (jenis === 'nominal') {
                    labelDiskon.textContent = 'Rp';
                    nilaiDiskonInput.removeAttribute('max');
                } else {
                    labelDiskon.textContent = '';
                }
            }

            // Panggil saat halaman dimuat (untuk old input dan nilai awal)
            updateDiskonLabel();

            // Panggil saat pilihan jenis promo berubah
            jenisPromoSelect.addEventListener('change', updateDiskonLabel);
        });
    </script>
@endsection
