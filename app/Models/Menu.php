<?php

namespace App\Models;

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

    public function promo()
    {
        return $this->hasMany(Menu::class);
    }
    public function transaksiPembelian()
    {
        return $this->hasMany(TransaksiPembelian::class);
    }

}
