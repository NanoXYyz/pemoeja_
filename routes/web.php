<?php

use App\Http\Controllers\JadwalController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\LaguController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. AUTENTIKASI
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==========================================
// 2. RUTE PUBLIK
// ==========================================
Route::get('/', [DashboardController::class, 'dashboard'])->name('content.dashboard');

Route::get('/lagu', [LaguController::class, 'index'])->name('lagu.index');
Route::post('/lagu', [LaguController::class, 'store'])->name('lagu.store');

Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');

Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');

// ==========================================
// 3. RUTE ADMIN
// ==========================================
Route::middleware(['auth', 'admin'])->group(function () {

    // Anggota
    Route::resource('anggota', AnggotaController::class)->except(['index']);

    // Arsip
    Route::resource('arsip', ArsipController::class)->except(['index']);

    // Keuangan (full CRUD — termasuk edit view & update)
    Route::resource('keuangan', KeuanganController::class);

    // Lagu (admin: edit, update, destroy saja)
    Route::resource('lagu', LaguController::class)->only(['edit', 'update', 'destroy']);

    // Jadwal (store & destroy, index sudah di publik)
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

    // ── Settings ────────────────────────────────────────────────
    // CRUD setting (header/field)
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');
    Route::put('/settings/{id}', [SettingsController::class, 'update'])->name('settings.update');
    Route::delete('/settings/{id}', [SettingsController::class, 'destroy'])->name('settings.destroy');

    // CRUD opsi per setting (tambah/hapus pilihan dropdown)
    Route::post('/settings/{settingId}/options', [SettingsController::class, 'addOption'])->name('settings.option.add');
    Route::delete('/settings/options/{optionId}', [SettingsController::class, 'destroyOption'])->name('settings.option.destroy');
});