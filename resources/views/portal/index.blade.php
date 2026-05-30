@extends('layouts.app')

@section('title', 'Portal Pasien')
@section('page_title', 'Ringkasan Kesehatan Saya')

@section('content')
<style>
    .portal-header {
        background: linear-gradient(135deg, var(--peka-secondary-light) 0%, white 100%);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 24px;
        border: 1px solid rgba(232, 67, 147, 0.1);
    }
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--gray-200);
    }
    .timeline-item {
        position: relative;
        margin-bottom: 24px;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -30px;
        top: 4px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: white;
        border: 3px solid var(--peka-primary);
        z-index: 2;
    }
    .timeline-item.risk-merah::before { border-color: var(--risk-red); }
    .timeline-item.risk-kuning::before { border-color: var(--risk-yellow); }
    .btn-float-emergency {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
        box-shadow: 0 10px 25px rgba(220, 38, 38, 0.4);
    }
    /* Hide sidebar for patient portal to make it more spacious */
    @media (min-width: 993px) {
        body.portal-mode .sipeka-sidebar { display: none !important; }
        body.portal-mode .sipeka-main { margin-left: 0 !important; }
    }
</style>

<script>
    // Add class to body to hide sidebar in large screens for patient portal
    document.body.classList.add('portal-mode');
</script>

<div class="row">
    <div class="col-12 col-xl-10 mx-auto">
        
        <div class="portal-header d-flex align-items-center gap-4">
            <div class="patient-card__avatar flex-shrink-0" style="width: 80px; height: 80px; font-size: 2.5rem; background: white; border: 2px solid var(--peka-secondary);">
                <i class="fas fa-person-pregnant text-secondary"></i>
            </div>
            <div>
                <h3 class="mb-1 fw-bold" style="color: var(--peka-secondary);">Halo, {{ $pasien->nama }}</h3>
                <p class="text-muted mb-2">Semoga Anda dan janin selalu dalam keadaan sehat.</p>
                @if($kehamilanAktif)
                <div class="d-flex flex-wrap gap-3 mt-2">
                    <span class="badge bg-white text-dark border"><i class="fas fa-calendar-check text-primary me-1"></i> Usia Kandungan: {{ \Carbon\Carbon::parse($kehamilanAktif->hpht)->diffInWeeks(now()) }} Minggu</span>
                    <span class="badge bg-white text-dark border"><i class="fas fa-baby-carriage text-secondary me-1"></i> Taksiran Persalinan: {{ \Carbon\Carbon::parse($kehamilanAktif->tp)->format('d M Y') }}</span>
                </div>
                @endif
            </div>
        </div>

        <div class="row g-4 mb-4">
            @if($kehamilanAktif && $kehamilanAktif->kunjunganAncs->isNotEmpty())
                @php $kunjunganTerakhir = $kehamilanAktif->kunjunganAncs->first(); @endphp
                <div class="col-md-4">
                    <div class="vital-card h-100">
                        <div class="vital-card__header">
                            <i class="fas fa-heart-pulse vital-card__icon text-danger"></i>
                            <span class="vital-card__title">Tekanan Darah Terakhir</span>
                        </div>
                        <div class="vital-card__value">{{ $kunjunganTerakhir->tekanan_darah_sistolik }}<span class="vital-card__unit">/</span>{{ $kunjunganTerakhir->tekanan_darah_diastolik }}
                            <span class="vital-card__unit">mmHg</span>
                        </div>
                        <div class="text-muted" style="font-size: 0.75rem;">Diperbarui {{ $kunjunganTerakhir->tanggal->diffForHumans() }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="vital-card h-100">
                        <div class="vital-card__header">
                            <i class="fas fa-weight-scale vital-card__icon text-primary"></i>
                            <span class="vital-card__title">Berat Badan</span>
                        </div>
                        <div class="vital-card__value">{{ $kunjunganTerakhir->berat_badan }}
                            <span class="vital-card__unit">kg</span>
                        </div>
                        <div class="text-muted" style="font-size: 0.75rem;">TFU: {{ $kunjunganTerakhir->tinggi_fundus_uteri }} cm</div>
                    </div>
                </div>
                <div class="col-md-4">
                    @php
                        $rawLevel = $kunjunganTerakhir->skriningRisiko?->level_risiko ?? 'HIJAU';
                        $level = $rawLevel === 'MERAH_KRITIS' ? 'critical' : ($rawLevel === 'MERAH' ? 'red' : ($rawLevel === 'KUNING' ? 'yellow' : 'green'));
                        $levelLabel = $kunjunganTerakhir->skriningRisiko ? str_replace('_', ' ', $kunjunganTerakhir->skriningRisiko->status) : 'Normal';
                    @endphp
                    <div class="vital-card h-100 d-flex flex-column align-items-center justify-content-center" style="background: var(--risk-{{ $level }}-bg); border-color: var(--risk-{{ $level }}-border);">
                        <div class="vital-card__title mb-2">Status Risiko Saat Ini</div>
                        <h4 style="color: var(--risk-{{ $level }}); font-weight: 800;">{{ $levelLabel }}</h4>
                        @if($level !== 'green')
                            <div class="text-hint text-center mt-2" style="color: var(--risk-{{ $level }});">Mohon ikuti anjuran bidan/dokter dengan disiplin.</div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="card border-0 shadow-card rounded-xl mb-5">
            <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                <h5 class="section-title mb-0">Riwayat Kunjungan Saya</h5>
            </div>
            <div class="card-body p-4">
                @if($kehamilanAktif && $kehamilanAktif->kunjunganAncs->isNotEmpty())
                    <div class="timeline mt-2">
                        @foreach($kehamilanAktif->kunjunganAncs as $k)
                            @php
                                $riskClass = '';
                                if($k->skriningRisiko) {
                                    if(str_contains($k->skriningRisiko->level_risiko, 'MERAH')) $riskClass = 'risk-merah';
                                    elseif($k->skriningRisiko->level_risiko == 'KUNING') $riskClass = 'risk-kuning';
                                }
                            @endphp
                            <div class="timeline-item {{ $riskClass }}">
                                <h6 class="mb-1">{{ $k->tanggal->format('d F Y') }} <span class="badge bg-light text-dark border ms-2">UK: {{ $k->usia_kehamilan_minggu }} Mgg</span></h6>
                                <p class="text-muted mb-2" style="font-size: 0.875rem;">
                                    TD: <strong>{{ $k->tekanan_darah_sistolik }}/{{ $k->tekanan_darah_diastolik }}</strong> mmHg | 
                                    BB: <strong>{{ $k->berat_badan }}</strong> kg | 
                                    Protein Urine: <strong>{{ $k->protein_urine }}</strong>
                                </p>
                                @if($k->catatan_bidan)
                                    <div class="bg-light p-2 rounded text-muted" style="font-size: 0.875rem;">
                                        <i class="fas fa-comment-medical me-1"></i> {{ $k->catatan_bidan }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <p>Belum ada riwayat kunjungan.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="mb-5">
            <h5 class="section-title mb-3">Edukasi Preeklampsia</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card border border-light shadow-sm rounded-xl h-100">
                        <div class="card-body">
                            <h6 class="fw-bold"><i class="fas fa-book-medical text-primary me-2"></i>Tanda Bahaya Kehamilan</h6>
                            <p class="text-muted" style="font-size: 0.875rem;">Kenali gejala-gejala yang mengharuskan Anda segera ke fasilitas kesehatan.</p>
                            <a href="#" class="text-decoration-none fw-semibold">Baca selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border border-light shadow-sm rounded-xl h-100">
                        <div class="card-body">
                            <h6 class="fw-bold"><i class="fas fa-utensils text-success me-2"></i>Nutrisi Ibu Hamil</h6>
                            <p class="text-muted" style="font-size: 0.875rem;">Panduan makanan sehat untuk mencegah tekanan darah tinggi saat hamil.</p>
                            <a href="#" class="text-decoration-none fw-semibold">Baca selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Floating Emergency Button -->
<button class="btn btn-emergency btn-float-emergency" onclick="laporDarurat()">
    <i class="fas fa-triangle-exclamation"></i> Lapor Darurat
</button>

<form id="formDarurat" method="POST" action="{{ route('portal.darurat.store') }}" class="d-none">
    @csrf
    <input type="hidden" name="deskripsi" id="daruratDeskripsi">
    <div id="daruratGejalaInputs"></div>
</form>

@endsection

@push('scripts')
<script>
    function laporDarurat() {
        const gejala = [
            'Pandangan kabur / kilatan cahaya',
            'Sakit kepala hebat',
            'Nyeri ulu hati / perut kanan atas',
            'Bengkak mendadak',
            'Sesak napas',
            'Gerakan janin berkurang',
            'Perdarahan',
            'Kontraksi hebat sebelum waktunya'
        ];

        Swal.fire({
            title: 'Lapor Kondisi Darurat',
            html: `
                <div class="text-start">
                    ${gejala.map((g, i) => `<label class="d-block mb-2"><input type="checkbox" class="form-check-input me-2 gejala-darurat" value="${g}"> ${g}</label>`).join('')}
                    <textarea id="deskripsiDarurat" class="form-control mt-3" rows="3" placeholder="Deskripsi tambahan"></textarea>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#64748B',
            confirmButtonText: 'Kirim Laporan',
            cancelButtonText: 'Batal',
            preConfirm: () => {
                const checked = Array.from(document.querySelectorAll('.gejala-darurat:checked')).map(el => el.value);
                if (!checked.length) {
                    Swal.showValidationMessage('Pilih minimal satu gejala.');
                    return false;
                }
                return { checked, deskripsi: document.getElementById('deskripsiDarurat').value };
            }
        }).then((result) => {
            if (!result.isConfirmed) return;

            const inputBox = document.getElementById('daruratGejalaInputs');
            inputBox.innerHTML = '';
            result.value.checked.forEach((item) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'gejala[]';
                input.value = item;
                inputBox.appendChild(input);
            });
            document.getElementById('daruratDeskripsi').value = result.value.deskripsi;
            document.getElementById('formDarurat').submit();
        });
    }
</script>
@endpush
