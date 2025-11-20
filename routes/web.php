<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProfilController;


Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/antrian', [AdminController::class, 'antrian'])->name('admin.antrian');
    Route::get('/antrian/{id}', [AdminController::class, 'show'])->name('admin.antrian.show');
    Route::delete('/antrian/{id}', [AdminController::class, 'destroy'])->name('admin.antrian.destroy');
    Route::get('/verifikasi', [AdminController::class, 'verifikasi'])->name('admin.verifikasi');
    Route::get('/export', [AdminController::class, 'exportForm'])->name('admin.export.form'); // Form view
    Route::get('/export/download', [AdminController::class, 'exportDownload'])->name('admin.export.download'); // Download
    Route::get('/kuota', [AdminController::class, 'kuotaAdmin'])->name('admin.kuota');
    Route::get('/admin/profil', [ProfilController::class, 'edit'])->name('admin.edit');
    Route::post('/admin/profil', [ProfilController::class, 'update'])->name('admin.update');
});

// Route yang digunakan dalam blade:
Route::get('/antrian/jkm', [AntrianController::class, 'form'])->name('antrian.form'); // Halaman ini
Route::post('/antrian/jkm', [AntrianController::class, 'store'])->name('antrian.store'); // Submit form
Route::post('/antrian/kirim-verifikasi', [AntrianController::class, 'kirimKodeVerifikasi'])->name('antrian.kirim-verifikasi'); // Kirim kode WA
Route::post('/antrian/verifikasi-kode', [AntrianController::class, 'verifikasiKode'])->name('antrian.verifikasi-kode'); // Verifikasi kode
Route::get('/cek-kuota', [AntrianController::class, 'cekKuota'])->name('antrian.kuota'); // Cek kuota

// QR Code
Route::get('/qr', [AntrianController::class, 'qr'])->name('antrian.qr');

// routes/web.php
// Route::get('/test-csrf', function() {
//     return response()->json([
//         'csrf_token' => csrf_token(),
//         'session_id' => session()->getId()
//     ]);
// });