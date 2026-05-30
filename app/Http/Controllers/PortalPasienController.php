<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\LaporanDarurat;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalPasienController extends Controller
{
    public function index()
    {
        $pasienQuery = Pasien::with(['kehamilans' => function($q) {
            $q->where('status', 'aktif')->with(['kunjunganAncs' => function($q2) {
                $q2->orderBy('tanggal', 'desc')->with('skriningRisiko');
            }, 'jadwalKunjungans' => fn ($q3) => $q3->orderBy('tanggal_rencana')]);
        }, 'laporanDarurats' => fn ($q) => $q->latest()]);

        $pasien = Auth::user()->role === 'pasien'
            ? $pasienQuery->where('user_id', Auth::id())->first()
            : $pasienQuery->first();

        if (!$pasien) {
            return redirect()->route('login')->withErrors('Data pasien tidak ditemukan.');
        }

        $kehamilanAktif = $pasien->kehamilans->first();

        return view('portal.index', compact('pasien', 'kehamilanAktif'));
    }

    public function laporDarurat(Request $request)
    {
        $validated = $request->validate([
            'gejala' => 'required|array|min:1',
            'gejala.*' => 'string',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $pasien = Pasien::where('user_id', Auth::id())->firstOrFail();

        $laporan = LaporanDarurat::create([
            'pasien_id' => $pasien->id,
            'gejala' => $validated['gejala'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status' => 'Dikirim',
            'bidan_id' => $pasien->bidan_id,
        ]);

        Notifikasi::create([
            'user_id' => $pasien->bidan_id,
            'judul' => 'Laporan darurat pasien',
            'pesan' => $pasien->nama.' melaporkan gejala darurat: '.implode(', ', $validated['gejala']),
        ]);

        return redirect()->route('portal.index')->with('success', 'Laporan darurat terkirim. Bidan pendamping sudah mendapat notifikasi.');
    }
}
