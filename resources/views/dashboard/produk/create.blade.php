@extends('layouts.app')

@php
    $pageTitle = 'Tambah Produk Baru';
    $headerIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>';
@endphp

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('produk.index') }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-[#7a3939] font-semibold transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Produk
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-[#7a3939] to-[#cc9966] p-6">
                <h3 class="text-2xl font-bold text-white">Tambah Produk Baru</h3>
                <p class="text-white/80 text-sm mt-1">Isi semua informasi produk dengan lengkap</p>
            </div>

            {{-- Form --}}
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                {{-- Image Upload Section --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">
                        Gambar Produk <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-start gap-6">
                        {{-- Preview Image --}}
                        <div class="flex-shrink-0">
                            <div id="imagePreview"
                                class="w-40 h-40 border-2 border-dashed border-gray-300 rounded-lg overflow-hidden bg-gray-50 flex items-center justify-center">
                                <div class="text-center text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-xs">Preview</p>
                                </div>
                            </div>
                        </div>

                        {{-- Upload Button --}}
                        <div class="flex-1">
                            <div
                                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#7a3939] transition duration-200">
                                <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden"
                                    onchange="previewImage(event)">
                                <label for="gambar" class="cursor-pointer">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="text-sm text-gray-600 font-semibold mb-1">Klik untuk upload gambar</p>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG (Max. 2MB)</p>
                                </label>
                            </div>
                            @error('gambar')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Nama Menu --}}
                <div class="space-y-2">
                    <label for="nama_menu" class="block text-sm font-bold text-gray-700">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_menu" id="nama_menu" value="{{ old('nama_menu') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7a3939] focus:border-transparent transition duration-200 @error('nama_menu') border-red-500 @enderror"
                        placeholder="Contoh: Cappuccino Special" required>
                    @error('nama_menu')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Row: Harga & Stok --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Harga --}}
                    <div class="space-y-2">
                        <label for="harga" class="block text-sm font-bold text-gray-700">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-gray-500 font-semibold">Rp</span>
                            <input type="number" name="harga" id="harga" value="{{ old('harga') }}"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7a3939] focus:border-transparent transition duration-200 @error('harga') border-red-500 @enderror"
                                placeholder="25000" min="0" step="0.01" required>
                        </div>
                        @error('harga')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stok --}}
                    <div class="space-y-2">
                        <label for="stok" class="block text-sm font-bold text-gray-700">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stok" id="stok" value="{{ old('stok') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7a3939] focus:border-transparent transition duration-200 @error('stok') border-red-500 @enderror"
                            placeholder="100" min="0" required>
                        @error('stok')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Row: Kategori & Status --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Kategori --}}
                    <div class="space-y-2">
                        <label for="kategori" class="block text-sm font-bold text-gray-700">
                            Kategori
                        </label>
                        <select name="kategori" id="kategori"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7a3939] focus:border-transparent transition duration-200 @error('kategori') border-red-500 @enderror">
                            <option value="">Pilih Kategori</option>
                            <option value="Kopi" {{ old('kategori') == 'Kopi' ? 'selected' : '' }}>Kopi</option>
                            <option value="Non Kopi" {{ old('kategori') == 'Non Kopi' ? 'selected' : '' }}>Non Kopi
                            </option>
                            <option value="Makanan" {{ old('kategori') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="Snack" {{ old('kategori') == 'Snack' ? 'selected' : '' }}>Snack</option>
                        </select>
                        @error('kategori')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="space-y-2">
                        <label for="status" class="block text-sm font-bold text-gray-700">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7a3939] focus:border-transparent transition duration-200 @error('status') border-red-500 @enderror"
                            required>
                            <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Tidak Tersedia" {{ old('status') == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak
                                Tersedia</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-2">
                    <label for="deskripsi" class="block text-sm font-bold text-gray-700">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7a3939] focus:border-transparent transition duration-200 @error('deskripsi') border-red-500 @enderror"
                        placeholder="Tuliskan deskripsi produk...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('produk.index') }}"
                        class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-[#7a3939] to-[#cc9966] text-white font-bold rounded-lg hover:shadow-lg transform hover:scale-105 transition duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Image Preview Script --}}
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.innerHTML =
                        `<img src="${e.target.result}" class="w-full h-full object-cover" alt="Preview">`;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
