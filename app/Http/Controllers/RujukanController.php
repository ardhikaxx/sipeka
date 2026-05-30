<?php

namespace App\Http\Controllers;

use App\Models\Rujukan;
use App\Models\CatatanDokter;
use App\Models\Kehamilan;
use App\Models\KunjunganAnc;
use App\Models\FasilitasKesehatan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RujukanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Rujukan::with(['kehamilan.pasien', 'fasilitasTujuan', 'dokter', 'catatanDokter'])
            ->when($user->role === 'bidan', fn ($q) => $q->where('bidan_id', $user->id))
            ->when($user->role === 'dokter', fn ($q) => $q->where(function ($query) use ($user) {
                $query->where('dokter_id', $user->id)->orWhere('fasilitas_tujuan_id', $user->fasilitas_id);
            }));

        $stats = [
            'total' => (clone $query)->count(),
            'menunggu' => (clone $query)->whereIn('status', ['dibuat', 'dikirim'])->count(),
            'diproses' => (clone $query)->where('status', 'diterima')->count(),
            'selesai' => (clone $query)->where('status', 'selesai')->count(),
        ];

        $rujukans = $query->latest()->get();
        return view('rujukan.index', compact('rujukans', 'stats'));
    }

    public function create(Request $request)
    {
        $kunjungan_id = $request->query('kunjungan_id');
        $kunjungan = KunjunganAnc::with(['kehamilan.pasien', 'skriningRisiko'])->findOrFail($kunjungan_id);

        if (! $kunjungan->skriningRisiko || $kunjungan->skriningRisiko->level_risiko === 'HIJAU') {
            return redirect()->route('pasien.show', $kunjungan->kehamilan->pasien_id)
                ->with('error', 'Rujukan hanya dapat dibuat untuk status risiko KUNING atau lebih tinggi.');
        }
        
        $fasilitas = FasilitasKesehatan::where('tipe', '!=', 'Polindes')->get();

        return view('rujukan.create', compact('kunjungan', 'fasilitas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kehamilan_id' => 'required|exists:kehamilans,id',
            'fasilitas_tujuan_id' => 'required|exists:fasilitas_kesehatans,id',
            'diagnosa_sementara' => 'required|string',
            'alasan_rujukan' => 'required|string',
        ]);

        $rujukan = Rujukan::create([
            'kehamilan_id' => $validated['kehamilan_id'],
            'bidan_id' => Auth::id(),
            'fasilitas_tujuan_id' => $validated['fasilitas_tujuan_id'],
            'diagnosa_sementara' => $validated['diagnosa_sementara'],
            'alasan_rujukan' => $validated['alasan_rujukan'],
            'status' => 'dikirim'
        ]);

        $dokter = \App\Models\User::where('role', 'dokter')
            ->where('fasilitas_id', $validated['fasilitas_tujuan_id'])
            ->first();

        if ($dokter) {
            $rujukan->update(['dokter_id' => $dokter->id]);
            Notifikasi::create([
                'user_id' => $dokter->id,
                'judul' => 'Rujukan masuk',
                'pesan' => 'Rujukan baru menunggu verifikasi dokter.',
            ]);
        }

        return redirect()->route('rujukan.index')->with('success', 'Surat rujukan berhasil dibuat.');
    }

    public function show(Rujukan $rujukan)
    {
        $rujukan->load(['kehamilan.pasien', 'kehamilan.kunjunganAncs' => fn ($q) => $q->latest('tanggal')->with('skriningRisiko'), 'fasilitasTujuan', 'bidan', 'dokter', 'catatanDokter']);

        return view('rujukan.show', compact('rujukan'));
    }

    public function terima(Rujukan $rujukan)
    {
        $rujukan->update([
            'status' => 'diterima',
            'dokter_id' => Auth::id(),
        ]);

        Notifikasi::create([
            'user_id' => $rujukan->bidan_id,
            'judul' => 'Rujukan diterima',
            'pesan' => 'Dokter menerima rujukan pasien '.$rujukan->kehamilan->pasien->nama.'.',
        ]);

        return back()->with('success', 'Rujukan sudah diterima.');
    }

    public function catatanBalik(Request $request, Rujukan $rujukan)
    {
        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'resep' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $rujukan) {
            CatatanDokter::updateOrCreate(
                ['rujukan_id' => $rujukan->id],
                [
                    'dokter_id' => Auth::id(),
                    'diagnosis' => $validated['diagnosis'],
                    'resep' => $validated['resep'] ?? null,
                    'catatan' => $validated['catatan'] ?? null,
                ]
            );

            $rujukan->update([
                'status' => 'selesai',
                'dokter_id' => Auth::id(),
            ]);

            Notifikasi::create([
                'user_id' => $rujukan->bidan_id,
                'judul' => 'Catatan balik dokter',
                'pesan' => 'Catatan balik rujukan pasien '.$rujukan->kehamilan->pasien->nama.' sudah tersedia.',
            ]);
        });

        return redirect()->route('rujukan.show', $rujukan)->with('success', 'Catatan dokter berhasil dikirim balik.');
    }
}
