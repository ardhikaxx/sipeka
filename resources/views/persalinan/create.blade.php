@extends('layouts.app')

@section('title', 'Catat Persalinan')
@section('page_title', 'Catat Hasil Persalinan')

@section('content')
<form method="POST" action="{{ route('persalinan.store', $kehamilan) }}" class="card border-0 shadow-card rounded-xl">
    @csrf
    <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
        <h5 class="section-title mb-0">{{ $kehamilan->pasien->nama }}</h5>
    </div>
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label form-label-required">Tanggal Persalinan</label><input type="date" name="tanggal" class="form-control-peka" value="{{ old('tanggal', optional($kehamilan->hasilPersalinan)->tanggal?->format('Y-m-d')) }}" required></div>
            <div class="col-md-4"><label class="form-label form-label-required">Jenis Persalinan</label><select name="jenis" class="form-control-peka" required><option>Normal</option><option>SC</option><option>Vakum</option><option>Forceps</option></select></div>
            <div class="col-md-4"><label class="form-label">Kondisi Ibu</label><input name="kondisi_ibu" class="form-control-peka" value="{{ old('kondisi_ibu', $kehamilan->hasilPersalinan?->kondisi_ibu) }}"></div>
            <div class="col-md-6"><label class="form-label">Indikasi SC</label><input name="indikasi_sc" class="form-control-peka" value="{{ old('indikasi_sc', $kehamilan->hasilPersalinan?->indikasi_sc) }}"></div>
            <div class="col-md-3"><label class="form-label">Berat Bayi</label><div class="input-group-peka"><input type="number" name="bb_bayi" class="form-control-peka" value="{{ old('bb_bayi', $kehamilan->hasilPersalinan?->bb_bayi) }}"><span class="input-unit">gram</span></div></div>
            <div class="col-md-3"><label class="form-label">Panjang Bayi</label><div class="input-group-peka"><input type="number" name="panjang_bayi" class="form-control-peka" value="{{ old('panjang_bayi', $kehamilan->hasilPersalinan?->panjang_bayi) }}"><span class="input-unit">cm</span></div></div>
            <div class="col-md-4"><label class="form-label">Apgar Score</label><input name="apgar_score" class="form-control-peka" placeholder="8/9" value="{{ old('apgar_score', $kehamilan->hasilPersalinan?->apgar_score) }}"></div>
            <div class="col-md-4"><label class="form-label">Kondisi Bayi</label><input name="kondisi_bayi" class="form-control-peka" value="{{ old('kondisi_bayi', $kehamilan->hasilPersalinan?->kondisi_bayi) }}"></div>
            <div class="col-md-4"><label class="form-label">Komplikasi</label><input name="komplikasi" class="form-control-peka" value="{{ old('komplikasi', $kehamilan->hasilPersalinan?->komplikasi) }}"></div>
        </div>
        <div class="text-end mt-4"><button class="btn btn-peka-primary"><i class="fas fa-save"></i> Simpan Persalinan</button></div>
    </div>
</form>
@endsection
