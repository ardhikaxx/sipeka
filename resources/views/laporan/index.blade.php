@extends('layouts.app')

@section('title', 'Laporan')
@section('page_title', 'Laporan')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3"><div class="stat-card"><div class="stat-card__icon" style="background:#E8F5F5;color:var(--peka-primary)"><i class="fas fa-users-line"></i></div><div><div class="stat-card__number">{{ $totalPasien }}</div><div class="stat-card__label">Total Pasien</div></div></div></div>
    <div class="col-md-3"><div class="stat-card"><div class="stat-card__icon" style="background:#EEF2FF;color:#3B5BDB"><i class="fas fa-stethoscope"></i></div><div><div class="stat-card__number">{{ $totalKunjungan }}</div><div class="stat-card__label">Kunjungan ANC</div></div></div></div>
    <div class="col-md-3"><div class="stat-card"><div class="stat-card__icon" style="background:#FFFBEB;color:#F59E0B"><i class="fas fa-ambulance"></i></div><div><div class="stat-card__number">{{ $totalRujukan }}</div><div class="stat-card__label">Rujukan</div></div></div></div>
    <div class="col-md-3"><div class="stat-card"><div class="stat-card__icon" style="background:#FDEEF6;color:var(--peka-secondary)"><i class="fas fa-baby"></i></div><div><div class="stat-card__number">{{ $totalPersalinan }}</div><div class="stat-card__label">Persalinan</div></div></div></div>
</div>
<div class="card border-0 shadow-card rounded-xl">
    <div class="card-header bg-white border-bottom pt-4 pb-3 px-4"><h5 class="section-title mb-0">Rujukan Terbaru</h5></div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead><tr><th>Tanggal</th><th>Pasien</th><th>Tujuan</th><th>Status</th><th>Diagnosa</th></tr></thead>
                <tbody>
                    @foreach($rujukans as $rujukan)
                    <tr><td>{{ $rujukan->created_at->format('d M Y') }}</td><td>{{ $rujukan->kehamilan->pasien->nama }}</td><td>{{ $rujukan->fasilitasTujuan->nama }}</td><td>{{ ucfirst($rujukan->status) }}</td><td>{{ $rujukan->diagnosa_sementara }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
