<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Foto\FotograferController;

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

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::get('/daftar', [AuthController::class, 'daftar'])->name('daftar');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
    Route::post('/daftar', [AuthController::class, 'register'])->name('daftar.perform');
    Route::get('verifymail/{id}', [VerificationController::class, 'verifyEmail'])->name('verifymail');
    Route::get('/konfirmasi-akun', [AuthController::class, 'konfirmasiakun'])->name('konfirmasi-akun');
    Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->group(function () {
    // Route::group(['middleware' => ['web', 'auth', 'role:admin']], function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // });
});

Route::prefix('fotografer')->group(function () {
    // Route::group(['middleware' => ['web', 'auth', 'role:admin']], function () {
    Route::get('/profil', [FotograferController::class, 'profil'])->name('foto.profil');
    Route::get('/upload', [FotograferController::class, 'upload'])->name('foto.upload');
    Route::post('/foto/upload', [FotograferController::class, 'upload_foto'])->name('photos.upload');
    Route::post('/foto/store', [FotograferController::class, 'store'])->name('photos.store');
    // });
});