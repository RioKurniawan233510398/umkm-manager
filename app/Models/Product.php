<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [

        'nama_produk',
        'kategori',
        'stok',
        'harga',
        'production_cost',
        'deskripsi',
        'gambar'

    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
