<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPersalinan extends Model
{
    protected $fillable = [
        'kehamilan_id',
        'tanggal',
        'jenis',
        'indikasi_sc',
        'kondisi_ibu',
        'bb_bayi',
        'panjang_bayi',
        'apgar_score',
        'kondisi_bayi',
        'komplikasi',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kehamilan()
    {
        return $this->belongsTo(Kehamilan::class);
    }
}
