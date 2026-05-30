<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatatanDokter extends Model
{
    protected $fillable = [
        'rujukan_id',
        'dokter_id',
        'diagnosis',
        'resep',
        'catatan',
    ];

    public function rujukan()
    {
        return $this->belongsTo(Rujukan::class);
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
}
