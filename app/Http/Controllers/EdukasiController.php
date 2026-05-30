<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use Illuminate\Http\Request;

class EdukasiController extends Controller
{
    public function index()
    {
        $edukasis = Edukasi::latest('published_at')->latest()->get();

        return view('edukasi.index', compact('edukasis'));
    }

    public function create()
    {
        return view('edukasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'thumbnail' => 'nullable|string|max:255',
            'konten' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        Edukasi::create($validated);

        return redirect()->route('edukasi.index')->with('success', 'Konten edukasi berhasil disimpan.');
    }

    public function show(Edukasi $edukasi)
    {
        return view('edukasi.show', compact('edukasi'));
    }
}
