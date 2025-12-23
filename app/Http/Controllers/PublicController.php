<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function home()
    {
        // 1. Ambil 2 Promo Terbaru yang masih aktif
        $promoMenus = Menu::with('activePromo')
            ->whereHas('activePromo', function ($query) {
                $query->where('status', 'aktif')
                    ->where('tanggal_mulai', '<=', Carbon::now())
                    ->where('tanggal_selesai', '>=', Carbon::now());
            })
            ->where('status', 'Tersedia')
            ->latest()
            ->take(2)
            ->get();

        // 2. Hitung berapa banyak menu yang harus diambil dari kategori 'Terlaris'
        // Jika promo kurang dari 2, maka slot terlaris ditambah
        $limitTerlaris = 4 - $promoMenus->count();

        // 3. Ambil Menu Terlaris (berdasarkan jumlah di transaksi_items)
        $bestSellerMenus = Menu::with('activePromo')
            ->leftJoin('transaksi_items', 'menus.id', '=', 'transaksi_items.menu_id')
            ->select('menus.*', DB::raw('SUM(transaksi_items.jumlah) as total_terjual'))
            ->where('menus.status', 'Tersedia')
            // Menghindari duplikasi jika menu promo sudah masuk di list promo
            ->whereNotIn('menus.id', $promoMenus->pluck('id'))
            ->groupBy('menus.id')
            ->orderByDesc('total_terjual')
            ->take($limitTerlaris)
            ->get();

        // 4. Gabungkan keduanya menjadi satu koleksi 'signatureMenus'
        $signatureMenus = $promoMenus->concat($bestSellerMenus);
        return view('partials.components.home', compact('signatureMenus'));
    }
    public function menu()
    {
        // 1. Ambil menu, total terjual, dan promo aktif
        $rawMenus = Menu::with(['activePromo'])
            ->withSum('transaksiItems as total_terjual', 'jumlah')
            ->where('status', 'Tersedia')
            ->get();

        // 2. Mapping Data (Normalisasi Kategori & Hitung Harga Akhir)
        $menus = $rawMenus->map(function ($menu) {

            // A. Normalisasi Kategori (Seperti sebelumnya)
            $kategoriDB = strtolower($menu->kategori);
            if (str_contains($kategoriDB, 'non')) {
                $menu->kategori_final = 'Non Kopi';
            } elseif (str_contains($kategoriDB, 'makan') || str_contains($kategoriDB, 'food')) {
                $menu->kategori_final = 'Makanan';
            } elseif (str_contains($kategoriDB, 'snack') || str_contains($kategoriDB, 'cemil')) {
                $menu->kategori_final = 'Snack';
            } else {
                $menu->kategori_final = 'Kopi';
            }

            // B. Hitung Harga Diskon (Untuk mempermudah View)
            $menu->harga_akhir = $menu->harga;
            $menu->label_diskon = null;

            if ($menu->activePromo) {
                if ($menu->activePromo->jenis_promo == 'persen') {
                    $diskon = $menu->harga * ($menu->activePromo->nilai_diskon / 100);
                    $menu->harga_akhir = $menu->harga - $diskon;
                    $menu->label_diskon = intval($menu->activePromo->nilai_diskon) . '%';
                } else {
                    $menu->harga_akhir = $menu->harga - $menu->activePromo->nilai_diskon;
                    $menu->label_diskon = 'HEMAT'; // Atau '-Rp...'
                }
            }

            return $menu;
        });

        // 3. SORTING: Prioritaskan yang ada Promo (activePromo != null)
        $menus = $menus->sortByDesc(function ($menu) {
            return $menu->activePromo ? 1 : 0;
        });

        return view('partials.components.menu', compact('menus'));
    }

    public function menuShow($slug)
    {
        // 1. Ambil menu berdasarkan Slug + Relasi Promo & Transaksi
        $menu =     Menu::with(['activePromo'])
            ->withSum('transaksiItems as total_terjual', 'jumlah')
            ->where('slug', $slug)
            ->firstOrFail(); // 404 jika tidak ketemu

        // 2. Logic Hitung Harga (Sama seperti di list)
        $menu->harga_akhir = $menu->harga;
        $menu->label_diskon = null;

        if ($menu->activePromo) {
            if ($menu->activePromo->jenis_promo == 'persen') {
                $diskon = $menu->harga * ($menu->activePromo->nilai_diskon / 100);
                $menu->harga_akhir = $menu->harga - $diskon;
                $menu->label_diskon = intval($menu->activePromo->nilai_diskon) . '%';
            } else {
                $menu->harga_akhir = $menu->harga - $menu->activePromo->nilai_diskon;
                $menu->label_diskon = 'HEMAT';
            }
        }

        // 3. Ambil Menu Terkait (Related Products) berdasarkan kategori yang sama
        $relatedMenus = Menu::where('kategori', $menu->kategori)
            ->where('id', '!=', $menu->id) // Jangan tampilkan menu yang sedang dibuka
            ->where('status', 'Tersedia')
            ->take(4)
            ->get();

        return view('partials.components.menuShow', compact('menu', 'relatedMenus'));
    }
    public function promo()
    {
        $promos = \App\Models\Promo::with('menu')->where('status', 'aktif')->get();
        return view('partials.components.promo', compact('promos'));
    }
    public function about()
    {
        return view('partials.components.about');
    }
    public function contact()
    {
        return view('partials.components.contact');
    }
}
