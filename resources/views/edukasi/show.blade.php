@extends('layouts.app')

@section('title', $edukasi->judul)
@section('page_title', 'Edukasi')

@section('content')
<article class="card border-0 shadow-card rounded-xl">
    <div class="card-body p-4 p-lg-5">
        <span class="badge bg-light text-dark border mb-3">{{ $edukasi->kategori }}</span>
        <h2 class="mb-3">{{ $edukasi->judul }}</h2>
        <div class="text-muted mb-4">{{ optional($edukasi->published_at)->format('d M Y') }}</div>
        <div style="font-size: 1rem; line-height: 1.8;">{!! nl2br(e($edukasi->konten)) !!}</div>
    </div>
</article>
@endsection
