@extends('layouts.app')

@section('title', 'Daftar Rujukan')
@section('page_title', 'Rujukan Keluar')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="section-title mb-1">Daftar Rujukan Pasien</h5>
            <p class="text-muted mb-0" style="font-size: 0.875rem;">Pantau status rujukan pasien Anda ke fasilitas rujukan</p>
        </div>
    </div>
</div>

<div class="card border-0 shadow-card rounded-xl">
    <div class="card-body p-4">
        @if($rujukans->isEmpty())
            <div class="empty-state">
                <i class="fas fa-ambulance"></i>
                <h6>Belum ada data rujukan</h6>
                <p>Belum ada rujukan yang dibuat.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 rounded-start">Tanggal</th>
                            <th class="border-0">Pasien</th>
                            <th class="border-0">Fasilitas Tujuan</th>
                            <th class="border-0">Diagnosa</th>
                            <th class="border-0">Status</th>
                            <th class="border-0 rounded-end text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rujukans as $rujukan)
                        <tr>
                            <td>{{ $rujukan->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $rujukan->kehamilan->pasien->nama }}</div>
                                <div style="font-size: 0.75rem" class="text-muted">NIK: {{ $rujukan->kehamilan->pasien->nik }}</div>
                            </td>
                            <td>{{ $rujukan->fasilitasTujuan->nama }}</td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 200px;">{{ $rujukan->diagnosa_sementara }}</span>
                            </td>
                            <td>
                                @if(in_array($rujukan->status, ['dibuat', 'dikirim']))
                                    <span class="badge bg-warning text-dark rounded-pill">Menunggu Verifikasi</span>
                                @elseif($rujukan->status == 'diterima')
                                    <span class="badge bg-success rounded-pill">Diterima</span>
                                @elseif($rujukan->status == 'selesai')
                                    <span class="badge bg-info rounded-pill">Selesai (Ada Catatan Balik)</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('rujukan.show', $rujukan) }}" class="btn btn-sm btn-light border" title="Lihat Surat"><i class="fas fa-eye text-primary"></i></a>
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
