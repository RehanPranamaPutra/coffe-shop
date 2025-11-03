<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    protected $fillable = [
        'transaksi_id',
        'menu_id',
        'promo_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'diskon'
    ];

    /**
     * Relasi ke transaksi utama
     */
    public function transaksi()
    {
        return $this->belongsTo(TransaksiPenjualan::class, 'transaksi_id');
    }

    /**
     * Relasi ke menu
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    /**
     * Relasi ke promo
     */
    public function promo()
    {
        return $this->belongsTo(Promo::class, 'promo_id');
    }
}
