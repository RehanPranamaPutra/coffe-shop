@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4">
    <!-- 🛍️ Kolom Kiri: Daftar Produk -->
    <div class="col-span-8">
        <div class="mb-4">
            <input id="search" type="text" placeholder="Cari menu..."
                   class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
        </div>

        <div id="product-list" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($menus as $menu)
                <div class="bg-white rounded-lg shadow hover:shadow-lg cursor-pointer transition transform hover:scale-105"
                     data-id="{{ $menu->id }}"
                     data-nama="{{ $menu->nama_menu }}"
                     data-harga="{{ $menu->harga }}">
                    <img src="{{ asset('storage/'.$menu->gambar) }}" alt="{{ $menu->nama_menu }}"
                         class="w-full h-40 object-cover rounded-t-lg">
                    <div class="p-3 text-center">
                        <h6 class="font-semibold">{{ $menu->nama_menu }}</h6>
                        <p class="text-indigo-600 font-bold">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-full text-center">Tidak ada menu tersedia.</p>
            @endforelse
        </div>
    </div>

    <!-- 💰 Kolom Kanan: Keranjang Transaksi -->
    <div class="col-span-4">
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-bold mb-3">Keranjang</h2>

            <!-- Daftar Produk di Keranjang -->
            <div class="overflow-y-auto max-h-80 border rounded-md">
                <table class="w-full text-sm" id="cart-table">
                    <thead class="bg-gray-100 sticky top-0">
                        <tr class="border-b">
                            <th class="text-left py-2 px-2">Nama</th>
                            <th class="text-center py-2 px-2 w-24">Qty</th>
                            <th class="text-right py-2 px-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="cart-body" class="divide-y"></tbody>
                </table>
            </div>

            <!-- Total Harga -->
            <div class="border-t mt-3 pt-3">
                <div class="flex justify-between font-semibold">
                    <span>Total</span>
                    <span id="total-harga">Rp 0</span>
                </div>
            </div>

            <!-- Input Dibayar -->
            <div class="mt-3">
                <label for="dibayar" class="block text-sm font-semibold mb-1">Dibayar</label>
                <input type="text" id="dibayar"
                       class="w-full border rounded-md p-2 focus:ring focus:ring-indigo-200"
                       placeholder="Rp 0">
            </div>

            <!-- Hasil Kembalian -->
            <div class="mt-3 flex justify-between font-semibold">
                <span>Kembalian</span>
                <span id="kembalian">Rp 0</span>
            </div>

            <!-- Notifikasi Uang Kurang -->
            <p id="notif-kurang" class="text-red-600 text-sm mt-1 hidden">⚠️ Uang tidak cukup!</p>

            <!-- Form Simpan Transaksi -->
            <form id="form-transaksi" method="POST" action="{{ route('transaksi.store') }}" class="mt-4">
                @csrf
                <input type="hidden" name="data" id="input-data">
                <input type="hidden" name="dibayar" id="dibayar-hidden">
                <input type="hidden" name="kembalian" id="kembalian-hidden">
                <button type="submit"
                        id="btn-buat-pesanan"
                        class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 disabled:opacity-50 transition"
                        disabled>
                    Buat Pesanan
                </button>
            </form>
        </div>
    </div>
</div>

<!-- ⚙️ JavaScript Interaktif -->
<script>
let cart = [];
let totalBayar = 0;

// Tambah produk ke keranjang
document.querySelectorAll('[data-id]').forEach(card => {
    card.addEventListener('click', () => {
        const id = card.dataset.id;
        const nama = card.dataset.nama;
        const harga = parseFloat(card.dataset.harga);

        const existing = cart.find(item => item.id === id);
        if (existing) {
            existing.qty++;
        } else {
            cart.push({ id, nama, harga, qty: 1 });
        }
        renderCart();
    });
});

// Render isi keranjang
function renderCart() {
    const tbody = document.getElementById('cart-body');
    tbody.innerHTML = '';
    let total = 0;

    cart.forEach((item, index) => {
        const subtotal = item.harga * item.qty;
        total += subtotal;
        tbody.innerHTML += `
            <tr>
                <td class="py-1 px-2">${item.nama}</td>
                <td class="py-1 px-2 text-center">
                    <div class="flex justify-center items-center gap-1">
                        <button class="decrease bg-gray-200 rounded px-2" data-index="${index}">−</button>
                        <input type="number" min="1" class="qty-input w-12 text-center border rounded" data-index="${index}" value="${item.qty}">
                        <button class="increase bg-gray-200 rounded px-2" data-index="${index}">+</button>
                    </div>
                </td>
                <td class="py-1 px-2 text-right">Rp ${subtotal.toLocaleString('id-ID')}</td>
            </tr>
        `;
    });

    totalBayar = total;
    document.getElementById('total-harga').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('input-data').value = JSON.stringify(cart);
    updateKembalian();

    document.getElementById('btn-buat-pesanan').disabled = cart.length === 0;

    // Event tombol tambah / kurang
    document.querySelectorAll('.increase').forEach(btn => {
        btn.addEventListener('click', () => {
            const index = btn.dataset.index;
            cart[index].qty++;
            renderCart();
        });
    });

    document.querySelectorAll('.decrease').forEach(btn => {
        btn.addEventListener('click', () => {
            const index = btn.dataset.index;
            if (cart[index].qty > 1) {
                cart[index].qty--;
            } else {
                cart.splice(index, 1); // hapus item jika qty = 0
            }
            renderCart();
        });
    });

    // Event input manual qty
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', () => {
            const index = input.dataset.index;
            const value = parseInt(input.value);
            if (isNaN(value) || value < 1) {
                cart.splice(index, 1);
            } else {
                cart[index].qty = value;
            }
            renderCart();
        });
    });
}

// Format otomatis input Rupiah
const dibayarInput = document.getElementById('dibayar');
dibayarInput.addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^\d]/g, '');
    e.target.value = value ? 'Rp ' + parseInt(value).toLocaleString('id-ID') : '';
    updateKembalian();
});

// Hitung kembalian
function updateKembalian() {
    const dibayarString = dibayarInput.value.replace(/[^\d]/g, '');
    const dibayar = parseFloat(dibayarString || 0);
    const kembalian = dibayar - totalBayar;
    const notif = document.getElementById('notif-kurang');
    const btn = document.getElementById('btn-buat-pesanan');

    document.getElementById('kembalian').textContent = 'Rp ' + Math.max(0, kembalian).toLocaleString('id-ID');
    document.getElementById('dibayar-hidden').value = dibayar;
    document.getElementById('kembalian-hidden').value = kembalian;

    if (kembalian < 0) {
        notif.classList.remove('hidden');
        btn.disabled = true;
    } else {
        notif.classList.add('hidden');
        btn.disabled = cart.length === 0;
    }
}
</script>
@endsection
