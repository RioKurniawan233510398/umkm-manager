<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessProfile extends Model
{
    protected $fillable = [

        'nama_usaha',
        'pemilik',
        'telepon',
        'email',
        'alamat',
        'deskripsi',
        'logo'

    ];
}
