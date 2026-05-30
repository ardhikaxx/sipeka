@extends('layouts.app')

@section('title', 'Laporan Darurat')
@section('page_title', 'Laporan Darurat')

@section('content')
<div class="card border-0 shadow-card rounded-xl">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead><tr><th>Waktu</th><th>Pasien</th><th>Gejala</th><th>Deskripsi</th><th>Status</th><th></th></tr></thead>
                <tbody>
                    @forelse($laporans as $laporan)
                    <tr>
                        <td>{{ $laporan->created_at->format('d M Y H:i') }}</td>
                        <td><div class="fw-bold">{{ $laporan->pasien->nama }}</div><div class="text-hint">{{ $laporan->pasien->no_hp }}</div></td>
                        <td>{{ implode(', ', $laporan->gejala ?? []) }}</td>
                        <td>{{ $laporan->deskripsi ?? '-' }}</td>
                        <td><span class="badge bg-danger">{{ $laporan->status }}</span></td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('darurat.update', $laporan) }}" class="d-inline-flex gap-2">
                                @csrf @method('PUT')
                                <select name="status" class="form-select form-select-sm">
                                    @foreach(['Dikirim','Diproses','Ditangani'] as $status)
                                        <option value="{{ $status }}" @selected($laporan->status === $status)>{{ $status }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-light border"><i class="fas fa-save"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="fas fa-triangle-exclamation"></i><p>Belum ada laporan darurat.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
