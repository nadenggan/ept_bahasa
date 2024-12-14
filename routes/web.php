<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalTesController;
use App\Http\Controllers\MahasiswaAuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PendaftaranKelasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;

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

Route::get('/jadwal-tes', [JadwalTesController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal-kelas', [KelasController::class, 'index'])->name('admin.jadwalkelas');
    Route::post('/jadwal-tes', [JadwalTesController::class, 'store'])->name('jadwal.store');
    Route::post('/jadwal-kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::delete('/jadwal-tes/{tanggal}', [JadwalTesController::class, 'destroy'])->name('jadwal.destroy');
    Route::delete('/jadwal-kelas/{tanggal}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    Route::get('/admin/pendaftaran-tes', [JadwalTesController::class, 'showPendaftaran'])->name('admin.pendaftaran_tes');
        Route::get('/admin/pendaftaran-tes', [JadwalTesController::class, 'showPendaftaran'])->name('admin.pendaftaran_tes');
    Route::post('/admin/pendaftaran-tes/{id}/tentukan-ruangan', [JadwalTesController::class, 'tentukanRuangan'])->name('admin.tentukan_ruangan');
    Route::get('admin/pendaftaran/terjadwal', [JadwalTesController::class, 'showTerjadwal'])->name('admin.pendaftaran.terjadwal');
    Route::put('admin/pendaftaran/{id}/update-status', [JadwalTesController::class, 'updateStatusTes'])->name('admin.update_status_tes');
    Route::put('/admin/verifikasi-bayar/{id}', [JadwalTesController::class, 'verifikasiBayar'])->name('admin.verifikasi_bayar');
<<<<<<< Updated upstream

    Route::get('/jadwal-kelas', [KelasController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal-kelas', [KelasController::class, 'store'])->name('jadwal.store');
    Route::delete('/jadwal-kelas/{id}', [KelasController::class, 'destroy'])->name('jadwal.destroy');
    Route::get('/admin/pendaftaran-kelas', [KelasController::class, 'showPendaftaran'])->name('admin.pendaftaran_kelas');
    Route::post('/admin/pendaftaran-kelas/{id}/tentukan-kelas', [KelasController::class, 'tentukanKelas'])->name('admin.tentukan_kelas');
    Route::get('/admin/pendaftaran/terjadwal', [KelasController::class, 'showTerjadwal'])->name('admin.terjadwal');
    Route::put('/admin/pendaftaran/{id}/update-status', [KelasController::class, 'updateStatus'])->name('admin.update_status');
});
=======
    Route::put('/admin/pendaftaran/{id}/batal-verifikasi', [JadwalTesController::class, 'batalVerifikasi'])->name('admin.batal_verifikasi');

// Dashboard Admin
// Route::middleware(['admin'])->group(function () {
//     Route::get('/jadwal-tes', [JadwalTesController::class, 'index'])->name('jadwal.index');
//     Route::get('/jadwal-kelas', [KelasController::class, 'index'])->name('admin.jadwalkelas');
//     Route::post('/jadwal-tes', [JadwalTesController::class, 'store'])->name('jadwal.store');
//     Route::post('/jadwal-kelas', [KelasController::class, 'store'])->name('kelas.store');
//     Route::delete('/jadwal-tes/{tanggal}', [JadwalTesController::class, 'destroy'])->name('jadwal.destroy');
//     Route::delete('/jadwal-kelas/{tanggal}', [KelasController::class, 'destroy'])->name('kelas.destroy');
//     Route::get('/admin/pendaftaran-tes', [JadwalTesController::class, 'showPendaftaran'])->name('admin.pendaftaran_tes');
//         Route::get('/admin/pendaftaran-tes', [JadwalTesController::class, 'showPendaftaran'])->name('admin.pendaftaran_tes');
//     Route::post('/admin/pendaftaran-tes/{id}/tentukan-ruangan', [JadwalTesController::class, 'tentukanRuangan'])->name('admin.tentukan_ruangan');
//     Route::get('admin/pendaftaran/terjadwal', [JadwalTesController::class, 'showTerjadwal'])->name('admin.pendaftaran.terjadwal');
//     Route::put('admin/pendaftaran/{id}/update-status', [JadwalTesController::class, 'updateStatusTes'])->name('admin.update_status_tes');
//     Route::put('/admin/verifikasi-bayar/{id}', [JadwalTesController::class, 'verifikasiBayar'])->name('admin.verifikasi_bayar');
//     Route::put('/admin/pendaftaran/{id}/batal-verifikasi', [JadwalTesController::class, 'batalVerifikasi'])->name('admin.batal_verifikasi');


// });
>>>>>>> Stashed changes

// Route untuk Mahasiswa
Route::get('login/mahasiswa', [MahasiswaAuthController::class, 'showLoginForm'])->name('mahasiswa.login');
Route::post('login/mahasiswa', [MahasiswaAuthController::class, 'login']);
Route::get('logout/mahasiswa', [MahasiswaAuthController::class, 'logout'])->name('mahasiswa.logout');

// Dashboard Mahasiswa
Route::middleware(['mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaAuthController::class, 'dashboard'])->name('mahasiswa.dashboard');
    Route::post('/mahasiswa/pilih-tanggal', [MahasiswaAuthController::class, 'pilihTanggal'])->name('mahasiswa.pilih_tanggal');
    Route::post('/mahasiswa/konfirmasi-bayar/{id}', [MahasiswaAuthController::class, 'konfirmasiBayar'])->name('mahasiswa.konfirmasi_bayar');

<<<<<<< Updated upstream
    Route::get('/jadwal-kelas', [KelasController::class, 'index'])->name('jadwal.index');
    Route::get('/pendaftaran', [PendaftaranKelasController::class, 'index'])->name('pendaftaran.index');
    Route::post('/pendaftaran', [PendaftaranKelasController::class, 'store'])->name('pendaftaran.store');
});
=======
});
>>>>>>> Stashed changes
