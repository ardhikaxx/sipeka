@extends('layouts.app')

@section('title', 'Catat Hasil Persalinan')
@section('page_title', 'Hasil Persalinan')

@section('content')
<div class="row">
    <div class="col-12 col-xl-10 mx-auto">
        <!-- Patient Info Header -->
        <div class="patient-card border-0 shadow-card mb-4 p-4" style="background: linear-gradient(to right, #ffffff, #fdf2f8);">
            <div class="patient-card__avatar bg-peka-secondary text-white shadow-sm" style="width: 60px; height: 60px; font-size: 1.5rem;">
                <i class="fas fa-baby"></i>
            </div>
            <div class="patient-card__info ms-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="patient-card__name fs-4 mb-1">{{ $kehamilan->pasien->nama }}</div>
                        <div class="patient-card__meta fs-6">
                            <span><i class="fas fa-id-card text-muted me-1"></i> NIK: {{ $kehamilan->pasien->nik }}</span>
                            <span class="ms-3"><i class="fas fa-calendar-check text-muted me-1"></i> HPHT: {{ \Carbon\Carbon::parse($kehamilan->hpht)->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="badge bg-peka-secondary-light text-peka-secondary px-3 py-2 rounded-pill fw-bold mb-2">
                            Episode: G{{ $kehamilan->gravida }} P{{ $kehamilan->para }} A{{ $kehamilan->abortus }}
                        </div>
                        <div class="text-hint">Taksiran Persalinan: {{ \Carbon\Carbon::parse($kehamilan->tp)->format('d/m/Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('persalinan.store', $kehamilan) }}">
            @csrf
            
            <div class="row">
                <div class="col-lg-7">
                    <!-- Informasi Persalinan -->
                    <div class="card border-0 shadow-card rounded-xl mb-4">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h5 class="section-title mb-0 d-flex align-items-center">
                                <span class="bg-primary-subtle text-primary p-2 rounded-3 me-3">
                                    <i class="fas fa-notes-medical"></i>
                                </span>
                                Informasi Persalinan
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label form-label-required">Tanggal Persalinan</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-calendar-alt input-icon"></i>
                                        <input type="date" name="tanggal" class="form-control-peka" value="{{ old('tanggal', optional($kehamilan->hasilPersalinan)->tanggal?->format('Y-m-d') ?? date('Y-m-d')) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label form-label-required">Metode Persalinan</label>
                                    <select name="jenis" class="form-control-peka" required>
                                        @foreach(['Normal', 'SC', 'Vakum', 'Forceps'] as $jenis)
                                            <option value="{{ $jenis }}" @selected(old('jenis', $kehamilan->hasilPersalinan?->jenis) === $jenis)>{{ $jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Kondisi Ibu Pasca Salin</label>
                                    <textarea name="kondisi_ibu" class="form-control-peka" rows="2" placeholder="Contoh: Sehat, perlu observasi perdarahan...">{{ old('kondisi_ibu', $kehamilan->hasilPersalinan?->kondisi_ibu) }}</textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Indikasi (Jika SC/Tindakan)</label>
                                    <input type="text" name="indikasi_sc" class="form-control-peka" placeholder="Contoh: Letak sungsang, PEB, Gawat janin" value="{{ old('indikasi_sc', $kehamilan->hasilPersalinan?->indikasi_sc) }}">
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label">Komplikasi Persalinan</label>
                                    <input type="text" name="komplikasi" class="form-control-peka" placeholder="Contoh: HPP, Robekan jalan lahir derajat 3" value="{{ old('komplikasi', $kehamilan->hasilPersalinan?->komplikasi) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <!-- Informasi Bayi -->
                    <div class="card border-0 shadow-card rounded-xl mb-4">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h5 class="section-title mb-0 d-flex align-items-center">
                                <span class="bg-secondary-subtle text-peka-secondary p-2 rounded-3 me-3">
                                    <i class="fas fa-baby-carriage"></i>
                                </span>
                                Detail Bayi
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Berat Badan Lahir</label>
                                    <div class="input-group-peka">
                                        <input type="number" name="bb_bayi" class="form-control-peka" value="{{ old('bb_bayi', $kehamilan->hasilPersalinan?->bb_bayi) }}" placeholder="0">
                                        <span class="input-unit">gram</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Panjang Badan</label>
                                    <div class="input-group-peka">
                                        <input type="number" name="panjang_bayi" class="form-control-peka" value="{{ old('panjang_bayi', $kehamilan->hasilPersalinan?->panjang_bayi) }}" placeholder="0">
                                        <span class="input-unit">cm</span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Apgar Score (1' / 5')</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-star-of-life input-icon"></i>
                                        <input type="text" name="apgar_score" class="form-control-peka" placeholder="Contoh: 8/9 atau 7/8/9" value="{{ old('apgar_score', $kehamilan->hasilPersalinan?->apgar_score) }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Kondisi Bayi</label>
                                    <textarea name="kondisi_bayi" class="form-control-peka" rows="2" placeholder="Contoh: Menangis kuat, gerak aktif, kemerahan">{{ old('kondisi_bayi', $kehamilan->hasilPersalinan?->kondisi_bayi) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning border-0 shadow-sm rounded-xl d-flex align-items-start p-3">
                        <i class="fas fa-exclamation-triangle mt-1 me-3"></i>
                        <div class="small">
                            <strong>Penting:</strong> Menyimpan hasil persalinan akan secara otomatis <strong>menutup episode kehamilan ini</strong> (Status: Selesai).
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-5">
                        <button type="submit" class="btn btn-peka-primary py-3 shadow-sm">
                            <i class="fas fa-save me-2"></i> SIMPAN HASIL PERSALINAN
                        </button>
                        <a href="{{ route('pasien.show', $kehamilan->pasien_id) }}" class="btn btn-light border py-2">Batal & Kembali</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
