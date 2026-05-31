<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Kehamilan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PasienController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Pasien::query()
            ->when($user->role === 'bidan', fn ($q) => $q->where('bidan_id', $user->id))
            ->when($user->role === 'dokter', fn ($q) => $q->whereHas('kehamilans.rujukans', function ($q) use ($user) {
                $q->where('dokter_id', $user->id)
                    ->orWhere('fasilitas_tujuan_id', $user->fasilitas_id);
            }));

        $stats = [
            'total' => (clone $query)->count(),
            'risiko_tinggi' => (clone $query)->whereHas('kehamilanAktif.kunjunganAncs.skriningRisiko', function($q) {
                $q->whereIn('level_risiko', ['MERAH', 'MERAH_KRITIS']);
            })->count(),
            'perlu_kunjungan' => (clone $query)->whereHas('kehamilanAktif.jadwalKunjungans', function($q) {
                $q->where('tanggal_rencana', '<=', now())->where('status', 'Terjadwal');
            })->count(),
        ];

        $pasiens = $query->with(['kehamilans' => function($q) {
                $q->where('status', 'aktif')->latest();
            }, 'kehamilanAktif.kunjunganAncs.skriningRisiko'])
            ->latest()
            ->paginate(15);

        return view('pasien.index', compact('pasiens', 'stats'));
    }

    public function create()
    {
        return view('pasien.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:pasiens,nik',
            'nama' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_hp' => 'nullable|string|max:20',
            'tinggi_badan' => 'nullable|numeric|min:120|max:200',
            'golongan_darah' => 'nullable|string|max:5',
            'status_pernikahan' => 'nullable|string|max:50',
            'nama_suami' => 'nullable|string|max:255',
            
            // Kehamilan Data
            'hpht' => 'required|date',
            'gravida' => 'required|integer|min:1',
            'para' => 'required|integer|min:0',
            'abortus' => 'required|integer|min:0',
        ]);

        $pasien = DB::transaction(function () use ($validated, $request) {
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['nik'].'@sipeka.local',
                'password' => 'password',
                'role' => 'pasien',
            ]);

            $pasien = Pasien::create([
                'user_id' => $user->id,
                'nik' => $validated['nik'],
                'nama' => $validated['nama'],
                'tgl_lahir' => $validated['tgl_lahir'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'] ?? null,
                'tinggi_badan' => $validated['tinggi_badan'] ?? null,
                'golongan_darah' => $validated['golongan_darah'] ?? null,
                'status_pernikahan' => $validated['status_pernikahan'] ?? null,
                'nama_suami' => $validated['nama_suami'] ?? null,
                'bidan_id' => Auth::id(),
            ]);

            $hpht = Carbon::parse($validated['hpht']);

            Kehamilan::create([
                'pasien_id' => $pasien->id,
                'hpht' => $validated['hpht'],
                'tp' => $hpht->copy()->addDays(280)->format('Y-m-d'),
                'gravida' => $validated['gravida'],
                'para' => $validated['para'],
                'abortus' => $validated['abortus'],
                'riwayat_preeklampsia' => $request->boolean('riwayat_preeklampsia'),
                'riwayat_hipertensi' => $request->boolean('riwayat_hipertensi'),
                'riwayat_diabetes' => $request->boolean('riwayat_diabetes'),
                'riwayat_ginjal' => $request->boolean('riwayat_ginjal'),
                'riwayat_bblr' => $request->boolean('riwayat_bblr'),
                'keluarga_preeklampsia' => $request->boolean('keluarga_preeklampsia'),
                'kehamilan_kembar' => $request->boolean('kehamilan_kembar'),
                'nullipara' => (int) $validated['gravida'] === 1,
                'interval_lebih_10' => $request->boolean('interval_lebih_10'),
                'status' => 'aktif',
            ]);

            return $pasien;
        });

        return redirect()->route('pasien.show', $pasien)->with('success', 'Pasien baru berhasil didaftarkan. Akun portal: '.$validated['nik'].'@sipeka.local / password');
    }

    public function show(Pasien $pasien)
    {
        $this->authorizePasienAccess($pasien);

        $pasien->load(['kehamilans' => function ($query) {
            $query->orderBy('created_at', 'desc')->with(['kunjunganAncs' => function ($q) {
                $q->orderBy('tanggal', 'asc')->with('skriningRisiko');
            }, 'rujukans.fasilitasTujuan', 'rujukans.catatanDokter', 'jadwalKunjungans', 'hasilPersalinan']);
        }]);

        $kehamilanAktif = $pasien->kehamilans->first();
        $chartData = [
            'labels' => [],
            'sistolik' => [],
            'diastolik' => [],
            'tfu' => [],
            'djj' => []
        ];

        if ($kehamilanAktif) {
            foreach ($kehamilanAktif->kunjunganAncs as $kunjungan) {
                $chartData['labels'][] = $kunjungan->tanggal->format('d M');
                $chartData['sistolik'][] = $kunjungan->tekanan_darah_sistolik;
                $chartData['diastolik'][] = $kunjungan->tekanan_darah_diastolik;
                $chartData['tfu'][] = $kunjungan->tinggi_fundus_uteri;
                $chartData['djj'][] = $kunjungan->djj;
            }
        }

        return view('pasien.show', compact('pasien', 'kehamilanAktif', 'chartData'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $this->authorizePasienAccess($pasien);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:pasiens,nik,' . $pasien->id,
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_hp' => 'nullable|string|max:20',
            'tinggi_badan' => 'nullable|numeric|min:120|max:200',
            'golongan_darah' => 'nullable|string|max:5',
            'status_pernikahan' => 'nullable|string|max:50',
            'nama_suami' => 'nullable|string|max:255',
        ]);

        $pasien->update($validated);

        if ($pasien->user) {
            $pasien->user->update([
                'name' => $validated['nama'],
            ]);
        }

        return redirect()->route('pasien.show', $pasien)->with('success', 'Data profil pasien berhasil diperbarui.');
    }

    private function authorizePasienAccess(Pasien $pasien): void
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return;
        }

        if ($user->role === 'bidan' && $pasien->bidan_id === $user->id) {
            return;
        }

        if ($user->role === 'dokter' && $pasien->kehamilans()
            ->whereHas('rujukans', fn ($q) => $q->where('dokter_id', $user->id)->orWhere('fasilitas_tujuan_id', $user->fasilitas_id))
            ->exists()) {
            return;
        }

        abort(403, 'Anda tidak memiliki akses ke pasien ini.');
    }
}
