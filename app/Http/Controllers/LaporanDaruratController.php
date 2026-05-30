<?php

namespace App\Http\Controllers;

use App\Models\LaporanDarurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanDaruratController extends Controller
{
    public function index()
    {
        $laporans = LaporanDarurat::with(['pasien', 'bidan'])
            ->when(Auth::user()->role === 'bidan', fn ($q) => $q->where('bidan_id', Auth::id()))
            ->latest()
            ->get();

        return view('darurat.index', compact('laporans'));
    }

    public function update(Request $request, LaporanDarurat $darurat)
    {
        $validated = $request->validate([
            'status' => 'required|in:Dikirim,Diproses,Ditangani',
        ]);

        $darurat->update($validated);

        return back()->with('success', 'Status laporan darurat diperbarui.');
    }
}
