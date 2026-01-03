<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use App\Models\Menu;
use App\Models\MenuVariant;
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
        $menus = Menu::with(['variants.promos'])->where('status', 'Tersedia')->get();
        // Kirim waktu sekarang dari server ke view
        $serverTime = now()->toIso8601String();
        return view('dashboard.transaksiPenjualan.index', compact('menus', 'serverTime'));
    }

    public function store(Request $request)
    {
        $cart = json_decode($request->data, true);
        if (!$cart) return back()->with('error', 'Keranjang kosong!');

        $now = now();
        $totalKotor = 0;
        $totalPotongan = 0;
        $itemsToSave = [];

        DB::beginTransaction();
        try {
            foreach ($cart as $item) {
                // 1. Ambil data varian dan promo aktifnya
                $variant = MenuVariant::with(['promos' => function ($q) use ($now) {
                    $q->where('status', 'aktif')
                        ->where('tanggal_mulai', '<=', $now)
                        ->where('tanggal_selesai', '>=', $now);
                }])->lockForUpdate()->find($item['variant_id']);

                if (!$variant) continue;
                if ($variant->stok < $item['qty']) {
                    throw new Exception("Stok {$variant->nama_variasi} tidak cukup!");
                }

                $hargaAsli = $variant->harga;
                $diskonSatuan = 0;
                $promoId = null;

                // 2. Hitung Promo (Persen vs Nominal)
                $activePromo = $variant->promos->first();
                if ($activePromo) {
                    $promoId = $activePromo->id;
                    if ($activePromo->jenis_promo == 'persen') {
                        $diskonSatuan = ($hargaAsli * $activePromo->nilai_diskon) / 100;
                    } else {
                        $diskonSatuan = $activePromo->nilai_diskon;
                    }
                }

                $subtotalItem = ($hargaAsli - $diskonSatuan) * $item['qty'];

                $totalKotor += ($hargaAsli * $item['qty']);
                $totalPotongan += ($diskonSatuan * $item['qty']);

                $itemsToSave[] = [
                    'variant' => $variant,
                    'menu_id' => $variant->menu_id,
                    'promo_id' => $promoId,
                    'qty' => $item['qty'],
                    'harga_satuan' => $hargaAsli,
                    'diskon' => $diskonSatuan * $item['qty'],
                    'subtotal' => $subtotalItem
                ];
            }

            $totalBersih = $totalKotor - $totalPotongan;
            $dibayar = (int) preg_replace('/\D/', '', $request->dibayar);

            if ($dibayar < $totalBersih) {
                throw new Exception("Uang kurang! Total: Rp " . number_format($totalBersih));
            }

            // 3. Simpan Transaksi
            $transaksi = TransaksiPenjualan::create([
                'kode_transaksi' => 'TRX-' . time(),
                'user_id' => auth()->id(),
                'total' => $totalKotor,
                'potongan' => $totalPotongan,
                'total_bayar' => $totalBersih,
                'dibayar' => $dibayar,
                'kembalian' => $dibayar - $totalBersih,
            ]);

            foreach ($itemsToSave as $v) {
                TransaksiItem::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id' => $v['menu_id'],
                    'variant_id' => $v['variant']->id,
                    'promo_id' => $v['promo_id'],
                    'jumlah' => $v['qty'],
                    'harga_satuan' => $v['harga_satuan'],
                    'diskon' => $v['diskon'],
                    'subtotal' => $v['subtotal'],
                ]);
                $v['variant']->decrement('stok', $v['qty']);
            }

            DB::commit();
            return redirect()->route('transaksi.struk', ['kode' => $transaksi->kode_transaksi])
                ->with('success', 'Transaksi Berhasil!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function struk($kode)
    {
        $transaksi = TransaksiPenjualan::with([
            'user',
            'items.menu.variants' // Tarik menu dan semua pilihan harganya (Robusta, Arabica, dll)
        ])
            ->where('kode_transaksi', $kode)
            ->firstOrFail();

        return view('dashboard.transaksiPenjualan.struk', compact('transaksi'));
    }
}
