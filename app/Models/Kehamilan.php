<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehamilan extends Model
{
    protected $fillable = [
        'pasien_id',
        'hpht',
        'tp',
        'gravida',
        'para',
        'abortus',
        'riwayat_preeklampsia',
        'riwayat_hipertensi',
        'riwayat_diabetes',
        'riwayat_ginjal',
        'riwayat_bblr',
        'keluarga_preeklampsia',
        'kehamilan_kembar',
        'nullipara',
        'interval_lebih_10',
        'status',
    ];

    protected $casts = [
        'hpht' => 'date',
        'tp' => 'date',
        'riwayat_preeklampsia' => 'boolean',
        'riwayat_hipertensi' => 'boolean',
        'riwayat_diabetes' => 'boolean',
        'riwayat_ginjal' => 'boolean',
        'riwayat_bblr' => 'boolean',
        'keluarga_preeklampsia' => 'boolean',
        'kehamilan_kembar' => 'boolean',
        'nullipara' => 'boolean',
        'interval_lebih_10' => 'boolean',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function kunjunganAncs()
    {
        return $this->hasMany(KunjunganAnc::class);
    }

    public function rujukans()
    {
        return $this->hasMany(Rujukan::class);
    }

    public function jadwalKunjungans()
    {
        return $this->hasMany(JadwalKunjungan::class);
    }

    public function hasilPersalinan()
    {
        return $this->hasOne(HasilPersalinan::class);
    }
}
