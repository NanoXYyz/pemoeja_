<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\LaguController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. RUTE AUTENTIKASI (LOGIN/LOGOUT)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==========================================
// 2. RUTE PUBLIK (BISA DIAKSES SIAPA SAJA)
// ==========================================
Route::get('/', [DashboardController::class, 'dashboard'])->name('content.dashboard');

// Route Index & Store Lagu (Kini Terbuka untuk Umum)
Route::get('/lagu', [LaguController::class, 'index'])->name('lagu.index');
Route::post('/lagu', [LaguController::class, 'store'])->name('lagu.store');

Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');

Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
// Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
Route::get('/jadwal/dokumentasi', [JadwalController::class, 'dokumentasi'])->name('jadwal.dokumentasi');
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

// ==========================================
// 3. RUTE ADMIN (EDIT, DELETE, UPDATE)
// ==========================================
Route::middleware(['auth', 'admin'])->group(function () {
    // Resource Route untuk CRUD lainnya
    Route::resource('anggota', AnggotaController::class)->except(['index']);
    Route::resource('arsip', ArsipController::class)->except(['index']);
    Route::resource('keuangan', KeuanganController::class);
    
    // Untuk Lagu, Admin hanya memegang hak Edit, Update, dan Delete
    Route::resource('lagu', LaguController::class)->only(['edit', 'update', 'destroy']);
    
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    // Route::resource('jadwal', JadwalController::class)->except(['index', 'show']);
    // Menggunakan resource untuk store dan destroy agar sesuai dengan index.blade.php
    Route::resource('settings', SettingsController::class)->only(['store', 'destroy']);
    
    // Rute update jika diperlukan di masa depan
    Route::put('/settings/{id}', [SettingsController::class, 'update'])->name('settings.update');
    // Update Setting
    // Route::put('/settings/{id}', [SettingController::class, 'update'])->name('setting.update');
});