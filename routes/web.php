<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalTesController;
use App\Http\Controllers\MahasiswaAuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk Admin
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Admin
Route::middleware(['admin'])->group(function () {
    Route::get('/jadwal-tes', [JadwalTesController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal-tes', [JadwalTesController::class, 'store'])->name('jadwal.store');
    Route::delete('/jadwal-tes/{tanggal}', [JadwalTesController::class, 'destroy'])->name('jadwal.destroy');
});

// Route untuk Mahasiswa
Route::get('mahasiswa/login', [MahasiswaAuthController::class, 'showLoginForm'])->name('mahasiswa.login');
Route::post('mahasiswa/login', [MahasiswaAuthController::class, 'login']);
Route::post('mahasiswa/logout', [MahasiswaAuthController::class, 'logout'])->name('mahasiswa.logout');

// Dashboard Mahasiswa
Route::middleware(['mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaAuthController::class, 'dashboard'])->name('mahasiswa.dashboard');
});