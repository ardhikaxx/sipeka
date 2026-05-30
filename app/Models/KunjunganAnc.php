<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KunjunganAnc extends Model
{
    protected $fillable = [
        'kehamilan_id',
        'bidan_id',
        'tanggal',
        'usia_kehamilan_minggu',
        'berat_badan',
        'imt',
        'penambahan_bb',
        'tekanan_darah_sistolik',
        'tekanan_darah_diastolik',
        'map',
        'nadi',
        'suhu',
        'respirasi',
        'tinggi_fundus_uteri',
        'djj',
        'edema',
        'protein_urine',
        'glukosa_urine',
        'hb',
        'trombosit',
        'kreatinin',
        'sgot',
        'sgpt',
        'ada_riwayat_kejang',
        'nyeri_kepala_hebat',
        'gangguan_penglihatan',
        'nyeri_ulu_hati',
        'edema_paru',
        'keluhan_subjektif',
        'catatan_bidan',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'verified_at' => 'datetime',
        'ada_riwayat_kejang' => 'boolean',
        'nyeri_kepala_hebat' => 'boolean',
        'gangguan_penglihatan' => 'boolean',
        'nyeri_ulu_hati' => 'boolean',
        'edema_paru' => 'boolean',
    ];

    public function kehamilan()
    {
        return $this->belongsTo(Kehamilan::class);
    }

    public function bidan()
    {
        return $this->belongsTo(User::class, 'bidan_id');
    }

    public function skriningRisiko()
    {
        return $this->hasOne(SkriningRisiko::class, 'kunjungan_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
