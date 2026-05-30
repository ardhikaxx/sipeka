<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FasilitasKesehatan;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => FasilitasKesehatan::count(),
            'puskesmas' => FasilitasKesehatan::where('tipe', 'Puskesmas')->count(),
            'rs' => FasilitasKesehatan::whereIn('tipe', ['RSUD', 'RSIA'])->count(),
            'lainnya' => FasilitasKesehatan::whereNotIn('tipe', ['Puskesmas', 'RSUD', 'RSIA'])->count(),
        ];

        $fasilitas = FasilitasKesehatan::latest()->paginate(15);

        return view('admin.fasilitas.index', compact('fasilitas', 'stats'));
    }

    public function create()
    {
        return view('admin.fasilitas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
        ]);

        FasilitasKesehatan::create($validated);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas kesehatan berhasil ditambahkan.');
    }
}
