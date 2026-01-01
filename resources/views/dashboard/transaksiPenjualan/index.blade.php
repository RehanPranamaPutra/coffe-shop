@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-12 gap-6 p-2">
        <!-- 🛍️ KOLOM KIRI: DAFTAR PRODUK -->
        <div class="col-span-12 lg:col-span-8">
            <div class="mb-6 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" />
                    </svg>
                </span>
                <input id="search" type="text" placeholder="Cari menu favorit..."
                    class="w-full pl-12 pr-4 py-4 border-none shadow-sm rounded-2xl focus:ring-2 focus:ring-[#cc9966] transition-all text-sm">
            </div>

            <div id="product-list" class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($menus as $menu)
                    @php
                        $activePromo = $menu->promos->first();
                        $diskon = 0;
                        if ($activePromo) {
                            $diskon =
                                $activePromo->jenis_promo == 'persen'
                                    ? ($menu->harga * $activePromo->nilai_diskon) / 100
                                    : $activePromo->nilai_diskon;
                        }
                        $hargaSetelahDiskon = $menu->harga - $diskon;
                        $isHabis = $menu->stok <= 0;
                    @endphp

                    <!-- Produk Card tetap muncul meski stok 0 -->
                    <div class="product-card group bg-white rounded-3xl shadow-sm border border-gray-100 hover:shadow-2xl hover:border-[#cc9966]/30 cursor-pointer transition-all duration-300 overflow-hidden relative"
                        data-id="{{ $menu->id }}" data-nama="{{ $menu->nama_menu }}" data-harga="{{ $menu->harga }}"
                        data-diskon="{{ $diskon }}" data-stok="{{ $menu->stok }}">

                        <div class="relative overflow-hidden">
                            <!-- Gambar menjadi hitam putih dan agak transparan jika habis -->
                            <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}"
                                class="w-full h-40 object-cover transition-transform duration-500 group-hover:scale-110 {{ $isHabis ? 'grayscale opacity-50' : '' }}">

                            <!-- Badge Status Stok (MENAMPILKAN ANGKA NYATA) -->
                            <div class="absolute top-3 left-3">
                                @if ($isHabis)
                                    <span
                                        class="bg-red-600 text-white text-[9px] px-2 py-1 rounded-full font-bold uppercase shadow-lg">
                                        Habis
                                    </span>
                                @elseif($menu->stok <= 10)
                                    <!-- Warna Oranye untuk stok yang mulai menipis (dibawah 10) -->
                                    <span
                                        class="bg-orange-500 text-white text-[9px] px-2 py-1 rounded-full font-bold uppercase shadow-lg">
                                        Stok: {{ $menu->stok }}
                                    </span>
                                @else
                                    <!-- Warna Hijau untuk stok aman -->
                                    <span
                                        class="bg-emerald-500 text-white text-[9px] px-2 py-1 rounded-full font-bold uppercase shadow-lg">
                                        Stok: {{ $menu->stok }}
                                    </span>
                                @endif
                            </div>

                            @if ($isHabis)
                                <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                    <span
                                        class="text-white font-black text-xs uppercase tracking-widest drop-shadow-md">Sold
                                        Out</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-4 text-center {{ $isHabis ? 'opacity-50' : '' }}">
                            <h3 class="font-bold text-gray-800 text-sm truncate mb-1 uppercase">{{ $menu->nama_menu }}</h3>
                            <div class="flex flex-col items-center">
                                @if ($diskon > 0)
                                    <span class="text-gray-400 line-through text-[10px]">Rp
                                        {{ number_format($menu->harga, 0, ',', '.') }}</span>
                                    <span class="text-[#7a3939] font-black italic">Rp
                                        {{ number_format($hargaSetelahDiskon, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-[#7a3939] font-black">Rp
                                        {{ number_format($menu->harga, 0, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 💰 KOLOM KANAN: KERANJANG MINIMALIS -->
        <div class="col-span-12 lg:col-span-4">
            <div
                class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-50 flex flex-col h-[calc(100vh-120px)] sticky top-6 overflow-hidden">

                <!-- Header Keranjang -->
                <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-black text-gray-900">Keranjang</h2>
                        <p class="text-xs text-gray-400 font-medium">Pesanan Pelanggan</p>
                    </div>
                    <button onclick="clearCart()" class="text-gray-300 hover:text-red-500 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                stroke-width="2" />
                        </svg>
                    </button>
                </div>

                <!-- List Item (Minimalis Card) -->
                <div id="cart-list" class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar">
                    <!-- Item akan muncul di sini via JS -->
                </div>

                <!-- Footer Perhitungan -->
                <div class="p-6 bg-gray-50/50 space-y-4 border-t border-gray-100">
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs text-gray-500 font-medium">
                            <span>Subtotal</span>
                            <span id="total-kotor">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-xs text-red-500 font-medium">
                            <span>Diskon Promo</span>
                            <span id="total-diskon">- Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center pt-3 mt-1 border-t border-gray-200">
                            <span class="text-sm font-bold text-gray-900 uppercase tracking-widest">Total Bayar</span>
                            <span id="total-harga" class="text-1xl font-black text-[#7a3939]">Rp 0</span>
                        </div>
                    </div>

                    <!-- Input Pembayaran -->
                    <div class="space-y-3">
                        <div class="relative">
                            <input type="text" id="dibayar"
                                class="w-full bg-white border-none rounded-2xl py-4 px-3 text-xl font-black text-[#7a3939] shadow-inner focus:ring-2 focus:ring-[#cc9966] transition-all"
                                placeholder="Rp 0 (Uang Bayar)">
                        </div>

                        <div class="flex justify-between items-center px-2">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kembalian</span>
                            <span id="kembalian" class="font-bold text-emerald-600">Rp 0</span>
                        </div>

                        <form id="form-transaksi" method="POST" action="{{ route('transaksi.store') }}">
                            @csrf
                            <input type="hidden" name="data" id="input-data">
                            <input type="hidden" name="dibayar" id="dibayar-hidden">
                            <button type="submit" id="btn-buat-pesanan"
                                class="w-full bg-gray-200 text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-lg transition-all transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                                Bayar Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let totalNetto = 0;

        // SweetAlert Notif
        function notify(title, text, icon) {
            Swal.fire({
                title,
                text,
                icon,
                confirmButtonColor: '#7a3939',
                timer: 2000
            });
        }

        // 1. Tambah Produk
        // 1. Tambah Produk & Pengecekan Stok Habis
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', () => {
                const id = card.dataset.id;
                const nama = card.dataset.nama;
                const harga = parseFloat(card.dataset.harga);
                const diskonPerItem = parseFloat(card.dataset.diskon || 0);
                const stokMax = parseInt(card.dataset.stok);

                // JIKA STOK HABIS: Tampilkan notifikasi SweetAlert2
                if (stokMax <= 0) {
                    Swal.fire({
                        title: 'Menu Tidak Tersedia',
                        text: `Maaf, stok untuk menu "${nama}" sudah habis dan tidak dapat dipesan saat ini.`,
                        icon: 'warning',
                        confirmButtonColor: '#7a3939', // Warna Maroon
                        confirmButtonText: 'Tutup',
                        background: '#fff',
                        backdrop: `rgba(122, 57, 57, 0.2)` // Overlay Maroon transparan
                    });
                    return; // Berhenti di sini, jangan masukkan ke keranjang
                }

                const existing = cart.find(item => item.id === id);
                if (existing) {
                    if (existing.qty >= stokMax) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Batas stok tercapai!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        return;
                    }
                    existing.qty++;
                } else {
                    cart.push({
                        id,
                        nama,
                        harga,
                        diskonPerItem,
                        qty: 1,
                        stokMax
                    });
                    // Notifikasi Sukses Tambah (Opsional)
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                    });
                    Toast.fire({
                        icon: 'success',
                        title: `${nama} masuk keranjang`
                    });
                }
                renderCart();
            });
        });

        // 2. Render List Keranjang (Minimalis & Input Manual)
        function renderCart() {
            const list = document.getElementById('cart-list');
            list.innerHTML = '';
            let kotor = 0,
                diskon = 0;

            if (cart.length === 0) {
                list.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-20 opacity-20">
                        <svg class="h-16 w-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="2"/></svg>
                        <p class="text-xs font-bold uppercase tracking-widest">Belum Ada Pesanan</p>
                    </div>`;
            }

            cart.forEach((item, index) => {
                const subNetto = (item.harga - item.diskonPerItem) * item.qty;
                kotor += (item.harga * item.qty);
                diskon += (item.diskonPerItem * item.qty);

                list.innerHTML += `
                    <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 group hover:border-[#cc9966]/50 transition-all shadow-sm">
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-gray-800 truncate uppercase">${item.nama}</h4>
                            <p class="text-[10px] text-gray-400 font-medium">Rp ${item.harga.toLocaleString('id-ID')}</p>
                        </div>

                        <div class="flex items-center bg-gray-50 rounded-lg p-1">
                            <button onclick="updateQty(${index}, -1)" class="w-6 h-6 flex items-center justify-center text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 12H4" stroke-width="3"/></svg>
                            </button>
                            <input type="number" value="${item.qty}"
                                class="w-10 bg-transparent border-none text-center text-xs font-black p-0 focus:ring-0"
                                onchange="manualEditQty(${index}, this.value)">
                            <button onclick="updateQty(${index}, 1)" class="w-6 h-6 flex items-center justify-center text-gray-400 hover:text-emerald-500 transition-colors">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="3"/></svg>
                            </button>
                        </div>

                        <div class="text-right min-w-[70px]">
                            <p class="text-[11px] font-black text-gray-800">Rp ${subNetto.toLocaleString('id-ID')}</p>
                        </div>
                    </div>
                `;
            });

            totalNetto = kotor - diskon;
            document.getElementById('total-kotor').innerText = 'Rp ' + kotor.toLocaleString('id-ID');
            document.getElementById('total-diskon').innerText = '- Rp ' + diskon.toLocaleString('id-ID');
            document.getElementById('total-harga').innerText = 'Rp ' + totalNetto.toLocaleString('id-ID');
            document.getElementById('input-data').value = JSON.stringify(cart);
            updateLogicPembayaran();
        }

        function updateQty(index, change) {
            const item = cart[index];
            if (change > 0 && item.qty >= item.stokMax) return notify('Gagal', 'Stok tidak mencukupi!', 'error');
            item.qty += change;
            if (item.qty < 1) cart.splice(index, 1);
            renderCart();
        }

        function manualEditQty(index, value) {
            let val = parseInt(value);
            const item = cart[index];
            if (isNaN(val) || val < 1) {
                cart.splice(index, 1);
            } else if (val > item.stokMax) {
                notify('Stok Kurang', 'Hanya tersedia ' + item.stokMax, 'warning');
                item.qty = item.stokMax;
            } else {
                item.qty = val;
            }
            renderCart();
        }

        function clearCart() {
            Swal.fire({
                title: 'Kosongkan Keranjang?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#7a3939',
                confirmButtonText: 'Ya, Bersihkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    cart = [];
                    renderCart();
                }
            });
        }

        // Logic Pembayaran & Tombol
        const dibayarInput = document.getElementById('dibayar');
        dibayarInput.addEventListener('input', function(e) {
            let val = e.target.value.replace(/[^\d]/g, '');
            e.target.value = val ? 'Rp ' + parseInt(val).toLocaleString('id-ID') : '';
            updateLogicPembayaran();
        });

        function updateLogicPembayaran() {
            const raw = dibayarInput.value.replace(/[^\d]/g, '');
            const dibayarVal = parseFloat(raw || 0);
            const kembalian = dibayarVal - totalNetto;
            const btn = document.getElementById('btn-buat-pesanan');

            document.getElementById('kembalian').innerText = 'Rp ' + (kembalian > 0 ? kembalian.toLocaleString('id-ID') :
                '0');
            document.getElementById('dibayar-hidden').value = dibayarVal;

            if (cart.length > 0 && dibayarVal >= totalNetto) {
                btn.disabled = false;
                btn.className =
                    "w-full bg-[#7a3939] text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-xl transition-all hover:bg-[#5a2a2a] transform active:scale-95";
            } else {
                btn.disabled = true;
                btn.className =
                    "w-full bg-gray-200 text-white py-4 rounded-2xl font-black uppercase tracking-widest transition-all";
            }
        }

        // Search Menu
        document.getElementById('search').addEventListener('input', function() {
            const kw = this.value.toLowerCase();
            document.querySelectorAll('.product-card').forEach(c => {
                c.style.display = c.dataset.nama.toLowerCase().includes(kw) ? 'block' : 'none';
            });
        });

        renderCart();
    </script>
@endsection
