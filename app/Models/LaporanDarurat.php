<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanDarurat extends Model
{
    protected $fillable = [
        'pasien_id',
        'gejala',
        'deskripsi',
        'status',
        'bidan_id',
    ];

    protected $casts = [
        'gejala' => 'array',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function bidan()
    {
        return $this->belongsTo(User::class, 'bidan_id');
    }
}
