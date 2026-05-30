<?php

namespace App\Http\Controllers;

use App\Models\HasilPersalinan;
use App\Models\KunjunganAnc;
use App\Models\Pasien;
use App\Models\Rujukan;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pasienQuery = Pasien::query()
            ->when($user->role === 'bidan', fn ($q) => $q->where('bidan_id', $user->id))
            ->when($user->role === 'dokter', fn ($q) => $q->whereHas('kehamilans.rujukans', function ($query) use ($user) {
                $query->where('dokter_id', $user->id)->orWhere('fasilitas_tujuan_id', $user->fasilitas_id);
            }));

        $kunjunganQuery = KunjunganAnc::query()
            ->when($user->role === 'bidan', fn ($q) => $q->where('bidan_id', $user->id))
            ->when($user->role === 'dokter', fn ($q) => $q->whereHas('kehamilan.rujukans', function ($query) use ($user) {
                $query->where('dokter_id', $user->id)->orWhere('fasilitas_tujuan_id', $user->fasilitas_id);
            }));

        return view('laporan.index', [
            'totalPasien' => (clone $pasienQuery)->count(),
            'totalKunjungan' => (clone $kunjunganQuery)->count(),
            'totalRujukan' => Rujukan::when($user->role === 'bidan', fn ($q) => $q->where('bidan_id', $user->id))
                ->when($user->role === 'dokter', fn ($q) => $q->where(function ($query) use ($user) {
                    $query->where('dokter_id', $user->id)->orWhere('fasilitas_tujuan_id', $user->fasilitas_id);
                }))
                ->count(),
            'totalPersalinan' => HasilPersalinan::count(),
            'rujukans' => Rujukan::with(['kehamilan.pasien', 'fasilitasTujuan'])
                ->when($user->role === 'bidan', fn ($q) => $q->where('bidan_id', $user->id))
                ->when($user->role === 'dokter', fn ($q) => $q->where(function ($query) use ($user) {
                    $query->where('dokter_id', $user->id)->orWhere('fasilitas_tujuan_id', $user->fasilitas_id);
                }))
                ->latest()
                ->take(10)
                ->get(),
        ]);
    }
}
