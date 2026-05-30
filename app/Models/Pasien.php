<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $fillable = [
        'user_id',
        'nik',
        'nama',
        'tgl_lahir',
        'alamat',
        'no_hp',
        'tinggi_badan',
        'golongan_darah',
        'status_pernikahan',
        'nama_suami',
        'bidan_id',
    ];

    public function bidan()
    {
        return $this->belongsTo(User::class, 'bidan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kehamilans()
    {
        return $this->hasMany(Kehamilan::class);
    }

    public function kehamilanAktif()
    {
        return $this->hasOne(Kehamilan::class)->where('status', 'aktif')->latestOfMany();
    }

    public function laporanDarurats()
    {
        return $this->hasMany(LaporanDarurat::class);
    }

    public function peringatans()
    {
        return $this->hasMany(Peringatan::class);
    }
}
