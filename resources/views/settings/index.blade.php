@extends('layouts.app')

@section('title', 'Pengaturan Sistem')
@section('page_title', 'Pengaturan')

@section('content')
<div class="row g-4">
    <div class="col-12 col-lg-3">
        <!-- Settings Nav -->
        <div class="card border-0 shadow-card rounded-xl overflow-hidden sticky-top" style="top: 90px; z-index: 10;">
            <div class="card-body p-2">
                <div class="list-group list-group-flush rounded-3">
                    <a href="#general" class="list-group-item list-group-item-action border-0 d-flex align-items-center gap-3 py-3 active rounded-3 mb-1" style="font-weight: 600;">
                        <i class="fas fa-sliders text-center" style="width: 20px;"></i> Umum
                    </a>
                    <a href="#notifications" class="list-group-item list-group-item-action border-0 d-flex align-items-center gap-3 py-3 rounded-3 mb-1" style="font-weight: 600;">
                        <i class="fas fa-bell text-center" style="width: 20px;"></i> Notifikasi
                    </a>
                    @if(auth()->user()->role === 'admin')
                    <a href="#system" class="list-group-item list-group-item-action border-0 d-flex align-items-center gap-3 py-3 rounded-3 mb-1" style="font-weight: 600;">
                        <i class="fas fa-database text-center" style="width: 20px;"></i> Basis Data
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-9">
        <!-- General Settings -->
        <div id="general" class="card border-0 shadow-card rounded-xl overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="section-title mb-0 fw-bold">Pengaturan Umum</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <label class="form-label fw-bold small">Tema Tampilan</label>
                    <div class="d-flex gap-3">
                        <div class="form-check form-check-inline p-3 border rounded-3 text-center flex-fill" style="cursor: pointer;">
                            <input class="form-check-input float-none ms-0 mb-2" type="radio" name="theme" id="themeLight" value="light" checked>
                            <label class="form-check-label d-block mt-1 small fw-bold" for="themeLight">Terang (Default)</label>
                        </div>
                        <div class="form-check form-check-inline p-3 border rounded-3 text-center flex-fill opacity-50" style="cursor: not-allowed;" title="Segera Hadir">
                            <input class="form-check-input float-none ms-0 mb-2" type="radio" name="theme" id="themeDark" value="dark" disabled>
                            <label class="form-check-label d-block mt-1 small fw-bold" for="themeDark">Gelap</label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small">Format Tanggal Sistem</label>
                    <select class="form-control-peka">
                        <option value="d/m/Y">DD/MM/YYYY (Contoh: {{ date('d/m/Y') }})</option>
                        <option value="Y-m-d">YYYY-MM-DD (Contoh: {{ date('Y-m-d') }})</option>
                        <option value="d M Y">DD MMM YYYY (Contoh: {{ date('d M Y') }})</option>
                    </select>
                </div>
                
                <div class="text-end border-top pt-4">
                    <button class="btn btn-peka-primary px-4 rounded-pill shadow-sm" onclick="Toast.fire({icon: 'success', title: 'Pengaturan disimpan.'})">
                        <i class="fas fa-save me-2"></i> Simpan
                    </button>
                </div>
            </div>
        </div>

        <!-- Notification Settings -->
        <div id="notifications" class="card border-0 shadow-card rounded-xl overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="section-title mb-0 fw-bold">Preferensi Notifikasi</h5>
            </div>
            <div class="card-body p-4">
                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 py-3 border-bottom border-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold small">Notifikasi Darurat (Pop-up)</div>
                                <div class="text-hint x-small">Tampilkan peringatan langsung saat ada laporan darurat.</div>
                            </div>
                            <div class="form-check form-switch custom-switch">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item px-0 py-3 border-bottom border-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold small">Rujukan Masuk Baru</div>
                                <div class="text-hint x-small">Pemberitahuan saat RS menerima rujukan dari Puskesmas.</div>
                            </div>
                            <div class="form-check form-switch custom-switch">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item px-0 py-3 border-bottom border-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold small">Email Mingguan Laporan</div>
                                <div class="text-hint x-small">Kirim rekapan pasien berisiko tinggi setiap Senin pagi.</div>
                            </div>
                            <div class="form-check form-switch custom-switch">
                                <input class="form-check-input" type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- System Settings -->
        @if(auth()->user()->role === 'admin')
        <div id="system" class="card border-0 shadow-card rounded-xl overflow-hidden">
            <div class="card-header bg-danger bg-opacity-10 border-bottom border-danger-subtle p-4">
                <h5 class="section-title mb-0 fw-bold text-danger"><i class="fas fa-server me-2"></i> Pengaturan Sistem & Database</h5>
            </div>
            <div class="card-body p-4">
                <div class="alert alert-warning border-0 rounded-3 small">
                    <i class="fas fa-exclamation-triangle me-2"></i> Area ini hanya dapat diakses oleh Administrator tingkat lanjut.
                </div>
                <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3 border mb-3">
                    <div>
                        <div class="fw-bold small">Sinkronisasi Tabel Cache</div>
                        <div class="text-hint x-small">Bersihkan cache sistem agar data tampil terbaru.</div>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill fw-bold" onclick="Toast.fire({icon: 'success', title: 'Cache berhasil dibersihkan.'})">Clear Cache</button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .list-group-item.active {
        background-color: var(--peka-primary-pale) !important;
        color: var(--peka-primary) !important;
    }
    .custom-switch .form-check-input { width: 2.5rem; height: 1.25rem; cursor: pointer; }
</style>
@endsection
