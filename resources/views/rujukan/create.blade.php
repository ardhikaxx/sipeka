@extends('layouts.app')

@section('title', 'Buat Surat Rujukan')
@section('page_title', 'Pembuatan Rujukan')

@section('content')
<div class="row">
    <div class="col-12 col-xl-10 mx-auto">
        
        <!-- Peringatan Sistem -->
        @if($kunjungan->skriningRisiko && in_array($kunjungan->skriningRisiko->level_risiko, ['KUNING', 'MERAH', 'MERAH_KRITIS']))
        <div class="alert-peka {{ $kunjungan->skriningRisiko->level_risiko === 'KUNING' ? 'alert-peka--warning' : 'alert-peka--danger' }} mb-4">
            <div class="alert-peka__icon"><i class="fas fa-triangle-exclamation"></i></div>
            <div class="alert-peka__body">
                <div class="alert-peka__title">Alasan Rujukan: {{ str_replace('_', ' ', $kunjungan->skriningRisiko->level_risiko) }}</div>
                <div class="alert-peka__text">
                    <ul>
                    @foreach($kunjungan->skriningRisiko->detail_faktor ?? [] as $faktor)
                        <li>{{ $faktor }}</li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <div class="patient-card border-start-0 mb-4" style="border-left: 4px solid var(--peka-accent) !important;">
            <div class="patient-card__avatar">
                <i class="fas fa-person-pregnant"></i>
            </div>
            <div class="patient-card__info">
                <div class="patient-card__name">{{ $kunjungan->kehamilan->pasien->nama }}</div>
                <div class="patient-card__meta">
                    <span><i class="fas fa-id-card"></i> NIK: {{ $kunjungan->kehamilan->pasien->nik }}</span>
                    <span><i class="fas fa-calendar-alt"></i> Usia Kehamilan: {{ $kunjungan->usia_kehamilan_minggu }} Minggu</span>
                </div>
                <div class="patient-card__vitals mt-2">
                    <span class="vital-chip vital-chip--td">TD Terakhir: {{ $kunjungan->tekanan_darah_sistolik }}/{{ $kunjungan->tekanan_darah_diastolik }} mmHg</span>
                </div>
            </div>
        </div>

        <form action="{{ route('rujukan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kehamilan_id" value="{{ $kunjungan->kehamilan_id }}">
            
            <div class="card border-0 shadow-card rounded-xl mb-4">
                <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                    <h5 class="section-title mb-0"><i class="fas fa-file-medical text-primary me-2"></i>Detail Rujukan</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label form-label-required">Fasilitas Tujuan</label>
                            <select name="fasilitas_tujuan_id" class="form-control-peka @error('fasilitas_tujuan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Fasilitas Tujuan --</option>
                                @foreach($fasilitas as $f)
                                    <option value="{{ $f->id }}">{{ $f->nama }} ({{ $f->tipe }})</option>
                                @endforeach
                            </select>
                            @error('fasilitas_tujuan_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label form-label-required">Diagnosa Sementara</label>
                            @php
                                $diagnosa_default = '';
                                if ($kunjungan->skriningRisiko && in_array($kunjungan->skriningRisiko->level_risiko, ['KUNING', 'MERAH', 'MERAH_KRITIS'])) {
                                    $diagnosa_default = str_replace('_', ' ', $kunjungan->skriningRisiko->status);
                                }
                            @endphp
                            <input type="text" name="diagnosa_sementara" class="form-control-peka @error('diagnosa_sementara') is-invalid @enderror" value="{{ old('diagnosa_sementara', $diagnosa_default) }}" required>
                            @error('diagnosa_sementara') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label form-label-required">Alasan Rujukan Lengkap</label>
                            <textarea name="alasan_rujukan" class="form-control-peka @error('alasan_rujukan') is-invalid @enderror" rows="4" required>{{ old('alasan_rujukan') }}</textarea>
                            <div class="text-hint mt-1">Sertakan tindakan awal yang sudah dilakukan.</div>
                            @error('alasan_rujukan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-5">
                <a href="{{ route('pasien.index') }}" class="btn btn-light border px-4">Batal</a>
                <button type="submit" class="btn btn-rujukan px-4"><i class="fas fa-paper-plane me-2"></i>Kirim Rujukan</button>
            </div>
        </form>
    </div>
</div>
@endsection
