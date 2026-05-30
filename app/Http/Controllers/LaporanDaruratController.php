<?php

namespace App\Http\Controllers;

use App\Models\LaporanDarurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanDaruratController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = LaporanDarurat::with(['pasien', 'bidan'])
            ->when($user->role === 'bidan', fn ($q) => $q->where('bidan_id', $user->id));

        $stats = [
            'total' => (clone $query)->count(),
            'baru' => (clone $query)->where('status', 'Dikirim')->count(),
            'proses' => (clone $query)->where('status', 'Diproses')->count(),
            'selesai' => (clone $query)->where('status', 'Ditangani')->count(),
        ];

        $laporans = $query->latest()->get();

        return view('darurat.index', compact('laporans', 'stats'));
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
