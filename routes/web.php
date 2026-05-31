<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\KunjunganAncController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\HasilPersalinanController;
use App\Http\Controllers\JadwalKunjunganController;
use App\Http\Controllers\LaporanDaruratController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PortalPasienController;
use App\Http\Controllers\RujukanController;

use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings');

    Route::middleware('role:admin,dokter,bidan')->group(function () {
        Route::resource('pasien', PasienController::class)->only(['index', 'create', 'store', 'show']);
        Route::resource('kunjungan', KunjunganAncController::class)->only(['index', 'create', 'store', 'show']);
        Route::resource('rujukan', RujukanController::class)->only(['index', 'create', 'store', 'show']);
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

    Route::resource('edukasi', EdukasiController::class)->only(['index', 'show']);

    Route::middleware('role:admin,bidan')->group(function () {
        Route::resource('darurat', LaporanDaruratController::class)->only(['index', 'update']);
        Route::post('/kehamilan/{kehamilan}/jadwal', [JadwalKunjunganController::class, 'store'])->name('jadwal.store');
        Route::patch('/jadwal/{jadwal}', [JadwalKunjunganController::class, 'update'])->name('jadwal.update');
        Route::get('/kehamilan/{kehamilan}/persalinan/create', [HasilPersalinanController::class, 'create'])->name('persalinan.create');
        Route::post('/kehamilan/{kehamilan}/persalinan', [HasilPersalinanController::class, 'store'])->name('persalinan.store');
    });

    Route::middleware('role:dokter')->group(function () {
        Route::patch('/rujukan/{rujukan}/terima', [RujukanController::class, 'terima'])->name('rujukan.terima');
        Route::post('/rujukan/{rujukan}/catatan-balik', [RujukanController::class, 'catatanBalik'])->name('rujukan.catatan-balik');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserManagementController::class)->only(['index', 'create', 'store']);
        Route::resource('fasilitas', FasilitasController::class)->only(['index', 'create', 'store']);
        Route::resource('edukasi', EdukasiController::class)->only(['create', 'store']);
        Route::get('/audit-log', [AuditLogController::class, 'index'])->name('audit.index');
    });

    Route::middleware('role:pasien')->group(function () {
        Route::get('/portal', [PortalPasienController::class, 'index'])->name('portal.index');
        Route::post('/portal/lapor-darurat', [PortalPasienController::class, 'laporDarurat'])->name('portal.darurat.store');
    });
});
