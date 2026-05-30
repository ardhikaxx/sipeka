<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasKesehatan extends Model
{
    protected $table = 'fasilitas_kesehatans';
    protected $fillable = [
        'nama',
        'tipe',
        'kecamatan',
        'kabupaten',
        'provinsi',
    ];
}
