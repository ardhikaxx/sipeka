<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKunjungan extends Model
{
    protected $fillable = [
        'kehamilan_id',
        'tanggal_rencana',
        'tanggal_realisasi',
        'status',
    ];

    protected $casts = [
        'tanggal_rencana' => 'date',
        'tanggal_realisasi' => 'date',
    ];

    public function kehamilan()
    {
        return $this->belongsTo(Kehamilan::class);
    }
}
