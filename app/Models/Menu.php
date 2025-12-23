<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    // Tambahkan ini
    protected $fillable = [
        'nama_menu',
        'slug',
        'harga',
        'stok',
        'kategori',
        'status',
        'deskripsi',
        'gambar',
    ];

    // Optional: Casting untuk tipe data
    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];

    public function promos()
    {
        // Hubungkan ke model Promo, bukan Menu
    return $this->hasMany(Promo::class, 'menu_id'); 
    }
    public function transaksiPembelian()
    {
        return $this->hasMany(TransaksiPembelian::class);
    }

    public function activePromo()
    {
        return $this->hasOne(Promo::class)
            ->where('status', 'aktif')
            ->where('tanggal_mulai', '<=', Carbon::now())
            ->where('tanggal_selesai', '>=', Carbon::now())
            ->latest(); // Mengambil yang paling baru dibuat jika ada duplikat
    }

    // Relasi ke Transaksi Item (Untuk menghitung Best Seller)
    public function transaksiItems()
    {
        return $this->hasMany(TransaksiItem::class);
    }
}
