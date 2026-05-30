@extends('layouts.app')

@section('title', 'Buat Surat Rujukan')
@section('page_title', 'Pembuatan Rujukan')

@section('content')
<div class="row">
    <div class="col-12 col-xl-10 mx-auto">
        <div class="mb-4">
            <a href="{{ route('pasien.show', $kunjungan->kehamilan->pasien_id) }}" class="text-decoration-none text-muted">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Profil Pasien
            </a>
        </div>

        <!-- Risk Level Warning -->
        @if($kunjungan->skriningRisiko && in_array($kunjungan->skriningRisiko->level_risiko, ['KUNING', 'MERAH', 'MERAH_KRITIS']))
            @php
                $level = $kunjungan->skriningRisiko->level_risiko;
                $alertClass = $level === 'KUNING' ? 'alert-peka--warning' : ($level === 'MERAH_KRITIS' ? 'alert-peka--critical' : 'alert-peka--danger');
                $icon = $level === 'KUNING' ? 'exclamation-triangle' : 'radiation';
            @endphp
            <div class="alert-peka {{ $alertClass }} mb-4 shadow-sm">
                <div class="alert-peka__icon"><i class="fas fa-{{ $icon }}"></i></div>
                <div class="alert-peka__body">
                    <div class="alert-peka__title">Deteksi Risiko: {{ str_replace('_', ' ', $kunjungan->skriningRisiko->status) }}</div>
                    <div class="alert-peka__text">
                        <p class="mb-1">Pasien ini memerlukan rujukan segera berdasarkan faktor berikut:</p>
                        <ul class="mb-0 ps-3">
                        @foreach($kunjungan->skriningRisiko->detail_faktor ?? [] as $faktor)
                            <li><strong>{{ $faktor }}</strong></li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Patient Context Card -->
        <div class="patient-card border-0 shadow-card mb-4 p-4" style="background: linear-gradient(to right, #ffffff, #fdf4f4);">
            <div class="patient-card__avatar bg-danger text-white shadow-sm" style="width: 60px; height: 60px; font-size: 1.5rem;">
                <i class="fas fa-ambulance"></i>
            </div>
            <div class="patient-card__info ms-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="patient-card__name fs-4 mb-1">{{ $kunjungan->kehamilan->pasien->nama }}</div>
                        <div class="patient-card__meta fs-6">
                            <span><i class="fas fa-id-card text-muted me-1"></i> {{ $kunjungan->kehamilan->pasien->nik }}</span>
                            <span class="ms-3"><i class="fas fa-calendar-alt text-muted me-1"></i> UK: {{ $kunjungan->usia_kehamilan_minggu }} Minggu</span>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="badge bg-white text-danger border border-danger-subtle px-3 py-2 rounded-pill fw-bold mb-2">
                            TD: {{ $kunjungan->tekanan_darah_sistolik }}/{{ $kunjungan->tekanan_darah_diastolik }} mmHg
                        </div>
                        <div class="text-hint">MAP: {{ $kunjungan->map }} | Protein: {{ $kunjungan->protein_urine }}</div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('rujukan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kehamilan_id" value="{{ $kunjungan->kehamilan_id }}">
            
            <div class="card border-0 shadow-card rounded-xl mb-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="section-title mb-0 d-flex align-items-center">
                        <span class="bg-primary-subtle text-primary p-2 rounded-3 me-3">
                            <i class="fas fa-file-medical"></i>
                        </span>
                        Formulir Rujukan Digital
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label form-label-required fw-bold">Fasilitas Kesehatan Tujuan</label>
                            <div class="input-group-peka">
                                <i class="fas fa-hospital input-icon"></i>
                                <select name="fasilitas_tujuan_id" class="form-control-peka @error('fasilitas_tujuan_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih RS / Puskesmas Rujukan --</option>
                                    @foreach($fasilitas as $f)
                                        <option value="{{ $f->id }}" @selected(old('fasilitas_tujuan_id') == $f->id)>{{ $f->nama }} ({{ $f->tipe }})</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('fasilitas_tujuan_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label form-label-required fw-bold">Diagnosa Sementara</label>
                            @php
                                $diagnosa_default = '';
                                if ($kunjungan->skriningRisiko && in_array($kunjungan->skriningRisiko->level_risiko, ['KUNING', 'MERAH', 'MERAH_KRITIS'])) {
                                    $diagnosa_default = str_replace('_', ' ', $kunjungan->skriningRisiko->status);
                                }
                            @endphp
                            <div class="input-group-peka">
                                <i class="fas fa-stethoscope input-icon"></i>
                                <input type="text" name="diagnosa_sementara" class="form-control-peka @error('diagnosa_sementara') is-invalid @enderror" value="{{ old('diagnosa_sementara', $diagnosa_default) }}" placeholder="Misal: Preeklampsia Berat" required>
                            </div>
                            @error('diagnosa_sementara') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label form-label-required fw-bold">Alasan Rujukan & Tindakan Awal</label>
                            <textarea name="alasan_rujukan" class="form-control-peka @error('alasan_rujukan') is-invalid @enderror" rows="5" placeholder="Jelaskan kondisi klinis pasien dan tindakan awal (seperti pemberian MgSO4) yang sudah dilakukan..." required>{{ old('alasan_rujukan') }}</textarea>
                            <div class="form-text mt-2 text-muted" style="font-size: 0.75rem;">
                                <i class="fas fa-info-circle me-1"></i> Informasi ini sangat penting untuk dokter di fasilitas tujuan.
                            </div>
                            @error('alasan_rujukan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-card rounded-xl bg-peka-primary text-white p-4 mb-5">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-paper-plane fs-4 me-3"></i>
                    <h6 class="mb-0 fw-bold">Konfirmasi Pengiriman</h6>
                </div>
                <p class="small mb-4 opacity-75">Dengan mengirim rujukan ini, dokter di fasilitas tujuan akan langsung menerima notifikasi dan rekam medis digital pasien.</p>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-light fw-bold text-peka-primary py-3 shadow-sm">
                        <i class="fas fa-paper-plane me-2"></i> KIRIM RUJUKAN SEKARANG
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
