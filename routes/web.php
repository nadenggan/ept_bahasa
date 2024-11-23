<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalTesController;

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

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/jadwal-tes', [JadwalTesController::class, 'index'])->name('jadwal.index');
Route::post('/jadwal-tes', [JadwalTesController::class, 'store'])->name('jadwal.store');
Route::delete('/jadwal-tes/{tanggal}', [JadwalTesController::class, 'destroy'])->name('jadwal.destroy');
