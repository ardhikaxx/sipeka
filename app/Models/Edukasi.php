<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    protected $fillable = [
        'judul',
        'konten',
        'kategori',
        'thumbnail',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
