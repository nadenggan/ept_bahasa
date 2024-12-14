<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalTesController;
use App\Http\Controllers\MahasiswaAuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PendaftaranKelasController;
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
    Route::get('/jadwal-kelas', [KelasController::class, 'index'])->name('admin.jadwalkelas');
    Route::post('/jadwal-tes', [JadwalTesController::class, 'store'])->name('jadwal.store');
    Route::post('/jadwal-kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::delete('/jadwal-tes/{tanggal}', [JadwalTesController::class, 'destroy'])->name('jadwal.destroy');
    Route::delete('/jadwal-kelas/{id}', [KelasController::class, 'destroy'])->name('admin.jadwalkelas.destroy');
    Route::get('/admin/pendaftaran-tes', [JadwalTesController::class, 'showPendaftaran'])->name('admin.pendaftaran_tes');
        Route::get('/admin/pendaftaran-tes', [JadwalTesController::class, 'showPendaftaran'])->name('admin.pendaftaran_tes');
    Route::post('/admin/pendaftaran-tes/{id}/tentukan-ruangan', [JadwalTesController::class, 'tentukanRuangan'])->name('admin.tentukan_ruangan');
    Route::get('/admin/pendaftaran_kelas', [PendaftaranKelasController::class, 'index'])
    ->name('admin.pendaftaran_kelas');
    Route::get('admin/pendaftaran/terjadwal', [JadwalTesController::class, 'showTerjadwal'])->name('admin.pendaftaran.terjadwal');
    Route::put('admin/pendaftaran/{id}/update-status', [JadwalTesController::class, 'updateStatusTes'])->name('admin.update_status_tes');
    Route::put('/admin/verifikasi-bayar/{id}', [JadwalTesController::class, 'verifikasiBayar'])->name('admin.verifikasi_bayar');
    Route::put('/admin/pendaftaran/{id}/batal-verifikasi', [JadwalTesController::class, 'batalVerifikasi'])->name('admin.batal_verifikasi');


});

// Route untuk Mahasiswa
Route::get('login/mahasiswa', [MahasiswaAuthController::class, 'showLoginForm'])->name('mahasiswa.login');
Route::post('login/mahasiswa', [MahasiswaAuthController::class, 'login']);
Route::get('logout/mahasiswa', [MahasiswaAuthController::class, 'logout'])->name('mahasiswa.logout');

// Dashboard Mahasiswa
Route::middleware(['mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaAuthController::class, 'dashboard'])->name('mahasiswa.dashboard');
    Route::post('/mahasiswa/pilih-tanggal', [MahasiswaAuthController::class, 'pilihTanggal'])->name('mahasiswa.pilih_tanggal');
    Route::post('/mahasiswa/konfirmasi-bayar/{id}', [MahasiswaAuthController::class, 'konfirmasiBayar'])->name('mahasiswa.konfirmasi_bayar');

    // Menampilkan form pendaftaran kelas
    Route::get('/mahasiswa/daftar-kelas', [MahasiswaAuthController::class, 'daftarKelasForm'])->name('mahasiswa.daftarKelasForm');

    // Menyimpan pendaftaran kelas
    Route::post('/mahasiswa/daftar-kelas', [MahasiswaAuthController::class, 'daftarKelas'])->name('mahasiswa.daftarKelas');

});
