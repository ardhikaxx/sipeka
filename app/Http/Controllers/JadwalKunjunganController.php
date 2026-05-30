<?php

namespace App\Http\Controllers;

use App\Models\JadwalKunjungan;
use App\Models\Kehamilan;
use Illuminate\Http\Request;

class JadwalKunjunganController extends Controller
{
    public function store(Request $request, Kehamilan $kehamilan)
    {
        $validated = $request->validate([
            'tanggal_rencana' => 'required|date',
            'status' => 'required|in:Terjadwal,Selesai,Terlewat,Perlu Follow-up',
        ]);

        JadwalKunjungan::create([
            'kehamilan_id' => $kehamilan->id,
            'tanggal_rencana' => $validated['tanggal_rencana'],
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Jadwal kunjungan berhasil ditambahkan.');
    }

    public function update(Request $request, JadwalKunjungan $jadwal)
    {
        $validated = $request->validate([
            'tanggal_realisasi' => 'nullable|date|before_or_equal:today',
            'status' => 'required|in:Terjadwal,Selesai,Terlewat,Perlu Follow-up',
        ]);

        $jadwal->update($validated);

        return back()->with('success', 'Status jadwal kunjungan diperbarui.');
    }
}
