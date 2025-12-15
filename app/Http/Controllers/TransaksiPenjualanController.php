<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Exception;
use App\Models\Menu;
use App\Models\Promo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TransaksiItem;
use App\Models\TransaksiPenjualan;
use Illuminate\Support\Facades\DB;


class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        $menus = Menu::where('status', 'Tersedia')->get();
        return view('dashboard.transaksiPenjualan.index', compact('menus'));
    }

    public function store(Request $request)
    {
        // 1. Decode Data JSON
        $cart = json_decode($request->data, true);

        if (!$cart || count($cart) == 0) {
            return back()->with('error', 'Keranjang kosong!');
        }

        // 2. Ambil ID Menu dari keranjang untuk query ke DB (Eager Loading)
        $menuIds = collect($cart)->pluck('id')->toArray();
        $menus = Menu::whereIn('id', $menuIds)->get()->keyBy('id');

        // 3. Hitung Ulang Total di Server (Demi Keamanan)
        $totalBelanja = 0;
        $validCart = []; // Menyimpan data yang sudah divalidasi

        foreach ($cart as $item) {
            $menu = $menus->get($item['id']);

            // Skip jika menu tidak ditemukan di DB (misal baru saja dihapus admin)
            if (!$menu) continue;

            $qty = (int) $item['qty'];
            if ($qty <= 0) continue;

            // Gunakan harga dari DATABASE, bukan dari request JSON
            $subtotal = $menu->harga * $qty;
            $totalBelanja += $subtotal;

            $validCart[] = [
                'menu_id' => $menu->id,
                'qty' => $qty,
                'harga_satuan' => $menu->harga,
                'subtotal' => $subtotal,
            ];
        }

        // 4. Bersihkan Input Pembayaran
        // Pastikan hanya angka yang diambil (hapus Rp, titik, koma jika ada)
        $dibayar = (int) preg_replace('/[^0-9]/', '', $request->dibayar);

        // Potongan (Logika promo bisa ditambahkan di sini nanti)
        $potongan = 0;
        $totalBayar = $totalBelanja - $potongan;

        // 5. Validasi Pembayaran
        if ($dibayar < $totalBayar) {
            return back()->with('error', 'Uang pembayaran kurang! Total: ' . number_format($totalBayar));
        }

        $kembalian = $dibayar - $totalBayar;

        // 6. Generate Kode Unik (Format: TRX-TAHUNBULANTANGGAL-RANDOM)
        // Contoh: TRX-20231025-X7Z9A
        $kodeTransaksi = 'TRX-' . Carbon::now()->format('Ymd') . '-' . strtoupper(Str::random(5));

        DB::beginTransaction();
        try {
            // 💾 A. Simpan Transaksi Utama
            $transaksi = TransaksiPenjualan::create([
                'user_id' => auth()->id(),
                'kode_transaksi' => $kodeTransaksi,
                'total' => $totalBelanja,
                'potongan' => $potongan,
                'total_bayar' => $totalBayar,
                'dibayar' => $dibayar,
                'kembalian' => $kembalian,
                // 'promo_id' dihapus karena tidak ada di Schema create table Anda sebelumnya.
                // Jika sudah menambahkan kolom promo_id di database, silakan uncomment baris bawah:
                // 'promo_id' => $request->promo_id ?? null,
            ]);

            // 💾 B. Simpan Detail Item
            foreach ($validCart as $item) {
                TransaksiItem::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id' => $item['menu_id'],
                    'jumlah' => $item['qty'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $item['subtotal'],
                    'diskon' => 0, // Default 0 sesuai schema
                    'promo_id' => null // Default null sesuai schema
                ]);
            }

            DB::commit();

            // Redirect ke halaman struk
            return redirect()->route('transaksi.struk', ['kode' => $kodeTransaksi]);
        } catch (Exception $e) {
            DB::rollBack();
            // Log error untuk developer (opsional)
            // \Log::error($e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function struk($kode)
    {
        $transaksi = TransaksiPenjualan::with(['items.menu', 'items.promo'])
            ->where('kode_transaksi', $kode)
            ->firstOrFail();

        return view('dashboard.transaksiPenjualan.struk', compact('transaksi'));
    }
}
