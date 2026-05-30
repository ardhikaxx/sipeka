<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peringatan extends Model
{
    protected $fillable = [
        'pasien_id',
        'kunjungan_id',
        'level',
        'deskripsi',
        'status',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function kunjungan()
    {
        return $this->belongsTo(KunjunganAnc::class, 'kunjungan_id');
    }
}
