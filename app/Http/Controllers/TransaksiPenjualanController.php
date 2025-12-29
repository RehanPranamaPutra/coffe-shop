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
        $now = Carbon::now();
        // Ambil menu yang tersedia beserta promo yang sedang aktif (berdasarkan tanggal dan status)
        $menus = Menu::with(['promos' => function ($query) use ($now) {
            $query->where('status', 'aktif')
                ->where('tanggal_mulai', '<=', $now)
                ->where('tanggal_selesai', '>=', $now);
        }])->where('status', 'Tersedia')->get();

        return view('dashboard.transaksiPenjualan.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $cart = json_decode($request->data, true);
        if (!$cart) return back()->with('error', 'Keranjang kosong!');

        $now = Carbon::now();
        $totalBelanjaKotor = 0;
        $totalPotonganPromo = 0;
        $validCart = [];

        DB::beginTransaction();
        try {
            foreach ($cart as $item) {
                // Ambil data menu dengan lock untuk menghindari race condition
                $menu = Menu::with(['promos' => function ($q) use ($now) {
                    $q->where('status', 'aktif')
                        ->where('tanggal_mulai', '<=', $now)
                        ->where('tanggal_selesai', '>=', $now);
                }])->lockForUpdate()->find($item['id']);

                if (!$menu) continue;

                $qty = (int) $item['qty'];

                // 1. Validasi Stok (Cek apakah stok cukup)
                if ($menu->stok < $qty) {
                    throw new Exception("Stok untuk menu '{$menu->nama_menu}' tidak mencukupi. Sisa stok: {$menu->stok}");
                }

                $hargaAsli = $menu->harga;
                $diskonSatuan = 0;
                $promoId = null;

                // Hitung ulang promo
                $activePromo = $menu->promos->first();
                if ($activePromo) {
                    $promoId = $activePromo->id;
                    if ($activePromo->jenis_promo == 'persen') {
                        $diskonSatuan = ($hargaAsli * $activePromo->nilai_diskon) / 100;
                    } else {
                        $diskonSatuan = $activePromo->nilai_diskon;
                    }
                }

                $subtotalItem = ($hargaAsli - $diskonSatuan) * $qty;
                $totalBelanjaKotor += ($hargaAsli * $qty);
                $totalPotonganPromo += ($diskonSatuan * $qty);

                $validCart[] = [
                    'menu_id' => $menu->id,
                    'jumlah' => $qty,
                    'harga_satuan' => $hargaAsli,
                    'diskon' => $diskonSatuan * $qty,
                    'promo_id' => $promoId,
                    'subtotal' => $subtotalItem,
                    'model' => $menu // Simpan instance model untuk mempermudah decrement nanti
                ];
            }

            $totalHarusBayar = $totalBelanjaKotor - $totalPotonganPromo;
            $dibayar = (int) preg_replace('/[^0-9]/', '', $request->dibayar);

            if ($dibayar < $totalHarusBayar) {
                throw new Exception('Uang tidak cukup. Total: ' . number_format($totalHarusBayar));
            }

            $kodeTransaksi = 'TRX-' . $now->format('Ymd') . '-' . strtoupper(Str::random(5));

            // 2. Simpan Header Transaksi
            $transaksi = TransaksiPenjualan::create([
                'user_id' => auth()->id(),
                'kode_transaksi' => $kodeTransaksi,
                'total' => $totalBelanjaKotor,
                'potongan' => $totalPotonganPromo,
                'total_bayar' => $totalHarusBayar,
                'dibayar' => $dibayar,
                'kembalian' => $dibayar - $totalHarusBayar,
            ]);

            // 3. Simpan Detail Item dan Kurangi Stok
            foreach ($validCart as $v) {
                TransaksiItem::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id' => $v['menu_id'],
                    'jumlah' => $v['jumlah'],
                    'harga_satuan' => $v['harga_satuan'],
                    'subtotal' => $v['subtotal'],
                    'diskon' => $v['diskon'],
                    'promo_id' => $v['promo_id']
                ]);

                // PENGURANGAN STOK
                $menuModel = $v['model'];
                $menuModel->decrement('stok', $v['jumlah']);

                // Opsional: Jika stok menjadi 0, ubah status menjadi 'Tidak Tersedia'
                if ($menuModel->stok <= 0) {
                    $menuModel->update(['status' => 'Tidak Tersedia']);
                }
            }

            DB::commit();
            return redirect()->route('transaksi.struk', ['kode' => $kodeTransaksi]);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
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
