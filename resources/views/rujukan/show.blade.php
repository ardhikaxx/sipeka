@extends('layouts.app')

@section('title', 'Detail Rujukan')
@section('page_title', 'Detail Rujukan')

@section('content')
@php $kunjungan = $rujukan->kehamilan->kunjunganAncs->first(); @endphp
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-card rounded-xl mb-4">
            <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                <h5 class="section-title mb-0">Surat Rujukan Digital</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6"><div class="text-hint">Pasien</div><div class="fw-bold">{{ $rujukan->kehamilan->pasien->nama }}</div></div>
                    <div class="col-md-6"><div class="text-hint">NIK</div><div class="fw-bold">{{ $rujukan->kehamilan->pasien->nik }}</div></div>
                    <div class="col-md-6"><div class="text-hint">Fasilitas Tujuan</div><div class="fw-bold">{{ $rujukan->fasilitasTujuan->nama }}</div></div>
                    <div class="col-md-6"><div class="text-hint">Status</div><span class="badge bg-warning text-dark">{{ ucfirst($rujukan->status) }}</span></div>
                    <div class="col-md-6"><div class="text-hint">Usia Kehamilan</div><div class="fw-bold">{{ $kunjungan?->usia_kehamilan_minggu ?? now()->diffInWeeks($rujukan->kehamilan->hpht) }} minggu</div></div>
                    <div class="col-md-6"><div class="text-hint">Tanda Vital Terakhir</div><div class="fw-bold">{{ $kunjungan ? $kunjungan->tekanan_darah_sistolik.'/'.$kunjungan->tekanan_darah_diastolik.' mmHg' : '-' }}</div></div>
                    <div class="col-12"><div class="text-hint">Diagnosa Sementara</div><p class="mb-0">{{ $rujukan->diagnosa_sementara }}</p></div>
                    <div class="col-12"><div class="text-hint">Alasan Rujukan</div><p class="mb-0">{{ $rujukan->alasan_rujukan }}</p></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        @if(auth()->user()->role === 'dokter' && $rujukan->status !== 'selesai')
        <div class="card border-0 shadow-card rounded-xl mb-4">
            <div class="card-body p-4">
                @if($rujukan->status !== 'diterima')
                <form method="POST" action="{{ route('rujukan.terima', $rujukan) }}" class="mb-3">
                    @csrf @method('PATCH')
                    <button class="btn btn-peka-primary w-100"><i class="fas fa-check"></i> Terima Rujukan</button>
                </form>
                @endif
                <form method="POST" action="{{ route('rujukan.catatan-balik', $rujukan) }}">
                    @csrf
                    <label class="form-label form-label-required">Diagnosis Akhir</label>
                    <textarea name="diagnosis" class="form-control-peka mb-3" rows="2" required>{{ old('diagnosis', $rujukan->catatanDokter?->diagnosis) }}</textarea>
                    <label class="form-label">Resep</label>
                    <textarea name="resep" class="form-control-peka mb-3" rows="2">{{ old('resep', $rujukan->catatanDokter?->resep) }}</textarea>
                    <label class="form-label">Catatan Balik</label>
                    <textarea name="catatan" class="form-control-peka mb-3" rows="3">{{ old('catatan', $rujukan->catatanDokter?->catatan) }}</textarea>
                    <button class="btn btn-rujukan w-100"><i class="fas fa-paper-plane"></i> Kirim Catatan Balik</button>
                </form>
            </div>
        </div>
        @endif

        <div class="card border-0 shadow-card rounded-xl">
            <div class="card-header bg-white border-bottom pt-4 pb-3 px-4"><h5 class="section-title mb-0">Catatan Dokter</h5></div>
            <div class="card-body p-4">
                @if($rujukan->catatanDokter)
                    <div class="mb-3"><div class="text-hint">Diagnosis</div><div class="fw-bold">{{ $rujukan->catatanDokter->diagnosis }}</div></div>
                    <div class="mb-3"><div class="text-hint">Resep</div><div>{{ $rujukan->catatanDokter->resep ?? '-' }}</div></div>
                    <div><div class="text-hint">Catatan</div><div>{{ $rujukan->catatanDokter->catatan ?? '-' }}</div></div>
                @else
                    <div class="empty-state py-4"><i class="fas fa-user-doctor"></i><p>Belum ada catatan balik.</p></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
