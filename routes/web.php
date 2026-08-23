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
Route::get('/admin/import', [AdminController::class, 'index'])->name('admin.import');
Route::post('/admin/import', [AdminController::class, 'import'])->name('admin.import.proses');

Route::get('/admin/kandidat', [AdminController::class, 'kandidatIndex'])->name('admin.kandidat');
Route::post('/admin/kandidat', [AdminController::class, 'kandidatStore'])->name('admin.kandidat.simpan');

// Admin Dashboard Statistik DPT
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Admin Display Quick Count Khusus Proyektor
Route::get('/admin/quickcount', [AdminController::class, 'quickCount'])->name('admin.quickcount');
