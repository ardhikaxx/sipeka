@extends('layouts.app')

@section('title', 'Surat Rujukan Digital')
@section('page_title', 'Detail Surat Rujukan')

@section('content')
@php 
    $kunjungan = $rujukan->kehamilan->kunjunganAncs->first(); 
    $statusConfig = [
        'dibuat' => ['bg-warning', 'text-dark', 'Menunggu Verifikasi'],
        'dikirim' => ['bg-warning', 'text-dark', 'Dikirim'],
        'diterima' => ['bg-info', 'text-white', 'Diterima & Diproses'],
        'selesai' => ['bg-success', 'text-white', 'Selesai (Catatan Balik Tersedia)'],
    ][$rujukan->status] ?? ['bg-secondary', 'text-white', 'Unknown'];
@endphp

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Digital Referral Letter -->
        <div class="card border-0 shadow-card rounded-xl overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary-subtle text-primary p-3 rounded-3">
                            <i class="fas fa-file-medical fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">SURAT RUJUKAN DIGITAL</h5>
                            <div class="text-hint">No. Rujukan: #REF-{{ str_pad($rujukan->id, 6, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge {{ $statusConfig[0] }} {{ $statusConfig[1] }} px-3 py-2 rounded-pill shadow-sm">
                            {{ $statusConfig[2] }}
                        </span>
                        <div class="text-hint mt-2">{{ $rujukan->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
            </div>
            <div class="card-body p-4 p-md-5">
                <!-- Header Letter -->
                <div class="row mb-5 pb-4 border-bottom">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="text-hint uppercase-font mb-2" style="font-size: 0.65rem;">FASILITAS PENGIRIM</div>
                        <h6 class="fw-bold mb-1">{{ $rujukan->bidan->fasilitasKesehatan?->nama ?? 'Puskesmas Pengirim' }}</h6>
                        <div class="text-muted small">Bidan: {{ $rujukan->bidan->name }}</div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="text-hint uppercase-font mb-2" style="font-size: 0.65rem;">FASILITAS TUJUAN</div>
                        <h6 class="fw-bold mb-1 text-primary">{{ $rujukan->fasilitasTujuan->nama }}</h6>
                        <div class="text-muted small">Tipe: {{ $rujukan->fasilitasTujuan->tipe }}</div>
                    </div>
                </div>

                <!-- Patient Identity -->
                <div class="mb-5">
                    <h6 class="section-title mb-4 border-start border-4 border-primary ps-3">IDENTITAS PASIEN</h6>
                    <div class="row g-4 bg-light p-4 rounded-4">
                        <div class="col-sm-6 col-md-4">
                            <div class="text-hint small mb-1">Nama Pasien</div>
                            <div class="fw-bold text-dark">{{ $rujukan->kehamilan->pasien->nama }}</div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="text-hint small mb-1">NIK</div>
                            <div class="fw-bold text-dark">{{ $rujukan->kehamilan->pasien->nik }}</div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="text-hint small mb-1">Usia / Tgl Lahir</div>
                            <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($rujukan->kehamilan->pasien->tgl_lahir)->age }} Thn / {{ \Carbon\Carbon::parse($rujukan->kehamilan->pasien->tgl_lahir)->format('d-m-Y') }}</div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="text-hint small mb-1">Usia Kehamilan</div>
                            <div class="fw-bold text-primary">{{ $kunjungan?->usia_kehamilan_minggu ?? '-' }} Minggu</div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="text-hint small mb-1">GPA</div>
                            <div class="fw-bold text-dark">G{{ $rujukan->kehamilan->gravida }} P{{ $rujukan->kehamilan->para }} A{{ $rujukan->kehamilan->abortus }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-hint small mb-1">Taksiran Persalinan</div>
                            <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($rujukan->kehamilan->tp)->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Clinical Findings -->
                <div class="mb-5">
                    <h6 class="section-title mb-4 border-start border-4 border-danger ps-3">TEMUAN KLINIS & DIAGNOSA</h6>
                    <div class="row g-4">
                        <div class="col-md-12">
                            <div class="p-4 rounded-4 border border-danger-subtle bg-danger-subtle bg-opacity-10">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div class="text-hint small mb-1">Tekanan Darah</div>
                                        <div class="h5 fw-bold text-danger mb-0">{{ $kunjungan?->tekanan_darah_sistolik ?? '-' }}/{{ $kunjungan?->tekanan_darah_diastolik ?? '-' }} mmHg</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="text-hint small mb-1">Protein Urine</div>
                                        <div class="h5 fw-bold text-danger mb-0">{{ $kunjungan?->protein_urine ?? '-' }}</div>
                                    </div>
                                    <div class="col-12 mt-4 pt-3 border-top border-danger-subtle border-opacity-25">
                                        <div class="text-hint small mb-1">Diagnosa Sementara</div>
                                        <div class="fw-bold text-dark fs-5">{{ $rujukan->diagnosa_sementara }}</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-hint small mb-1">Alasan Rujukan & Tindakan Awal</div>
                                        <div class="bg-white p-3 rounded-3 border mt-1">
                                            <p class="mb-0 text-muted" style="white-space: pre-line;">{{ $rujukan->alasan_rujukan }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                    <button class="btn btn-light border" onclick="window.print()"><i class="fas fa-print me-2"></i> Cetak Surat</button>
                    <div class="text-center" style="min-width: 150px;">
                        <div class="text-hint small mb-1">Bidan Pengirim</div>
                        <div class="fw-bold mt-4">{{ $rujukan->bidan->name }}</div>
                        <div class="text-muted x-small">Digital Signed</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Action & Feedback Section -->
        @if(auth()->user()->role === 'dokter' && $rujukan->status !== 'selesai')
            <div class="card border-0 shadow-card rounded-xl mb-4 bg-primary text-white overflow-hidden">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-stethoscope me-2"></i> Tindakan Dokter</h6>
                    @if($rujukan->status !== 'diterima')
                        <form method="POST" action="{{ route('rujukan.terima', $rujukan) }}" class="mb-4">
                            @csrf @method('PATCH')
                            <button class="btn btn-light text-primary fw-bold w-100 py-3 shadow-sm">
                                <i class="fas fa-check-circle me-2"></i> TERIMA RUJUKAN
                            </button>
                        </form>
                    @endif
                    
                    <div class="p-3 bg-white bg-opacity-10 rounded-3 border border-white border-opacity-20">
                        <p class="small mb-0">Klik terima rujukan untuk memberi tahu bidan bahwa pasien sedang ditangani di fasilitas Anda.</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-card rounded-xl mb-4">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h6 class="section-title mb-0">Form Catatan Balik</h6>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('rujukan.catatan-balik', $rujukan) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label form-label-required fw-bold">Diagnosis Akhir</label>
                            <textarea name="diagnosis" class="form-control-peka" rows="2" required placeholder="Diagnosis pasti setelah pemeriksaan...">{{ old('diagnosis', $rujukan->catatanDokter?->diagnosis) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Resep & Terapi</label>
                            <textarea name="resep" class="form-control-peka" rows="2" placeholder="Daftar obat atau terapi yang diberikan...">{{ old('resep', $rujukan->catatanDokter?->resep) }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Catatan untuk Bidan</label>
                            <textarea name="catatan" class="form-control-peka" rows="3" placeholder="Instruksi perawatan lanjutan di rumah/puskesmas...">{{ old('catatan', $rujukan->catatanDokter?->catatan) }}</textarea>
                        </div>
                        <button class="btn btn-peka-primary w-100 py-3 shadow-sm">
                            <i class="fas fa-paper-plane me-2"></i> KIRIM CATATAN BALIK
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- View Catatan Balik -->
        <div class="card border-0 shadow-card rounded-xl mb-4 overflow-hidden">
            <div class="card-header bg-peka-primary-pale py-3 px-4">
                <h6 class="section-title mb-0 text-peka-primary"><i class="fas fa-reply me-2"></i>Feedback / Catatan Balik</h6>
            </div>
            <div class="card-body p-4">
                @if($rujukan->catatanDokter)
                @php $catatan = $rujukan->catatanDokter; @endphp
                    <div class="mb-4">
                        <div class="text-hint uppercase-font mb-1" style="font-size: 0.6rem;">DIAGNOSA AKHIR</div>
                        <div class="p-3 bg-light rounded-3 border-start border-4 border-success">
                            <div class="fw-bold text-dark">{{ $catatan->diagnosis }}</div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="text-hint uppercase-font mb-1" style="font-size: 0.6rem;">RESEP & TERAPI</div>
                        <div class="p-3 bg-light rounded-3">
                            <div class="text-muted small" style="white-space: pre-line;">{{ $catatan->resep ?? 'Tidak ada resep tertulis.' }}</div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="text-hint uppercase-font mb-1" style="font-size: 0.6rem;">INSTRUKSI LANJUTAN</div>
                        <div class="p-3 bg-info-subtle bg-opacity-25 rounded-3 border-start border-4 border-info">
                            <div class="text-dark small" style="white-space: pre-line;">{{ $catatan->catatan ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="fas fa-user-doctor" style="font-size: 0.8rem;"></i>
                            </div>
                            <div>
                                <div class="fw-bold small">{{ $rujukan->dokter->name ?? 'Dokter Spesialis' }}</div>
                                <div class="text-hint" style="font-size: 0.65rem;">{{ $rujukan->fasilitasTujuan->nama }}</div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-state py-4">
                        <div class="stat-card__icon bg-light text-muted mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-user-clock fs-4"></i>
                        </div>
                        <p class="text-muted mb-0 px-3">Menunggu pemeriksaan dan catatan balik dari dokter di fasilitas tujuan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .uppercase-font { font-family: var(--font-heading); font-weight: 700; color: var(--gray-500); }
    .x-small { font-size: 0.65rem; }
    @media print {
        .sipeka-sidebar, .sipeka-topbar, .btn, .col-lg-4, .nav-wrapper { display: none !important; }
        .sipeka-main { margin-left: 0 !important; padding: 0 !important; }
        .sipeka-content { padding: 0 !important; }
        .card { border: none !important; box-shadow: none !important; }
        .col-lg-8 { width: 100% !important; }
    }
</style>
@endpush
