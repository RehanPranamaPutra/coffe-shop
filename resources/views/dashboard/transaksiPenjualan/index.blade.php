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
                @foreach ($menus as $menu)
                    @php
                        $activePromo = $menu->promos->first();
                        $diskon = 0;
                        if ($activePromo) {
                            if ($activePromo->jenis_promo == 'persen') {
                                $diskon = ($menu->harga * $activePromo->nilai_diskon) / 100;
                            } else {
                                $diskon = $activePromo->nilai_diskon;
                            }
                        }
                        $hargaSetelahDiskon = $menu->harga - $diskon;
                    @endphp
                    <div class="product-card bg-white rounded-lg shadow hover:shadow-lg cursor-pointer transition transform hover:scale-105"
                        data-id="{{ $menu->id }}"
                        data-nama="{{ $menu->nama_menu }}"
                        data-harga="{{ $menu->harga }}"
                        data-diskon="{{ $diskon }}">

                        <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}"
                            class="w-full h-40 object-cover rounded-t-lg">

                        <div class="p-3 text-center">
                            <h6 class="font-semibold text-sm">{{ $menu->nama_menu }}</h6>
                            @if ($diskon > 0)
                                <p class="text-gray-400 line-through text-xs">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                <p class="text-red-600 font-bold">Rp {{ number_format($hargaSetelahDiskon, 0, ',', '.') }}</p>
                            @else
                                <p class="text-indigo-600 font-bold">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 💰 Kolom Kanan: Keranjang Transaksi -->
        <div class="col-span-4">
            <div class="bg-white rounded-lg shadow p-4 sticky top-4">
                <h2 class="text-lg font-bold mb-3">Keranjang</h2>

                <div class="overflow-y-auto max-h-60 border rounded-md">
                    <table class="w-full text-sm" id="cart-table">
                        <thead class="bg-gray-100 sticky top-0">
                            <tr class="border-b text-xs text-left">
                                <th class="py-2 px-2">Nama</th>
                                <th class="py-2 px-2 w-20 text-center">Qty</th>
                                <th class="py-2 px-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="cart-body" class="divide-y text-[11px]"></tbody>
                    </table>
                </div>

                <div class="border-t mt-3 pt-3 space-y-1">
                    <div class="flex justify-between text-xs">
                        <span>Total Kotor</span>
                        <span id="total-kotor">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-xs text-red-600">
                        <span>Total Diskon</span>
                        <span id="total-diskon">- Rp 0</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t pt-1">
                        <span>Total Bayar</span>
                        <span id="total-harga">Rp 0</span>
                    </div>
                </div>

                <!-- Bagian Pembayaran -->
                <div class="mt-4 bg-gray-50 p-3 rounded-lg border">
                    <label for="dibayar" class="block text-sm font-semibold mb-1">Uang Dibayar <span class="text-red-500">*</span></label>
                    <input type="text" id="dibayar"
                        class="w-full border-2 border-indigo-200 rounded-md p-2 text-lg font-bold focus:border-indigo-500 focus:outline-none"
                        placeholder="Rp 0">

                    <!-- Notifikasi Error -->
                    <div id="error-message" class="mt-2 text-[11px] font-bold text-red-600 hidden">
                        <span id="error-text">⚠️ Wajib diisi!</span>
                    </div>
                </div>

                <div class="mt-3 flex justify-between font-semibold text-sm">
                    <span>Kembalian</span>
                    <span id="kembalian" class="text-green-600 font-bold">Rp 0</span>
                </div>

                <!-- Form -->
                <form id="form-transaksi" method="POST" action="{{ route('transaksi.store') }}" class="mt-4">
                    @csrf
                    <input type="hidden" name="data" id="input-data">
                    <input type="hidden" name="dibayar" id="dibayar-hidden">

                    <button type="submit" id="btn-buat-pesanan"
                        class="w-full bg-gray-400 text-white py-3 rounded-lg font-bold transition duration-200 cursor-not-allowed"
                        disabled>
                        Buat Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let totalNetto = 0;

        // 1. Tambah Produk
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', () => {
                const id = card.dataset.id;
                const nama = card.dataset.nama;
                const harga = parseFloat(card.dataset.harga);
                const diskonPerItem = parseFloat(card.dataset.diskon || 0);

                const existing = cart.find(item => item.id === id);
                if (existing) {
                    existing.qty++;
                } else {
                    cart.push({ id, nama, harga, diskonPerItem, qty: 1 });
                }
                renderCart();
            });
        });

        // 2. Render Keranjang
        function renderCart() {
            const tbody = document.getElementById('cart-body');
            tbody.innerHTML = '';
            let kotor = 0, diskon = 0;

            if (cart.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="text-center py-4 text-gray-400">Keranjang Kosong</td></tr>';
            }

            cart.forEach((item, index) => {
                const subKotor = item.harga * item.qty;
                const subDiskon = item.diskonPerItem * item.qty;
                kotor += subKotor;
                diskon += subDiskon;

                tbody.innerHTML += `
                    <tr>
                        <td class="py-2 px-2 font-medium">${item.nama}</td>
                        <td class="py-2 px-2">
                            <div class="flex items-center justify-center gap-2">
                                <button class="bg-gray-200 px-1 rounded hover:bg-gray-300" onclick="updateQty(${index}, -1)">-</button>
                                <span>${item.qty}</span>
                                <button class="bg-gray-200 px-1 rounded hover:bg-gray-300" onclick="updateQty(${index}, 1)">+</button>
                            </div>
                        </td>
                        <td class="py-2 px-2 text-right">Rp ${(subKotor - subDiskon).toLocaleString('id-ID')}</td>
                    </tr>
                `;
            });

            totalNetto = kotor - diskon;
            document.getElementById('total-kotor').textContent = 'Rp ' + kotor.toLocaleString('id-ID');
            document.getElementById('total-diskon').textContent = '- Rp ' + diskon.toLocaleString('id-ID');
            document.getElementById('total-harga').textContent = 'Rp ' + totalNetto.toLocaleString('id-ID');
            document.getElementById('input-data').value = JSON.stringify(cart);

            updateLogicPembayaran();
        }

        function updateQty(index, change) {
            cart[index].qty += change;
            if (cart[index].qty < 1) cart.splice(index, 1);
            renderCart();
        }

        // 3. Format Input & Validasi Tombol
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
            const errorDiv = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');

            document.getElementById('kembalian').textContent = 'Rp ' + (kembalian > 0 ? kembalian.toLocaleString('id-ID') : '0');
            document.getElementById('dibayar-hidden').value = dibayarVal;

            // Logika Validasi Aktifkan Tombol
            const isCartEmpty = cart.length === 0;
            const isUangKosong = dibayarVal === 0;
            const isUangKurang = kembalian < 0;

            if (isCartEmpty) {
                btn.disabled = true;
                btn.className = "w-full bg-gray-400 text-white py-3 rounded-lg font-bold cursor-not-allowed";
                errorDiv.classList.add('hidden');
            }
            else if (isUangKosong) {
                btn.disabled = true;
                btn.className = "w-full bg-gray-400 text-white py-3 rounded-lg font-bold cursor-not-allowed";
                errorText.innerText = "⚠️ Uang bayar wajib diisi!";
                errorDiv.classList.remove('hidden');
            }
            else if (isUangKurang) {
                btn.disabled = true;
                btn.className = "w-full bg-red-400 text-white py-3 rounded-lg font-bold cursor-not-allowed";
                errorText.innerText = "⚠️ Uang tidak cukup!";
                errorDiv.classList.remove('hidden');
            }
            else {
                // VALID - Tombol Aktif
                btn.disabled = false;
                btn.className = "w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-bold cursor-pointer shadow-lg transform active:scale-95 transition";
                errorDiv.classList.add('hidden');
            }
        }

        // 4. Cegah Submit lewat Enter atau klik jika belum valid (Double Check)
        document.getElementById('form-transaksi').addEventListener('submit', function(e) {
            const raw = dibayarInput.value.replace(/[^\d]/g, '');
            const dibayarVal = parseFloat(raw || 0);

            if (cart.length === 0) {
                e.preventDefault();
                alert('Keranjang masih kosong!');
            } else if (dibayarVal <= 0) {
                e.preventDefault();
                alert('Silahkan isi jumlah uang dibayar!');
                dibayarInput.focus();
            } else if (dibayarVal < totalNetto) {
                e.preventDefault();
                alert('Uang pembayaran kurang!');
            }
        });

        // 5. Search Menu
        document.getElementById('search').addEventListener('input', function() {
            const kw = this.value.toLowerCase();
            document.querySelectorAll('.product-card').forEach(c => {
                c.style.display = c.dataset.nama.toLowerCase().includes(kw) ? 'block' : 'none';
            });
        });

        // Initial Render
        renderCart();
    </script>
@endsection
