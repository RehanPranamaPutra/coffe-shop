<?php

namespace App\Http\Controllers;

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
        $cart = json_decode($request->data, true);

        if (!$cart || count($cart) == 0) {
            return back()->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();
        try {
            $total = collect($cart)->sum(fn($item) => $item['harga'] * $item['qty']);
            $dibayar = (int) $request->dibayar;
            $kembalian = $dibayar - $total;
            $kodeTransaksi = 'TRX-' . strtoupper(Str::random(6));

            // 🧾 Simpan data utama transaksi
            $transaksi = TransaksiPenjualan::create([
                'user_id' => auth()->id(),
                'promo_id' => $request->promo_id ?? null,
                'kode_transaksi' => $kodeTransaksi,
                'total' => $total,
                'potongan' => 0,
                'total_bayar' => $total,
                'dibayar' => $dibayar,
                'kembalian' => $kembalian,
            ]);

            // 💿 Simpan detail item per menu
            foreach ($cart as $item) {
                TransaksiItem::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id' => $item['id'],
                    'jumlah' => $item['qty'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['qty'],
                ]);
            }

            DB::commit();
            return redirect()->route('transaksi.struk', ['kode' => $kodeTransaksi]);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
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
