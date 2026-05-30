<?php

namespace App\Http\Controllers;

use App\Models\HasilPersalinan;
use App\Models\KunjunganAnc;
use App\Models\LaporanDarurat;
use App\Models\Pasien;
use App\Models\Peringatan;
use App\Models\Rujukan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'pasien') {
            return redirect()->route('portal.index');
        }

        $pasienQuery = Pasien::query()
            ->with(['kehamilanAktif.kunjunganAncs' => fn ($q) => $q->latest('tanggal')->with('skriningRisiko')])
            ->when($user->role === 'bidan', fn ($q) => $q->where('bidan_id', $user->id))
            ->when($user->role === 'dokter', fn ($q) => $q->whereHas('kehamilans.rujukans', function ($query) use ($user) {
                $query->where('dokter_id', $user->id)
                    ->orWhere('fasilitas_tujuan_id', $user->fasilitas_id);
            }));

        $pasiens = $pasienQuery->latest()->get();

        $pasienTerbaru = $pasiens->take(6)->map(function (Pasien $pasien) {
            $kehamilan = $pasien->kehamilanAktif;
            $kunjungan = $kehamilan?->kunjunganAncs->first();
            $risk = $kunjungan?->skriningRisiko?->level_risiko ?? 'HIJAU';

            return [
                'id' => $pasien->id,
                'kehamilan_id' => $kehamilan?->id,
                'nama' => $pasien->nama,
                'uk' => $kehamilan ? now()->diffInWeeks($kehamilan->hpht) : '-',
                'desa' => str($pasien->alamat)->limit(24),
                'td' => $kunjungan ? $kunjungan->tekanan_darah_sistolik.'/'.$kunjungan->tekanan_darah_diastolik : '-',
                'protein' => $kunjungan?->protein_urine ?? 'Negatif',
                'risiko' => $this->riskClass($risk),
                'risiko_label' => $this->riskLabel($risk),
            ];
        });

        $riskCounts = ['HIJAU' => 0, 'KUNING' => 0, 'MERAH' => 0, 'MERAH_KRITIS' => 0];
        foreach ($pasiens as $pasien) {
            $level = $pasien->kehamilanAktif?->kunjunganAncs->first()?->skriningRisiko?->level_risiko ?? 'HIJAU';
            $riskCounts[$level] = ($riskCounts[$level] ?? 0) + 1;
        }

        $monthlyYellow = [];
        $monthlyRed = [];
        $monthlyRujukan = [];
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->isoFormat('MMM');
            
            $monthlyYellow[] = KunjunganAnc::whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->when($user->role === 'bidan', fn ($q) => $q->where('bidan_id', $user->id))
                ->when($user->role === 'dokter', fn ($q) => $q->whereHas('kehamilan.rujukans', function ($query) use ($user) {
                    $query->where('dokter_id', $user->id)->orWhere('fasilitas_tujuan_id', $user->fasilitas_id);
                }))
                ->whereHas('skriningRisiko', fn ($q) => $q->where('level_risiko', 'KUNING'))
                ->count();
                
            $monthlyRed[] = KunjunganAnc::whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->when($user->role === 'bidan', fn ($q) => $q->where('bidan_id', $user->id))
                ->when($user->role === 'dokter', fn ($q) => $q->whereHas('kehamilan.rujukans', function ($query) use ($user) {
                    $query->where('dokter_id', $user->id)->orWhere('fasilitas_tujuan_id', $user->fasilitas_id);
                }))
                ->whereHas('skriningRisiko', fn ($q) => $q->whereIn('level_risiko', ['MERAH', 'MERAH_KRITIS']))
                ->count();

            $monthlyRujukan[] = Rujukan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->when($user->role === 'bidan', fn ($q) => $q->where('bidan_id', $user->id))
                ->when($user->role === 'dokter', fn ($q) => $q->where(function ($query) use ($user) {
                    $query->where('dokter_id', $user->id)->orWhere('fasilitas_tujuan_id', $user->fasilitas_id);
                }))
                ->count();
        }

        return view('dashboard', [
            'total_pasien' => $pasiens->count(),
            'kunjungan_hari_ini' => KunjunganAnc::whereDate('tanggal', today())
                ->when($user->role === 'bidan', fn ($q) => $q->where('bidan_id', $user->id))
                ->count(),
            'pasien_risiko_tinggi' => ($riskCounts['MERAH'] ?? 0) + ($riskCounts['MERAH_KRITIS'] ?? 0),
            'akan_bersalin' => $pasiens->filter(fn ($pasien) => ($pasien->kehamilanAktif ? now()->diffInWeeks($pasien->kehamilanAktif->hpht) : 0) > 36)->count(),
            'pasien_terbaru' => $pasienTerbaru,
            'risk_counts' => array_values($riskCounts),
            'monthly_labels' => $labels,
            'monthly_yellow' => $monthlyYellow,
            'monthly_red' => $monthlyRed,
            'monthly_rujukan' => $monthlyRujukan,
            'rujukan_masuk' => Rujukan::with(['kehamilan.pasien', 'fasilitasTujuan'])
                ->when($user->role === 'bidan', fn ($q) => $q->where('bidan_id', $user->id))
                ->when($user->role === 'dokter', fn ($q) => $q->where(function ($query) use ($user) {
                    $query->where('dokter_id', $user->id)->orWhere('fasilitas_tujuan_id', $user->fasilitas_id);
                }))
                ->latest()
                ->take(5)
                ->get(),
            'laporan_darurat' => LaporanDarurat::with('pasien')
                ->whereIn('status', ['Dikirim', 'Diproses'])
                ->when($user->role === 'bidan', fn ($q) => $q->where('bidan_id', $user->id))
                ->latest()
                ->take(5)
                ->get(),
            'peringatan_baru' => Peringatan::where('status', 'baru')->count(),
            'hasil_persalinan' => HasilPersalinan::count(),
        ]);
    }

    private function riskClass(string $level): string
    {
        return match ($level) {
            'KUNING' => 'yellow',
            'MERAH' => 'red',
            'MERAH_KRITIS' => 'critical',
            default => 'green',
        };
    }

    private function riskLabel(string $level): string
    {
        return match ($level) {
            'KUNING' => 'Waspada',
            'MERAH' => 'Preeklampsia',
            'MERAH_KRITIS' => 'Kritis',
            default => 'Risiko Rendah',
        };
    }
}
