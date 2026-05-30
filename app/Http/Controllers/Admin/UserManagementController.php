<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FasilitasKesehatan;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => User::whereNot('role', 'pasien')->count(),
            'admin' => User::where('role', 'admin')->count(),
            'dokter' => User::where('role', 'dokter')->count(),
            'bidan' => User::where('role', 'bidan')->count(),
        ];

        $users = User::with('fasilitas')
            ->whereNot('role', 'pasien')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function create()
    {
        $fasilitas = FasilitasKesehatan::orderBy('nama')->get();

        return view('admin.users.create', compact('fasilitas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,dokter,bidan',
            'fasilitas_id' => 'nullable|exists:fasilitas_kesehatans,id',
        ]);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dibuat.');
    }
}
