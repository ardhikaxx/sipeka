@extends('layouts.app')

@section('title', 'Kunjungan ANC')
@section('page_title', 'Kunjungan ANC')

@section('content')
<div class="card border-0 shadow-card rounded-xl">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead><tr><th>Tanggal</th><th>Pasien</th><th>UK</th><th>Tekanan Darah</th><th>Protein</th><th>Status Risiko</th><th></th></tr></thead>
                <tbody>
                    @forelse($kunjungans as $kunjungan)
                    @php
                        $level = $kunjungan->skriningRisiko?->level_risiko ?? 'HIJAU';
                        $badge = $level === 'MERAH_KRITIS' ? 'critical' : ($level === 'MERAH' ? 'red' : ($level === 'KUNING' ? 'yellow' : 'green'));
                    @endphp
                    <tr>
                        <td>{{ $kunjungan->tanggal->format('d M Y') }}</td>
                        <td><div class="fw-bold">{{ $kunjungan->kehamilan->pasien->nama }}</div><div class="text-hint">{{ $kunjungan->kehamilan->pasien->nik }}</div></td>
                        <td>{{ $kunjungan->usia_kehamilan_minggu }} mgg</td>
                        <td>{{ $kunjungan->tekanan_darah_sistolik }}/{{ $kunjungan->tekanan_darah_diastolik }} mmHg</td>
                        <td>{{ $kunjungan->protein_urine }}</td>
                        <td><span class="badge-risk badge-risk--{{ $badge }}">{{ $kunjungan->skriningRisiko?->status ?? 'NORMAL' }}</span></td>
                        <td class="text-end"><a href="{{ route('pasien.show', $kunjungan->kehamilan->pasien) }}" class="btn btn-sm btn-light border"><i class="fas fa-eye"></i></a></td>
                    </tr>
                    @empty
                    <tr><td colspan="7"><div class="empty-state"><i class="fas fa-stethoscope"></i><p>Belum ada data kunjungan.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $kunjungans->links() }}
    </div>
</div>
@endsection
