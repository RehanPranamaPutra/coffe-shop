<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['nama_kategori'];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
