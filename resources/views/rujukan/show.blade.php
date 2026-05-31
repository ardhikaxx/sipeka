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

<div class="row g-3 g-lg-4">
    <div class="col-12 col-lg-8">
        <!-- Digital Referral Letter -->
        <div class="card border-0 shadow-card rounded-xl overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom p-3 p-md-4">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2 gap-md-3">
                        <div class="bg-primary-subtle text-primary p-2 p-md-3 rounded-3">
                            <i class="fas fa-file-medical fs-5"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold small">SURAT RUJUKAN DIGITAL</h6>
                            <div class="text-hint x-small">No: #REF-{{ str_pad($rujukan->id, 6, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                    <div class="text-center text-sm-end">
                        <span class="badge {{ $statusConfig[0] }} {{ $statusConfig[1] }} px-3 py-2 rounded-pill shadow-sm x-small">
                            {{ strtoupper($rujukan->status) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body p-3 p-md-5">
                <!-- Header Letter -->
                <div class="row mb-4 mb-md-5 pb-3 pb-md-4 border-bottom g-3">
                    <div class="col-12 col-md-6 text-center text-md-start">
                        <div class="text-hint x-small uppercase-font mb-2">FASILITAS PENGIRIM</div>
                        <h6 class="fw-bold mb-1 small">{{ $rujukan->bidan->fasilitasKesehatan?->nama ?? 'Unit Pengirim' }}</h6>
                        <div class="text-muted x-small">Bidan: {{ $rujukan->bidan->name }}</div>
                    </div>
                    <div class="col-12 col-md-6 text-center text-md-end">
                        <div class="text-hint x-small uppercase-font mb-2">FASILITAS TUJUAN</div>
                        <h6 class="fw-bold mb-1 text-primary small">{{ $rujukan->fasilitasTujuan->nama }}</h6>
                        <div class="text-muted x-small">Tipe: {{ $rujukan->fasilitasTujuan->tipe }}</div>
                    </div>
                </div>

                <!-- Patient Identity -->
                <div class="mb-4 mb-md-5">
                    <h6 class="section-title mb-3 mb-md-4 border-start border-4 border-primary ps-3 small">IDENTITAS PASIEN</h6>
                    <div class="row g-3 bg-light p-3 p-md-4 rounded-4">
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="text-hint x-small mb-1">Nama Pasien</div>
                            <div class="fw-bold text-dark small">{{ $rujukan->kehamilan->pasien->nama }}</div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="text-hint x-small mb-1">NIK</div>
                            <div class="fw-bold text-dark small">{{ $rujukan->kehamilan->pasien->nik }}</div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="text-hint x-small mb-1">Usia</div>
                            <div class="fw-bold text-dark small">{{ \Carbon\Carbon::parse($rujukan->kehamilan->pasien->tgl_lahir)->age }} Thn</div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="text-hint x-small mb-1">UK</div>
                            <div class="fw-bold text-primary small">{{ $kunjungan?->usia_kehamilan_minggu ?? '-' }} Mg</div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="text-hint x-small mb-1">GPA</div>
                            <div class="fw-bold text-dark small">G{{ $rujukan->kehamilan->gravida }} P{{ $rujukan->kehamilan->para }} A{{ $rujukan->kehamilan->abortus }}</div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="text-hint x-small mb-1">TP</div>
                            <div class="fw-bold text-dark small">{{ \Carbon\Carbon::parse($rujukan->kehamilan->tp)->format('d/m/y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Clinical Findings -->
                <div class="mb-4 mb-md-5">
                    <h6 class="section-title mb-3 mb-md-4 border-start border-4 border-danger ps-3 small">TEMUAN & DIAGNOSA</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="p-3 p-md-4 rounded-4 border border-danger-subtle bg-danger-subtle bg-opacity-10">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="text-hint x-small mb-1">Tekanan Darah</div>
                                        <div class="fw-bold text-danger small">{{ $kunjungan?->tekanan_darah_sistolik ?? '-' }}/{{ $kunjungan?->tekanan_darah_diastolik ?? '-' }} mmHg</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-hint x-small mb-1">Protein Urine</div>
                                        <div class="fw-bold text-danger small">{{ $kunjungan?->protein_urine ?? '-' }}</div>
                                    </div>
                                    <div class="col-12 mt-2 pt-2 border-top border-danger-subtle border-opacity-25">
                                        <div class="text-hint x-small mb-1">Diagnosa Sementara</div>
                                        <div class="fw-bold text-dark small">{{ $rujukan->diagnosa_sementara }}</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-hint x-small mb-1">Alasan & Tindakan</div>
                                        <div class="bg-white p-2 p-md-3 rounded-3 border mt-1">
                                            <p class="mb-0 text-muted x-small" style="white-space: pre-line;">{{ $rujukan->alasan_rujukan }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-4 mt-4 mt-md-5 pt-4 border-top">
                    <button class="btn btn-light border btn-sm w-100 w-sm-auto" onclick="window.print()"><i class="fas fa-print me-2"></i> Cetak</button>
                    <div class="text-center">
                        <div class="text-hint x-small mb-4">Ttd Digital Bidan Pengirim</div>
                        <div class="fw-bold small">{{ $rujukan->bidan->name }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <!-- Action & Feedback Section -->
        @if(auth()->user()->role === 'dokter' && $rujukan->status !== 'selesai')
            <div class="card border-0 shadow-card rounded-xl mb-4 bg-primary text-white overflow-hidden">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 small"><i class="fas fa-stethoscope me-2"></i> Tindakan Dokter</h6>
                    @if($rujukan->status !== 'diterima')
                        <form method="POST" action="{{ route('rujukan.terima', $rujukan) }}" class="mb-3">
                            @csrf @method('PATCH')
                            <button class="btn btn-light text-primary fw-bold w-100 py-3 shadow-sm small">
                                <i class="fas fa-check-circle me-2"></i> TERIMA RUJUKAN
                            </button>
                        </form>
                    @endif
                    <p class="x-small mb-0 opacity-75">Konfirmasi penerimaan rujukan agar faskes pengirim mengetahui pasien sudah dalam penanganan.</p>
                </div>
            </div>

            <div class="card border-0 shadow-card rounded-xl mb-4">
                <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
                    <h6 class="section-title mb-0 small">Form Catatan Balik</h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <form method="POST" action="{{ route('rujukan.catatan-balik', $rujukan) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label x-small fw-bold">Diagnosis Akhir</label>
                            <textarea name="diagnosis" class="form-control-peka x-small" rows="2" required placeholder="Diagnosis pasti...">{{ old('diagnosis', $rujukan->catatanDokter?->diagnosis) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label x-small fw-bold">Resep & Terapi</label>
                            <textarea name="resep" class="form-control-peka x-small" rows="2" placeholder="Daftar obat...">{{ old('resep', $rujukan->catatanDokter?->resep) }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label x-small fw-bold">Pesan untuk Bidan</label>
                            <textarea name="catatan" class="form-control-peka x-small" rows="3" placeholder="Instruksi lanjutan...">{{ old('catatan', $rujukan->catatanDokter?->catatan) }}</textarea>
                        </div>
                        <button class="btn btn-peka-primary w-100 py-3 shadow-sm fw-bold small">
                            <i class="fas fa-paper-plane me-2"></i> KIRIM CATATAN
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- View Catatan Balik -->
        <div class="card border-0 shadow-card rounded-xl mb-4 overflow-hidden">
            <div class="card-header bg-peka-primary-pale py-3 px-3 px-md-4">
                <h6 class="section-title mb-0 text-peka-primary small"><i class="fas fa-reply me-2"></i>Feedback Dokter</h6>
            </div>
            <div class="card-body p-3 p-md-4">
                @if($rujukan->catatanDokter)
                @php $catatan = $rujukan->catatanDokter; @endphp
                    <div class="mb-4">
                        <div class="text-hint uppercase-font mb-1 x-small">DIAGNOSA AKHIR</div>
                        <div class="p-3 bg-light rounded-3 border-start border-4 border-success small fw-bold text-dark">
                            {{ $catatan->diagnosis }}
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="text-hint uppercase-font mb-1 x-small">INSTRUKSI LANJUTAN</div>
                        <div class="p-3 bg-info-subtle bg-opacity-25 rounded-3 border-start border-4 border-info x-small text-dark">
                            {{ $catatan->catatan ?? '-' }}
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="fas fa-user-doctor" style="font-size: 0.8rem;"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="fw-bold x-small text-truncate">{{ $rujukan->dokter->name ?? 'Dokter Spesialis' }}</div>
                                <div class="text-hint x-small text-truncate">{{ $rujukan->fasilitasTujuan->nama }}</div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-state py-4">
                        <i class="fas fa-user-clock fa-2x text-light mb-2 opacity-50"></i>
                        <p class="text-muted x-small mb-0 px-3">Menunggu pemeriksaan dari fasilitas tujuan.</p>
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
