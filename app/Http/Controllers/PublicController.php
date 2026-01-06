<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Carbon\Carbon;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function home()
    {
        $now = \Carbon\Carbon::now();

        // 1. Ambil 2 Menu yang sedang PROMO aktif
        $promoMenus = Menu::whereHas('variants.promos', function ($q) use ($now) {
            $q->where('status', 'aktif')
                ->where('tanggal_mulai', '<=', $now)
                ->where('tanggal_selesai', '>=', $now);
        })
            ->with(['variants.promos' => function ($q) use ($now) {
                $q->where('status', 'aktif')
                    ->where('tanggal_mulai', '<=', $now)
                    ->where('tanggal_selesai', '>=', $now);
            }, 'category'])
            ->where('status', 'Tersedia')
            ->take(2)
            ->get()
            ->map(function ($item) {
                $item->tag = 'PROMO'; // Tandai sebagai promo
                return $item;
            });

        // 2. Ambil 2 Menu TERLARIS (Best Seller)
        // Kita ambil yang tidak termasuk dalam promo tadi agar tidak double
        $promoIds = $promoMenus->pluck('id');

        // Catatan: Jika Anda belum punya tabel detail_penjualan,
        // sementara kita ambil menu terbaru/random yang tersedia.
        // Jika sudah ada, gunakan withCount('penjualan')
        $bestSellerMenus = Menu::with(['variants', 'category'])
            ->where('status', 'Tersedia')
            ->whereNotIn('id', $promoIds) // Jangan ambil lagi yang sudah ada di list promo
            ->take(2)
            ->get()
            ->map(function ($item) {
                $item->tag = 'BEST SELLER'; // Tandai sebagai best seller
                return $item;
            });

        // 3. Gabungkan keduanya menjadi satu koleksi (Total 4 menu)
        $signatureMenus = $promoMenus->concat($bestSellerMenus);

        return view('partials.components.home', compact('signatureMenus'));
    }
    public function menu()
    {
        $now = now();

        // 1. Ambil semua kategori untuk Tab Filter
        $categories = Categories::all();

        // 2. Ambil Menu yang 'Tersedia' beserta Varian dan Promo yang aktif saat ini
        $menus = \App\Models\Menu::with(['category', 'variants.promos' => function ($q) use ($now) {
            $q->where('status', 'aktif')
                ->where('tanggal_mulai', '<=', $now)
                ->where('tanggal_selesai', '>=', $now);
        }])
            ->where('status', 'Tersedia')
            ->get();

        return view('partials.components.menu', compact('menus', 'categories'));
    }

    public function menuShow($slug)
    {
        // 1. Ambil menu berdasarkan Slug + Relasi Promo & Transaksi
        $now = now();

        // Ambil menu berdasarkan slug dengan relasi varian dan promo yang aktif
        $menu = Menu::with(['category', 'variants.promos' => function ($q) use ($now) {
            $q->where('status', 'aktif')
                ->where('tanggal_mulai', '<=', $now)
                ->where('tanggal_selesai', '>=', $now);
        }])
            ->where('slug', $slug)
            ->firstOrFail();

        // Ambil menu terkait (kategori yang sama, tapi bukan menu ini sendiri)
        $relatedMenus = Menu::with('variants')
            ->where('categories_id', $menu->categories_id)
            ->where('id', '!=', $menu->id)
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
