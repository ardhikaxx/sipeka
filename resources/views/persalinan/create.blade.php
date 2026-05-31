@extends('layouts.app')

@section('title', 'Catat Hasil Persalinan')
@section('page_title', 'Hasil Persalinan')

@section('content')
<div class="row">
    <div class="col-12 col-xl-10 mx-auto">
        <!-- Patient Info Header -->
        <div class="patient-card d-flex flex-column flex-md-row justify-content-start align-items-center gap-2 gap-md-3 border-0 shadow-card mb-4 p-3 p-md-4 text-center text-md-start" style="background: linear-gradient(to right, #ffffff, #fdf2f8);">
            <div class="patient-card__avatar bg-peka-secondary text-white shadow-sm flex-shrink-0" style="width: 54px; height: 54px; font-size: 1.4rem;">
                <i class="fas fa-baby"></i>
            </div>
            <div class="patient-card__info grow w-100">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center align-items-sm-start gap-2">
                    <div>
                        <div class="patient-card__name fw-bold text-dark fs-5 mb-1">{{ $kehamilan->pasien->nama }}</div>
                        <div class="patient-card__meta x-small text-muted">
                            <span><i class="fas fa-id-card me-1"></i> {{ $kehamilan->pasien->nik }}</span>
                            <span class="mx-2 opacity-25">|</span>
                            <span><i class="fas fa-calendar-check me-1"></i> HPHT: {{ \Carbon\Carbon::parse($kehamilan->hpht)->format('d/m/y') }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="badge bg-peka-secondary-light text-peka-secondary px-3 py-2 rounded-pill fw-bold small">
                            G{{ $kehamilan->gravida }} P{{ $kehamilan->para }} A{{ $kehamilan->abortus }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('persalinan.store', $kehamilan) }}">
            @csrf
            
            <div class="row g-3 g-lg-4">
                <div class="col-12 col-lg-7">
                    <!-- Informasi Persalinan -->
                    <div class="card border-0 shadow-card rounded-xl mb-3 mb-lg-4 overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 px-3 px-md-4">
                            <h5 class="section-title mb-0 d-flex align-items-center fs-6">
                                <span class="bg-primary-subtle text-primary p-2 rounded-3 me-3">
                                    <i class="fas fa-notes-medical"></i>
                                </span>
                                Proses Persalinan
                            </h5>
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label form-label-required small fw-bold">Tanggal Salin</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-calendar-alt input-icon"></i>
                                        <input type="date" name="tanggal" class="form-control-peka small" value="{{ old('tanggal', optional($kehamilan->hasilPersalinan)->tanggal?->format('Y-m-d') ?? date('Y-m-d')) }}" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label form-label-required small fw-bold">Metode Salin</label>
                                    <select name="jenis" class="form-control-peka small" required>
                                        @foreach(['Normal', 'SC', 'Vakum', 'Forceps'] as $jenis)
                                            <option value="{{ $jenis }}" @selected(old('jenis', $kehamilan->hasilPersalinan?->jenis) === $jenis)>{{ $jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label small fw-bold">Kondisi Ibu Pasca Salin</label>
                                    <textarea name="kondisi_ibu" class="form-control-peka x-small" rows="2" placeholder="Contoh: Sehat, perlu observasi..."></textarea>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-bold">Indikasi (Jika Ada)</label>
                                    <input type="text" name="indikasi_sc" class="form-control-peka x-small" placeholder="Contoh: Sungsang, PEB" value="{{ old('indikasi_sc') }}">
                                </div>
                                
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-bold">Komplikasi</label>
                                    <input type="text" name="komplikasi" class="form-control-peka x-small" placeholder="Contoh: HPP, Robekan" value="{{ old('komplikasi') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <!-- Informasi Bayi -->
                    <div class="card border-0 shadow-card rounded-xl mb-3 mb-lg-4 overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 px-3 px-md-4">
                            <h5 class="section-title mb-0 d-flex align-items-center fs-6">
                                <span class="bg-secondary-subtle text-peka-secondary p-2 rounded-3 me-3">
                                    <i class="fas fa-baby-carriage"></i>
                                </span>
                                Detail Bayi
                            </h5>
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label small fw-bold">BBL (gram)</label>
                                    <input type="number" name="bb_bayi" class="form-control-peka x-small" value="{{ old('bb_bayi') }}" placeholder="0">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-bold">PB (cm)</label>
                                    <input type="number" name="panjang_bayi" class="form-control-peka x-small" value="{{ old('panjang_bayi') }}" placeholder="0">
                                </div>

                                <div class="col-12">
                                    <label class="form-label small fw-bold">Apgar Score (1'/5')</label>
                                    <input type="text" name="apgar_score" class="form-control-peka x-small" placeholder="Contoh: 8/9" value="{{ old('apgar_score') }}">
                                </div>

                                <div class="col-12">
                                    <label class="form-label small fw-bold">Kondisi Bayi</label>
                                    <textarea name="kondisi_bayi" class="form-control-peka x-small" rows="2" placeholder="Menangis kuat, aktif..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning border-0 shadow-sm rounded-xl d-flex align-items-start p-3 mb-4">
                        <i class="fas fa-exclamation-triangle mt-1 me-2 x-small"></i>
                        <div class="x-small">
                            <strong>Penting:</strong> Simpan hasil salin akan <strong>menutup episode kehamilan</strong> ini secara otomatis.
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-5">
                        <button type="submit" class="btn btn-peka-primary py-3 shadow-sm fw-bold">
                            <i class="fas fa-save me-2"></i> SIMPAN HASIL
                        </button>
                        <a href="{{ route('pasien.show', $kehamilan->pasien_id) }}" class="btn btn-light border py-2 small">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
