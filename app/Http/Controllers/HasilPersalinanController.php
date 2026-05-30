<?php

namespace App\Http\Controllers;

use App\Models\HasilPersalinan;
use App\Models\Kehamilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilPersalinanController extends Controller
{
    public function create(Kehamilan $kehamilan)
    {
        $kehamilan->load('pasien', 'hasilPersalinan');

        return view('persalinan.create', compact('kehamilan'));
    }

    public function store(Request $request, Kehamilan $kehamilan)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date|before_or_equal:today',
            'jenis' => 'required|in:Normal,SC,Vakum,Forceps',
            'indikasi_sc' => 'nullable|string',
            'kondisi_ibu' => 'nullable|string|max:255',
            'bb_bayi' => 'nullable|integer|min:300|max:7000',
            'panjang_bayi' => 'nullable|integer|min:20|max:70',
            'apgar_score' => 'nullable|string|max:20',
            'kondisi_bayi' => 'nullable|string|max:100',
            'komplikasi' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($kehamilan, $validated) {
            HasilPersalinan::updateOrCreate(['kehamilan_id' => $kehamilan->id], $validated);
            $kehamilan->update(['status' => 'selesai']);
        });

        return redirect()->route('pasien.show', $kehamilan->pasien_id)->with('success', 'Hasil persalinan berhasil dicatat dan episode kehamilan ditutup.');
    }
}
