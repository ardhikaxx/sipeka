@extends('layouts.app')

@section('title', 'Detail Pasien')
@section('page_title', 'Rekam Medis Pasien')

@section('content')
<div class="card border-0 shadow-card rounded-xl mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap align-items-center gap-3">
            <div class="patient-card__avatar flex-shrink-0" style="width: 64px; height: 64px; font-size: 2rem;">
                <i class="fas fa-person-pregnant"></i>
            </div>
            <div>
                <h4 class="mb-1">{{ $pasien->nama }}</h4>
                <div class="text-muted" style="font-size: .875rem;">
                    <span><i class="fas fa-id-card me-1"></i>{{ $pasien->nik }}</span>
                    <span class="mx-2">/</span>
                    <span><i class="fas fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($pasien->tgl_lahir)->age }} tahun</span>
                    <span class="mx-2">/</span>
                    <span><i class="fas fa-map-marker-alt me-1"></i>{{ $pasien->alamat }}</span>
                </div>
                <div class="text-hint mt-1">Akun portal: {{ $pasien->user?->email ?? '-' }}</div>
            </div>
            <div class="ms-auto d-flex flex-wrap gap-2">
                @if($kehamilanAktif)
                    <a href="{{ route('kunjungan.create', ['kehamilan_id' => $kehamilanAktif->id]) }}" class="btn btn-peka-primary">
                        <i class="fas fa-plus"></i> Input Kunjungan
                    </a>
                    <a href="{{ route('persalinan.create', $kehamilanAktif) }}" class="btn btn-peka-outline">
                        <i class="fas fa-baby"></i> Persalinan
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@if($kehamilanAktif)
<ul class="nav nav-pills mb-4 gap-2" role="tablist">
    <li class="nav-item"><button class="btn btn-peka-outline active px-4" data-bs-toggle="pill" data-bs-target="#riwayat" type="button">Riwayat Kunjungan</button></li>
    <li class="nav-item"><button class="btn btn-peka-outline px-4" data-bs-toggle="pill" data-bs-target="#grafik" type="button">Grafik Tren</button></li>
    <li class="nav-item"><button class="btn btn-peka-outline px-4" data-bs-toggle="pill" data-bs-target="#jadwal" type="button">Jadwal</button></li>
    <li class="nav-item"><button class="btn btn-peka-outline px-4" data-bs-toggle="pill" data-bs-target="#rujukan" type="button">Rujukan</button></li>
    <li class="nav-item"><button class="btn btn-peka-outline px-4" data-bs-toggle="pill" data-bs-target="#persalinan" type="button">Persalinan</button></li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="riwayat">
        <div class="card border-0 shadow-card rounded-xl">
            <div class="card-body p-4">
                @if($kehamilanAktif->kunjunganAncs->isEmpty())
                    <div class="empty-state"><i class="fas fa-stethoscope"></i><h6>Belum ada riwayat kunjungan</h6><p>Silakan input kunjungan ANC untuk pasien ini.</p></div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th><th>UK</th><th>BB / IMT</th><th>TD / MAP</th><th>Protein</th><th>Status Risiko</th><th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kehamilanAktif->kunjunganAncs as $kunjungan)
                                @php
                                    $level = $kunjungan->skriningRisiko?->level_risiko ?? 'HIJAU';
                                    $badge = $level === 'MERAH_KRITIS' ? 'critical' : ($level === 'MERAH' ? 'red' : ($level === 'KUNING' ? 'yellow' : 'green'));
                                @endphp
                                <tr>
                                    <td>{{ $kunjungan->tanggal->format('d M Y') }}</td>
                                    <td>{{ $kunjungan->usia_kehamilan_minggu }} mgg</td>
                                    <td>{{ $kunjungan->berat_badan }} kg <div class="text-hint">IMT {{ $kunjungan->imt ?? '-' }}</div></td>
                                    <td><span class="vital-chip vital-chip--td">{{ $kunjungan->tekanan_darah_sistolik }}/{{ $kunjungan->tekanan_darah_diastolik }}</span><div class="text-hint">MAP {{ $kunjungan->map }}</div></td>
                                    <td><span class="vital-chip {{ $kunjungan->protein_urine === 'Negatif' ? 'vital-chip--normal' : 'vital-chip--protein' }}">{{ $kunjungan->protein_urine }}</span></td>
                                    <td><span class="badge-risk badge-risk--{{ $badge }}">{{ $kunjungan->skriningRisiko?->status ?? 'NORMAL' }}</span></td>
                                    <td class="text-end">
                                        @if(in_array($level, ['KUNING','MERAH','MERAH_KRITIS'], true))
                                            <a href="{{ route('rujukan.create', ['kunjungan_id' => $kunjungan->id]) }}" class="btn btn-sm btn-rujukan"><i class="fas fa-ambulance"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="grafik">
        <div class="card border-0 shadow-card rounded-xl">
            <div class="card-header bg-white border-bottom pt-4 pb-3 px-4"><h5 class="section-title mb-0">Grafik Tren Tekanan Darah</h5></div>
            <div class="card-body p-4"><canvas id="chartTekananDarah" height="100"></canvas></div>
        </div>
    </div>

    <div class="tab-pane fade" id="jadwal">
        <div class="card border-0 shadow-card rounded-xl">
            <div class="card-header bg-white border-bottom pt-4 pb-3 px-4 d-flex flex-wrap gap-2 justify-content-between align-items-center">
                <h5 class="section-title mb-0">Jadwal Kunjungan</h5>
                <form class="d-flex gap-2" method="POST" action="{{ route('jadwal.store', $kehamilanAktif) }}">
                    @csrf
                    <input type="date" name="tanggal_rencana" class="form-control-peka" required>
                    <input type="hidden" name="status" value="Terjadwal">
                    <button class="btn btn-peka-primary btn-sm" type="submit"><i class="fas fa-plus"></i></button>
                </form>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead><tr><th>Tanggal Rencana</th><th>Status</th><th>Realisasi</th><th></th></tr></thead>
                        <tbody>
                            @foreach($kehamilanAktif->jadwalKunjungans as $jadwal)
                            <tr>
                                <td>{{ $jadwal->tanggal_rencana->format('d M Y') }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $jadwal->status }}</span></td>
                                <td>{{ $jadwal->tanggal_realisasi?->format('d M Y') ?? '-' }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('jadwal.update', $jadwal) }}" class="d-inline-flex gap-2">
                                        @csrf @method('PATCH')
                                        <input type="date" name="tanggal_realisasi" class="form-control form-control-sm" value="{{ optional($jadwal->tanggal_realisasi)->format('Y-m-d') }}">
                                        <select name="status" class="form-select form-select-sm">
                                            @foreach(['Terjadwal','Selesai','Terlewat','Perlu Follow-up'] as $status)
                                                <option value="{{ $status }}" @selected($jadwal->status === $status)>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-sm btn-light border"><i class="fas fa-save"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="rujukan">
        <div class="card border-0 shadow-card rounded-xl">
            <div class="card-body p-4">
                @forelse($kehamilanAktif->rujukans as $rujukan)
                    <div class="patient-card">
                        <div class="patient-card__avatar"><i class="fas fa-ambulance"></i></div>
                        <div class="patient-card__info">
                            <div class="patient-card__name">{{ $rujukan->fasilitasTujuan->nama }}</div>
                            <div class="patient-card__meta"><span>{{ $rujukan->created_at->format('d M Y H:i') }}</span><span>Status: {{ ucfirst($rujukan->status) }}</span></div>
                            <div class="text-muted">{{ $rujukan->diagnosa_sementara }}</div>
                        </div>
                        <a href="{{ route('rujukan.show', $rujukan) }}" class="btn btn-sm btn-peka-outline"><i class="fas fa-eye"></i></a>
                    </div>
                @empty
                    <div class="empty-state"><i class="fas fa-ambulance"></i><p>Belum ada rujukan.</p></div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="persalinan">
        <div class="card border-0 shadow-card rounded-xl">
            <div class="card-body p-4">
                @if($kehamilanAktif->hasilPersalinan)
                    <div class="row g-3">
                        <div class="col-md-3"><div class="vital-card"><div class="vital-card__title">Tanggal</div><div class="fw-bold">{{ $kehamilanAktif->hasilPersalinan->tanggal->format('d M Y') }}</div></div></div>
                        <div class="col-md-3"><div class="vital-card"><div class="vital-card__title">Jenis</div><div class="fw-bold">{{ $kehamilanAktif->hasilPersalinan->jenis }}</div></div></div>
                        <div class="col-md-3"><div class="vital-card"><div class="vital-card__title">Bayi</div><div class="fw-bold">{{ $kehamilanAktif->hasilPersalinan->bb_bayi }} gram</div></div></div>
                        <div class="col-md-3"><div class="vital-card"><div class="vital-card__title">Komplikasi</div><div class="fw-bold">{{ $kehamilanAktif->hasilPersalinan->komplikasi ?? 'Tidak ada' }}</div></div></div>
                    </div>
                @else
                    <a href="{{ route('persalinan.create', $kehamilanAktif) }}" class="btn btn-peka-primary"><i class="fas fa-baby"></i> Catat Hasil Persalinan</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($chartData);
    const canvas = document.getElementById('chartTekananDarah');
    if (!canvas) return;

    new Chart(canvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [
                { label: 'Sistolik', data: chartData.sistolik, borderColor: '#EF4444', backgroundColor: 'rgba(239,68,68,.08)', borderWidth: 2.5, tension: .3, fill: true },
                { label: 'Diastolik', data: chartData.diastolik, borderColor: '#3B5BDB', backgroundColor: 'rgba(59,91,219,.06)', borderWidth: 2.5, tension: .3, fill: true }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            scales: { y: { min: 50, max: 200, ticks: { callback: v => v + ' mmHg' } }, x: { grid: { display: false } } }
        }
    });
});
</script>
@endpush
