@extends('layouts.app')

@section('title', 'Data Pasien')
@section('page_title', 'Data Ibu Hamil')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="section-title mb-1">Daftar Pasien Binaan</h5>
            <p class="text-muted mb-0" style="font-size: 0.875rem;">Kelola data ibu hamil di wilayah Anda</p>
        </div>
        <a href="{{ route('pasien.create') }}" class="btn btn-peka-primary">
            <i class="fas fa-plus"></i> Registrasi Pasien Baru
        </a>
    </div>
</div>

<div class="card border-0 shadow-card rounded-xl">
    <div class="card-body p-4">
        @if($pasiens->isEmpty())
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <h6>Belum ada data pasien</h6>
                <p>Silakan registrasi pasien baru untuk mulai memantau.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 rounded-start">NIK</th>
                            <th class="border-0">Nama Pasien</th>
                            <th class="border-0">Usia Kandungan</th>
                            <th class="border-0">Alamat</th>
                            <th class="border-0">Kontak</th>
                            <th class="border-0 rounded-end text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pasiens as $pasien)
                        @php
                            $kehamilanAktif = $pasien->kehamilans->first();
                            $uk = $kehamilanAktif ? round(\Carbon\Carbon::parse($kehamilanAktif->hpht)->diffInWeeks(now())) : '-';
                        @endphp
                        <tr>
                            <td>
                                <span class="text-secondary" style="font-family: var(--font-mono)">{{ $pasien->nik }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $pasien->nama }}</div>
                                <div style="font-size: 0.75rem" class="text-muted">{{ \Carbon\Carbon::parse($pasien->tgl_lahir)->age }} tahun</div>
                            </td>
                            <td>
                                @if($uk !== '-')
                                    <span class="badge bg-primary rounded-pill">{{ $uk }} Minggu</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 150px;">{{ $pasien->alamat }}</span>
                            </td>
                            <td>{{ $pasien->no_hp ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('pasien.show', $pasien->id) }}" class="btn btn-sm btn-light border" title="Lihat Rekam Medis"><i class="fas fa-eye text-primary"></i></a>
                                @if($kehamilanAktif)
                                <a href="{{ route('kunjungan.create', ['kehamilan_id' => $kehamilanAktif->id]) }}" class="btn btn-sm btn-light border" title="Input Kunjungan"><i class="fas fa-stethoscope text-success"></i></a>
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
@endsection
