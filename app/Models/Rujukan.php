<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rujukan extends Model
{
    protected $fillable = [
        'kehamilan_id',
        'bidan_id',
        'dokter_id',
        'fasilitas_tujuan_id',
        'status',
        'diagnosa_sementara',
        'alasan_rujukan',
    ];

    public function kehamilan()
    {
        return $this->belongsTo(Kehamilan::class);
    }

    public function bidan()
    {
        return $this->belongsTo(User::class, 'bidan_id');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function fasilitasTujuan()
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'fasilitas_tujuan_id');
    }

    public function catatanDokter()
    {
        return $this->hasOne(CatatanDokter::class);
    }
}
