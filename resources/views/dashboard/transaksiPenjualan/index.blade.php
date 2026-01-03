@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-6 p-2">
    <!-- 🛍️ KOLOM KIRI: DAFTAR MENU -->
    <div class="col-span-12 lg:col-span-8">
        <div class="mb-6">
            <input id="search" type="text" placeholder="Cari menu kopi..."
                class="w-full pl-6 pr-6 py-4 border-none shadow-xl rounded-3xl focus:ring-2 focus:ring-[#cc9966] transition-all text-sm">
        </div>

        <div id="product-list" class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach ($menus as $menu)
                @php $isHabis = $menu->variants->sum('stok') <= 0; @endphp
                <div class="product-card group bg-white rounded-[2rem] shadow-sm border border-gray-100 p-3 cursor-pointer hover:shadow-2xl transition-all duration-300 relative"
                    onclick='openVariantModal(@json($menu))'>

                    <div class="relative overflow-hidden rounded-[1.5rem] mb-3">
                        <img src="{{ asset('storage/' . $menu->gambar) }}" class="w-full h-40 object-cover group-hover:scale-110 transition {{ $isHabis ? 'grayscale opacity-40' : '' }}">
                        <div class="absolute top-3 left-3">
                            <span class="{{ $isHabis ? 'bg-red-600' : 'bg-[#10b981]' }} text-white text-[8px] px-2 py-1 rounded-full font-black uppercase shadow-lg">
                                {{ $isHabis ? 'Habis' : 'Tersedia' }}
                            </span>
                        </div>
                    </div>

                    <div class="text-center px-2 pb-2">
                        <h3 class="font-black text-gray-800 text-xs uppercase truncate tracking-tight">{{ $menu->nama_menu }}</h3>
                        <p class="text-[#7a3939] font-black text-sm mt-1 italic">
                            Mulai dari <br> Rp {{ number_format($menu->variants->min('harga'), 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 💰 KOLOM KANAN: KERANJANG MINIMALIS MODERN -->
    <div class="col-span-12 lg:col-span-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl flex flex-col h-[calc(100vh-120px)] sticky top-6 overflow-hidden border border-gray-50">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-black text-[#7a3939] uppercase tracking-tighter">Ringkasan Pesanan</h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Access Coffee POS</p>
                </div>
                <button onclick="clearCart()" class="text-gray-300 hover:text-red-500 p-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" /></svg>
                </button>
            </div>

            <!-- List Item Keranjang -->
            <div id="cart-list" class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar bg-gray-50/20">
                <!-- Dinamis -->
            </div>

            <!-- Footer Perhitungan -->
            <div class="p-6 bg-white border-t border-gray-100 space-y-4">
                <div class="space-y-1.5 text-xs font-bold uppercase text-gray-400">
                    <div class="flex justify-between"><span>Subtotal</span> <span id="label-subtotal">Rp 0</span></div>
                    <div class="flex justify-between text-red-500"><span>Hemat (Promo)</span> <span id="label-diskon">- Rp 0</span></div>
                    <div class="flex justify-between items-center pt-2 mt-1 border-t-2 border-dashed border-gray-100">
                        <span class="text-gray-900 tracking-widest font-black uppercase">Total Bayar</span>
                        <span id="label-total" class="text-2xl font-black text-[#7a3939]">Rp 0</span>
                    </div>
                </div>

                <div class="space-y-3 pt-2">
                    <input type="text" id="dibayar" placeholder="Uang Bayar (Rp)" class="w-full border-none bg-gray-100 rounded-2xl py-4 text-center text-xl font-black text-[#7a3939] focus:ring-2 focus:ring-[#cc9966] shadow-inner">

                    <div class="flex justify-between items-center bg-emerald-50 p-3 rounded-2xl border border-emerald-100">
                        <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Kembalian</span>
                        <span id="label-kembalian" class="font-black text-emerald-700 text-lg">Rp 0</span>
                    </div>

                    <form id="form-transaksi" method="POST" action="{{ route('transaksi.store') }}">
                        @csrf
                        <input type="hidden" name="data" id="input-data">
                        <input type="hidden" name="dibayar" id="dibayar-hidden">
                        <button type="submit" id="btn-bayar" disabled class="w-full bg-gray-200 text-white py-5 rounded-2xl font-black uppercase tracking-widest shadow-xl transition-all transform active:scale-95">
                            Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 🏷️ MODAL PILIH VARIAN -->
<div id="variant-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-black/70 backdrop-blur-md">
    <div class="bg-white rounded-[2.5rem] w-full max-w-md shadow-2xl overflow-hidden transform transition-all duration-300">
        <div class="p-6 bg-[#7a3939] text-white flex justify-between items-center font-black">
            <h3 id="modal-menu-name" class="uppercase tracking-widest text-lg">PILIH VARIAN</h3>
            <button onclick="closeVariantModal()" class="text-2xl">&times;</button>
        </div>
        <div id="variant-container" class="p-5 space-y-3 max-h-[60vh] overflow-y-auto"></div>
    </div>
</div>

<script>
    // 1. STATE MANAGEMENT
    window.cart = [];
    window.currentGrandTotal = 0;

    // 2. FUNGSI DETEKSI PROMO (Logic Paling Akurat)
    function getActivePromo(variant) {
        if (!variant.promos || variant.promos.length === 0) return null;

        // Ambil waktu sekarang dari komputer kasir
        const now = new Date();
        const nowTime = now.getTime();

        return variant.promos.find(p => {
            // Kita pastikan format tanggal valid untuk browser (YYYY-MM-DDTHH:mm:ss)
            const startDate = new Date(p.tanggal_mulai.replace(' ', 'T')).getTime();
            const endDate = new Date(p.tanggal_selesai.replace(' ', 'T')).getTime();

            const isStatusAktif = p.status.toLowerCase() === 'aktif';
            const isTimeMatch = nowTime >= startDate && nowTime <= endDate;

            return isStatusAktif && isTimeMatch;
        });
    }

    // 3. LOGIKA MODAL (PILIH VARIAN)
    window.openVariantModal = function(menu) {
        const modal = document.getElementById('variant-modal');
        const container = document.getElementById('variant-container');
        document.getElementById('modal-menu-name').innerText = menu.nama_menu;

        container.innerHTML = ''; // Reset kontainer varian

        menu.variants.forEach(v => {
            const isHabis = v.stok <= 0;
            const promo = getActivePromo(v); // Cek promo otomatis

            let hargaAsli = parseFloat(v.harga);
            let diskonSatuan = 0;
            let hargaFinal = hargaAsli;

            if (promo) {
                const nilai = parseFloat(promo.nilai_diskon);
                diskonSatuan = promo.jenis_promo === 'persen' ? (hargaAsli * nilai / 100) : nilai;
                hargaFinal = hargaAsli - diskonSatuan;
            }

            const btn = document.createElement('button');
            btn.className = `w-full flex justify-between items-center p-5 border-2 rounded-2xl transition-all ${isHabis ? 'opacity-30 cursor-not-allowed bg-gray-50' : 'border-gray-50 hover:border-[#cc9966] hover:bg-[#cc9966]/5 shadow-sm'}`;
            btn.disabled = isHabis;

            btn.onclick = () => {
                addToCart(v, menu.nama_menu, diskonSatuan, promo ? promo.id : null);
                closeVariantModal();
            };

            // HTML UNTUK HARGA (Menampilkan Harga Coret Jika Promo)
            let priceHTML = `<span class="font-black text-[#7a3939] text-sm">Rp ${Math.round(hargaFinal).toLocaleString('id-ID')}</span>`;
            if (promo) {
                priceHTML = `
                    <div class="text-right flex flex-col">
                        <span class="text-[10px] text-gray-400 line-through font-bold">Rp ${Math.round(hargaAsli).toLocaleString('id-ID')}</span>
                        <span class="font-black text-red-600 text-sm italic">PROMO Rp ${Math.round(hargaFinal).toLocaleString('id-ID')}</span>
                    </div>`;
            }

            btn.innerHTML = `
                <div class="text-left">
                    <span class="font-black text-gray-800 block uppercase text-sm tracking-tight">${v.nama_variasi}</span>
                    <span class="text-[9px] text-gray-400 font-bold uppercase">Stok: ${v.stok}</span>
                </div>
                ${priceHTML}
            `;
            container.appendChild(btn);
        });

        modal.classList.replace('hidden', 'flex');
    }

    window.closeVariantModal = function() {
        document.getElementById('variant-modal').classList.replace('flex', 'hidden');
    }

    // 4. LOGIKA KERANJANG
    function addToCart(variant, menuNama, diskonPerItem, promoId) {
        const existing = window.cart.find(i => i.variant_id === variant.id);

        if (existing) {
            if (existing.qty >= variant.stok) return alert('Batas stok tercapai!');
            existing.qty++;
        } else {
            window.cart.push({
                variant_id: variant.id,
                menu_id: variant.menu_id,
                nama: menuNama + ' - ' + variant.nama_variasi,
                harga: parseFloat(variant.harga),
                diskonPerItem: parseFloat(diskonPerItem || 0),
                promo_id: promoId,
                qty: 1,
                stokMax: variant.stok
            });
        }
        renderCart();
    }

    function renderCart() {
        const list = document.getElementById('cart-list');
        list.innerHTML = '';
        let subtotal = 0, totalPotongan = 0;

        if (window.cart.length === 0) {
            list.innerHTML = `<div class="py-20 text-center opacity-20 text-[10px] font-black uppercase tracking-[0.3em]">Keranjang Kosong</div>`;
        }

        window.cart.forEach((item, index) => {
            const hargaNetto = item.harga - item.diskonPerItem;
            subtotal += (item.harga * item.qty);
            totalPotongan += (item.diskonPerItem * item.qty);

            list.innerHTML += `
                <div class="bg-white rounded-2xl p-4 flex justify-between items-center shadow-sm border border-gray-100 hover:border-[#cc9966]/30 transition-all group">
                    <div class="flex-1 pr-3 truncate">
                        <h4 class="text-[10px] font-black text-gray-800 uppercase leading-tight truncate">${item.nama}</h4>
                        <div class="mt-1 flex gap-2 items-center">
                            ${item.diskonPerItem > 0 ? `<span class="text-[9px] text-gray-300 line-through font-bold">Rp ${item.harga.toLocaleString('id-ID')}</span>` : ''}
                            <span class="text-[11px] font-black text-[#7a3939]">Rp ${Math.round(hargaNetto).toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 bg-gray-50 p-1.5 rounded-xl">
                        <button onclick="updateQty(${index}, -1)" class="w-7 h-7 bg-white rounded-lg shadow-sm text-red-500 font-black hover:bg-red-500 hover:text-white transition-all text-sm">-</button>
                        <span class="text-xs font-black min-w-[25px] text-center text-gray-700">${item.qty}</span>
                        <button onclick="updateQty(${index}, 1)" class="w-7 h-7 bg-white rounded-lg shadow-sm text-[#10b981] font-black hover:bg-[#10b981] hover:text-white transition-all text-sm">+</button>
                    </div>
                </div>`;
        });

        window.currentGrandTotal = subtotal - totalPotongan;
        document.getElementById('label-subtotal').innerText = 'Rp ' + Math.round(subtotal).toLocaleString('id-ID');
        document.getElementById('label-diskon').innerText = '- Rp ' + Math.round(totalPotongan).toLocaleString('id-ID');
        document.getElementById('label-total').innerText = 'Rp ' + Math.round(window.currentGrandTotal).toLocaleString('id-ID');

        document.getElementById('input-data').value = JSON.stringify(window.cart);
        updatePaymentStatus();
    }

    window.updateQty = function(index, change) {
        const item = window.cart[index];
        if (change > 0 && item.qty >= item.stokMax) return alert('Stok Maksimal!');
        item.qty += change;
        if (item.qty < 1) window.cart.splice(index, 1);
        renderCart();
    }

    // 5. LOGIKA PEMBAYARAN & KEMBALIAN
    function updatePaymentStatus() {
        const raw = document.getElementById('dibayar').value.replace(/\D/g, '');
        const pay = parseInt(raw || 0);
        const btn = document.getElementById('btn-bayar');
        const kembalian = pay - window.currentGrandTotal;

        document.getElementById('dibayar-hidden').value = pay;
        document.getElementById('label-kembalian').innerText = 'Rp ' + (kembalian > 0 ? kembalian.toLocaleString('id-ID') : '0');

        if (window.cart.length > 0 && pay >= window.currentGrandTotal) {
            btn.disabled = false;
            btn.className = "w-full bg-[#7a3939] text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] shadow-xl hover:bg-[#5a2a2a] transition-all transform active:scale-95";
        } else {
            btn.disabled = true;
            btn.className = "w-full bg-gray-200 text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em]";
        }
    }

    // 6. EVENT LISTENERS
    document.getElementById('dibayar').addEventListener('input', function(e) {
        let val = e.target.value.replace(/\D/g, '');
        e.target.value = val ? 'Rp ' + parseInt(val).toLocaleString('id-ID') : '';
        updatePaymentStatus();
    });

    document.getElementById('search').addEventListener('input', function() {
        const kw = this.value.toLowerCase();
        document.querySelectorAll('.product-card').forEach(c => {
            const text = c.innerText.toLowerCase();
            c.style.display = text.includes(kw) ? 'block' : 'none';
        });
    });

    window.clearCart = function() {
        if(confirm('Kosongkan semua pesanan?')) {
            window.cart = [];
            renderCart();
        }
    }

    // Inisialisasi awal
    renderCart();
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #f3f4f6; border-radius: 20px; }
</style>
@endsection
