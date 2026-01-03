<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuVariant extends Model
{
    protected $fillable = ['menu_id', 'nama_variasi', 'harga', 'stok'];

    public function menu()
    {
        // Hubungkan varian kembali ke menu induk menggunakan menu_id
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    /**
     * Relasi ke Promo (Jika belum ada)
     */
    // app/Models/MenuVariant.php
    public function promos()
    {
        return $this->hasMany(Promo::class, 'menu_variant_id');
    }
}
