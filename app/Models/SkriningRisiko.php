<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkriningRisiko extends Model
{
    protected $fillable = [
        'kunjungan_id',
        'status',
        'level_risiko',
        'detail_faktor',
    ];

    protected $casts = [
        'detail_faktor' => 'array',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(KunjunganAnc::class, 'kunjungan_id');
    }
}
