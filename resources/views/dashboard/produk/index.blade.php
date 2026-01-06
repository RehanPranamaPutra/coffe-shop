@extends('layouts.app')

@section('title', 'Manajemen Menu - Access Coffee')

@section('content')
    {{-- Notifikasi --}}
    @if ($errors->any() || session('error') || session('success'))
        <div class="fixed top-5 right-5 z-[60] w-80 animate-bounce-short">
            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded-2xl shadow-2xl mb-3 flex items-start gap-3">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <ul class="text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="bg-emerald-500 text-white p-4 rounded-2xl shadow-2xl flex items-center gap-3">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif
        </div>
    @endif

    <div class="container mx-auto px-4"
        x-data="{
            openAdd: false,
            openEdit: false,
            editData: {},
            imagePreviewAdd: null,
            imagePreviewEdit: null,
            fileChosen(event, type) {
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = (e) => {
                    if (type === 'add') this.imagePreviewAdd = e.target.result;
                    if (type === 'edit') this.imagePreviewEdit = e.target.result;
                }
            }
        }">

        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight flex items-center gap-3">
                    <div class="p-2 bg-[#7a3939] rounded-xl text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    Daftar Menu Utama
                </h2>
                <p class="text-gray-500 mt-1 ml-14">Kelola katalog produk Access Coffee Anda</p>
            </div>
            <button @click="openAdd = true; imagePreviewAdd = null"
                class="bg-[#7a3939] hover:bg-[#5a2a2a] text-white px-6 py-3 rounded-2xl shadow-xl transition-all flex items-center justify-center gap-2 font-bold group">
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Menu Baru
            </button>
        </div>

        <!-- GRID MENU -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse ($menus as $menu)
                <div
                    class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden flex flex-col group hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative">

                    <!-- IMAGE BOX -->
                    <div class="relative h-64 overflow-hidden bg-gray-100">
                        <img src="{{ asset('storage/' . $menu->gambar) }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            alt="{{ $menu->nama_menu }}">

                        <div class="absolute top-4 right-4">
                            <span
                                class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg {{ $menu->status == 'Tersedia' ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white' }}">
                                {{ $menu->status }}
                            </span>
                        </div>

                        <div class="absolute bottom-4 left-4">
                            <span
                                class="bg-white/90 backdrop-blur text-[#7a3939] px-3 py-1 rounded-xl text-[10px] font-bold shadow-sm border border-white/20 uppercase tracking-tighter">
                                {{ $menu->category->nama_kategori }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-black text-gray-800 leading-tight group-hover:text-[#7a3939] transition-colors uppercase mb-2">
                            {{ $menu->nama_menu }}
                        </h3>

                        <p class="text-gray-400 text-sm mb-6 line-clamp-2 leading-relaxed italic">
                            "{{ $menu->deskripsi ?? 'Nikmati sensasi rasa istimewa dari racikan pilihan kami.' }}"
                        </p>

                        <div class="mt-auto">
                            <div class="flex items-center gap-2 mb-4 bg-[#fdf8f3] p-2 rounded-2xl w-fit">
                                <svg class="w-4 h-4 text-[#cc9966]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span class="text-xs font-black text-[#cc9966]">{{ $menu->variants->count() }} Variasi Harga</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('produk.varian.index', $menu->id) }}"
                                    class="flex-1 bg-[#cc9966] text-white py-3 rounded-2xl text-center text-xs font-bold hover:bg-[#b38659] transition-all shadow-md flex items-center justify-center gap-2">
                                    Atur Varian
                                </a>

                                <button @click="editData = @js($menu); openEdit = true; imagePreviewEdit = null"
                                    class="p-3 bg-blue-50 text-blue-600 rounded-2xl hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                <form action="{{ route('produk.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-3 bg-red-50 text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-all shadow-sm text-sm font-bold">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 flex flex-col items-center justify-center bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-sm text-center">Belum ada menu yang terdaftar.</p>
                </div>
            @endforelse
        </div>

        <!-- MODAL TAMBAH MENU -->
        <div x-show="openAdd" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="openAdd" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" @click="openAdd = false"
                class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

            <div x-show="openAdd" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                class="bg-white rounded-[2.5rem] p-8 w-full max-w-xl shadow-2xl relative z-10 overflow-y-auto max-h-[90vh] custom-scrollbar">

                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-2xl font-black text-[#7a3939] uppercase tracking-tighter">Tambah Menu</h3>
                    <button @click="openAdd = false" class="text-gray-400 hover:text-red-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-900">

                        <!-- Preview Gambar (Baru) -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Pratinjau Gambar</label>
                            <div class="w-full h-40 bg-gray-50 rounded-2xl overflow-hidden border-2 border-dashed border-gray-200 flex items-center justify-center">
                                <template x-if="imagePreviewAdd">
                                    <img :src="imagePreviewAdd" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!imagePreviewAdd">
                                    <div class="text-center text-gray-300">
                                        <svg class="w-10 h-10 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        <span class="text-[10px] font-bold uppercase">Belum ada foto</span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Nama Menu</label>
                            <input type="text" name="nama_menu" required class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-[#cc9966] font-bold" placeholder="Contoh: Americano Gula Aren">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Kategori</label>
                            <select name="categories_id" required class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-[#cc9966] font-bold">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Gambar</label>
                            <input type="file" name="gambar" required @change="fileChosen($event, 'add')" class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-[#cc9966] file:text-white hover:file:bg-[#7a3939] cursor-pointer">
                        </div>
                        <div class="md:col-span-2 text-gray-900">
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-[#cc9966] font-bold" rows="3" placeholder="Ceritakan rasa menu ini..."></textarea>
                        </div>
                    </div>
                    <div class="flex gap-4 pt-4">
                        <button type="button" @click="openAdd = false" class="flex-1 py-4 text-gray-400 font-bold uppercase tracking-widest text-xs">Batal</button>
                        <button type="submit" class="flex-[2] bg-[#7a3939] text-white py-4 rounded-[1.5rem] font-black uppercase tracking-[0.2em] shadow-xl hover:bg-[#5a2a2a] transition-all transform active:scale-95">Simpan Menu</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL EDIT MENU -->
        <div x-show="openEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="openEdit" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" @click="openEdit = false"
                class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

            <div x-show="openEdit" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="bg-white rounded-[2.5rem] p-8 w-full max-w-xl shadow-2xl relative z-10 overflow-y-auto max-h-[90vh]">

                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-2xl font-black text-[#7a3939] uppercase tracking-tighter">Edit Menu</h3>
                    <button @click="openEdit = false" class="text-gray-400 hover:text-red-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" /></svg>
                    </button>
                </div>

                <form :action="'{{ url('produk') }}/' + editData.id" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-900">

                        <!-- Perbandingan Gambar (Baru) -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Pratinjau Perubahan</label>
                            <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-3xl">
                                <div class="text-center">
                                    <p class="text-[8px] font-black text-gray-400 mb-1 uppercase">Sekarang</p>
                                    <div class="w-20 h-20 rounded-2xl overflow-hidden border-2 border-white shadow-sm">
                                        <img :src="'/storage/' + editData.gambar" class="w-full h-full object-cover">
                                    </div>
                                </div>
                                <div class="text-[#cc9966]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7" /></svg>
                                </div>
                                <div class="flex-1 text-center">
                                    <p class="text-[8px] font-black text-[#cc9966] mb-1 uppercase">Pratinjau Baru</p>
                                    <div class="w-full h-20 rounded-2xl overflow-hidden border-2 border-dashed border-[#cc9966] flex items-center justify-center bg-white">
                                        <template x-if="imagePreviewEdit">
                                            <img :src="imagePreviewEdit" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!imagePreviewEdit">
                                            <span class="text-[10px] text-gray-300 italic">Pilih file...</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Nama Menu</label>
                            <input type="text" name="nama_menu" x-model="editData.nama_menu" required class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-[#cc9966] font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Kategori</label>
                            <select name="categories_id" x-model="editData.categories_id" required class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-[#cc9966] font-bold">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Status Stok</label>
                            <select name="status" x-model="editData.status" required class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-[#cc9966] font-bold">
                                <option value="Tersedia">Tersedia</option>
                                <option value="Tidak Tersedia">Tidak Tersedia</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Ganti Gambar Produk</label>
                            <p class="text-[10px] text-orange-400 mb-2 font-bold italic">*Kosongkan jika tidak ingin mengubah gambar</p>
                            <input type="file" name="gambar" @change="fileChosen($event, 'edit')" class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-blue-500 file:text-white transition-all cursor-pointer">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Deskripsi</label>
                            <textarea name="deskripsi" x-model="editData.deskripsi" class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-[#cc9966] font-bold" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="flex gap-4 pt-4">
                        <button type="button" @click="openEdit = false" class="flex-1 py-4 text-gray-400 font-bold uppercase tracking-widest text-xs">Batal</button>
                        <button type="submit" class="flex-[2] bg-[#cc9966] text-white py-4 rounded-[1.5rem] font-black uppercase tracking-[0.2em] shadow-xl hover:bg-[#b38659] transition-all transform active:scale-95">Perbarui Menu</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <style>
        @keyframes bounce-short { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-4px); } }
        .animate-bounce-short { animation: bounce-short 1s ease-in-out infinite; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #7a3939; border-radius: 10px; }
    </style>
@endsection
