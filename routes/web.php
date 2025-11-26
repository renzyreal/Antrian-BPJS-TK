<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\TanggalNonaktifController;


// Route default website - redirect ke dashboard jika sudah login, atau ke login jika belum
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Dashboard & Main Routes
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/antrian', [AdminController::class, 'antrian'])->name('admin.antrian');
    Route::get('/antrian/{id}', [AdminController::class, 'show'])->name('admin.antrian.show');
    Route::delete('/antrian/{id}', [AdminController::class, 'destroy'])->name('admin.antrian.destroy');
    Route::get('/verifikasi', [AdminController::class, 'verifikasi'])->name('admin.verifikasi');
    Route::get('/export', [AdminController::class, 'exportForm'])->name('admin.export.form');
    Route::get('/export/download', [AdminController::class, 'exportDownload'])->name('admin.export.download');
    Route::get('/kuota', [AdminController::class, 'kuotaAdmin'])->name('admin.kuota');

    Route::get('/tanggal-nonaktif', [TanggalNonaktifController::class, 'index'])
        ->name('admin.tanggal.index');

    Route::post('/tanggal-nonaktif', [TanggalNonaktifController::class, 'store'])
        ->name('admin.tanggal.store');

    Route::delete('/tanggal-nonaktif/{id}', [TanggalNonaktifController::class, 'destroy'])
        ->name('admin.tanggal.delete');
    
    // QR Code Routes
    Route::get('/qr-code', [AdminController::class, 'qrCode'])->name('admin.qr');
    Route::get('/qr-code/download', [AdminController::class, 'qrCodeDownload'])->name('admin.qr.download');
    
    // Profile Routes
    Route::get('/profil', [ProfilController::class, 'edit'])->name('admin.profil.edit');
    Route::post('/profil', [ProfilController::class, 'update'])->name('admin.profil.update');
});

// Route untuk public (antrian form)
Route::get('/antrian/jkm', [AntrianController::class, 'form'])->name('antrian.form');
Route::post('/antrian/jkm', [AntrianController::class, 'store'])->name('antrian.store');
Route::post('/antrian/kirim-verifikasi', [AntrianController::class, 'kirimKodeVerifikasi'])->name('antrian.kirim-verifikasi');
Route::post('/antrian/verifikasi-kode', [AntrianController::class, 'verifikasiKode'])->name('antrian.verifikasi-kode');
Route::get('/cek-kuota', [AntrianController::class, 'cekKuota'])->name('antrian.kuota');

// QR Code Public Route
Route::get('/qr-code', [AntrianController::class, 'qr'])->name('antrian.qr');
Route::get('/tanggal-nonaktif', [AntrianController::class, 'getTanggalNonaktif']);