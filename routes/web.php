<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VoteController;

// Auth / Login Peran
Route::get('/', [AuthController::class, 'showRoleSelection'])->name('login');
Route::get('/login/{role}', [AuthController::class, 'showLoginRole'])->name('login.role');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman Bilik Suara
Route::get('/voting', [VoteController::class, 'index'])->name('voting.index');
Route::post('/voting', [VoteController::class, 'store'])->name('voting.simpan');

// Admin Routes
// Route::middleware(['auth', 'role:admin'])->group(function () {
Route::group([], function () {
    // Redirect /admin langsung ke /admin/dashboard
    Route::get('/admin', function () {
        return redirect()->route('admin.dashboard');
    });

    // Import & Kelola Pemilih
    Route::get('/admin/import', [AdminController::class, 'index'])->name('admin.import');
    Route::post('/admin/import', [AdminController::class, 'import'])->name('admin.import.excel');
    Route::delete('/admin/pemilih/reset', [AdminController::class, 'resetPemilih'])->name('admin.pemilih.reset');


    // Kelola Paslon
    // Kelola Paslon (Full CRUD)
    Route::get('/admin/kandidat', [AdminController::class, 'kandidatIndex'])->name('admin.kandidat');
    Route::post('/admin/kandidat', [AdminController::class, 'kandidatStore'])->name('admin.kandidat.simpan');
    Route::put('/admin/kandidat/{id}', [AdminController::class, 'kandidatUpdate'])->name('admin.kandidat.update');
    Route::delete('/admin/kandidat/{id}', [AdminController::class, 'kandidatDestroy'])->name('admin.kandidat.hapus');
    Route::post('/admin/reset-suara', [AdminController::class, 'resetSuara'])->name('admin.resetSuara');

    // Admin Dashboard & Quick Count
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/quickcount', [AdminController::class, 'quickCount'])->name('admin.quickcount');
});
