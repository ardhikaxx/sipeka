<?php

namespace App\Http\Controllers;

use App\Models\Kehamilan;
use App\Models\KunjunganAnc;
use App\Models\Notifikasi;
use App\Models\Peringatan;
use App\Models\SkriningRisiko;
use App\Services\SkriningRisikoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KunjunganAncController extends Controller
{
    protected $skriningService;

    public function __construct(SkriningRisikoService $skriningService)
    {
        $this->skriningService = $skriningService;
    }

    public function index()
    {
        $query = KunjunganAnc::with(['kehamilan.pasien', 'skriningRisiko'])
            ->when(Auth::user()->role === 'bidan', fn ($q) => $q->where('bidan_id', Auth::id()))
            ->when(Auth::user()->role === 'dokter', fn ($q) => $q->whereHas('kehamilan.rujukans', function ($query) {
                $query->where('dokter_id', Auth::id())
                    ->orWhere('fasilitas_tujuan_id', Auth::user()->fasilitas_id);
            }));

        $stats = [
            'total' => (clone $query)->count(),
            'rendah' => (clone $query)->whereHas('skriningRisiko', fn($q) => $q->where('level_risiko', 'HIJAU'))->count(),
            'sedang' => (clone $query)->whereHas('skriningRisiko', fn($q) => $q->where('level_risiko', 'KUNING'))->count(),
            'tinggi' => (clone $query)->whereHas('skriningRisiko', fn($q) => $q->whereIn('level_risiko', ['MERAH', 'MERAH_KRITIS']))->count(),
        ];

        $kunjungans = $query->latest('tanggal')->paginate(15);

        return view('kunjungan.index', compact('kunjungans', 'stats'));
    }

    public function create(Request $request)
    {
        $kehamilan_id = $request->query('kehamilan_id');
        $kehamilan = Kehamilan::with(['pasien', 'kunjunganAncs' => fn ($q) => $q->latest('tanggal')])->findOrFail($kehamilan_id);

        if (Auth::user()->role === 'bidan' && $kehamilan->pasien->bidan_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pasien ini.');
        }

        return view('kunjungan.create', compact('kehamilan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kehamilan_id' => 'required|exists:kehamilans,id',
            'tanggal' => 'required|date|before_or_equal:today',
            'usia_kehamilan_minggu' => 'required|integer|min:4|max:42',
            'berat_badan' => 'required|numeric|min:30|max:200',
            'tekanan_darah_sistolik' => 'required|integer|min:60|max:250',
            'tekanan_darah_diastolik' => 'required|integer|min:40|max:150|lt:tekanan_darah_sistolik',
            'nadi' => 'required|integer|min:40|max:200',
            'suhu' => 'nullable|numeric|min:34|max:42',
            'respirasi' => 'nullable|integer|min:8|max:40',
            'tinggi_fundus_uteri' => 'required|integer|min:0|max:50',
            'djj' => 'required|integer|min:80|max:200',
            'edema' => 'required|in:Tidak,+1,+2,+3',
            'protein_urine' => 'required|in:Negatif,+1,+2,+3,+4',
            'glukosa_urine' => 'nullable|in:Negatif,Positif',
            'hb' => 'nullable|numeric|min:3|max:20',
            'trombosit' => 'nullable|integer|min:10000|max:1000000',
            'kreatinin' => 'nullable|numeric|min:0|max:20',
            'sgot' => 'nullable|integer|min:0|max:2000',
            'sgpt' => 'nullable|integer|min:0|max:2000',
            'keluhan_subjektif' => 'nullable|string',
            'catatan_bidan' => 'nullable|string',
        ]);

        $validated['ada_riwayat_kejang'] = $request->boolean('ada_riwayat_kejang');
        $validated['nyeri_kepala_hebat'] = $request->boolean('nyeri_kepala_hebat');
        $validated['gangguan_penglihatan'] = $request->boolean('gangguan_penglihatan');
        $validated['nyeri_ulu_hati'] = $request->boolean('nyeri_ulu_hati');
        $validated['edema_paru'] = $request->boolean('edema_paru');

        $kehamilan = Kehamilan::with(['pasien', 'kunjunganAncs' => fn ($q) => $q->latest('tanggal')])
            ->findOrFail($validated['kehamilan_id']);

        $previousVisit = $kehamilan->kunjunganAncs->first();
        $map = ($validated['tekanan_darah_sistolik'] + (2 * $validated['tekanan_darah_diastolik'])) / 3;
        $tinggiMeter = $kehamilan->pasien->tinggi_badan ? $kehamilan->pasien->tinggi_badan / 100 : null;
        $imt = $tinggiMeter ? $validated['berat_badan'] / ($tinggiMeter * $tinggiMeter) : null;
        $penambahanBb = $previousVisit ? $validated['berat_badan'] - $previousVisit->berat_badan : null;

        try {
            $result = DB::transaction(function () use ($validated, $kehamilan, $map, $imt, $penambahanBb) {
                $kunjungan = KunjunganAnc::create(array_merge($validated, [
                    'bidan_id' => Auth::id(),
                    'map' => round($map, 2),
                    'imt' => $imt ? round($imt, 2) : null,
                    'penambahan_bb' => ! is_null($penambahanBb) ? round($penambahanBb, 2) : null,
                ]));

                $risiko = $this->skriningService->hitungRisiko($validated);

                SkriningRisiko::create([
                    'kunjungan_id' => $kunjungan->id,
                    'status' => $risiko['status'],
                    'level_risiko' => $risiko['level'],
                    'detail_faktor' => $risiko['peringatan'],
                ]);

                if (in_array($risiko['level'], ['KUNING', 'MERAH', 'MERAH_KRITIS'], true)) {
                    Peringatan::create([
                        'pasien_id' => $kehamilan->pasien_id,
                        'kunjungan_id' => $kunjungan->id,
                        'level' => $risiko['level'],
                        'deskripsi' => implode('; ', $risiko['peringatan']),
                        'status' => 'baru',
                    ]);
                }

                if (in_array($risiko['level'], ['MERAH', 'MERAH_KRITIS'], true)) {
                    Notifikasi::create([
                        'user_id' => $kehamilan->pasien->bidan_id,
                        'judul' => 'Peringatan risiko tinggi',
                        'pesan' => $kehamilan->pasien->nama.' terdeteksi '.$risiko['status'].'. Pertimbangkan rujukan segera.',
                    ]);
                }

                return compact('kunjungan', 'risiko');
            });
        } catch (\Illuminate\Database\QueryException $exception) {
            return back()->withInput()->withErrors(['tanggal' => 'Kunjungan untuk pasien ini pada tanggal tersebut sudah dicatat.']);
        }

        $statusMsg = 'Kunjungan berhasil disimpan. Status risiko: '.str_replace('_', ' ', $result['risiko']['status']);

        if (in_array($result['risiko']['level'], ['MERAH', 'MERAH_KRITIS'], true)) {
            return redirect()
                ->route('rujukan.create', ['kunjungan_id' => $result['kunjungan']->id])
                ->with('risk_alert', $result['risiko']);
        }

        return redirect()->route('pasien.show', $kehamilan->pasien_id)->with('success', $statusMsg);
    }

    public function show(KunjunganAnc $kunjungan)
    {
        $kunjungan->load(['kehamilan.pasien', 'skriningRisiko', 'bidan.fasilitas']);
        
        return view('kunjungan.show', compact('kunjungan'));
    }
}
