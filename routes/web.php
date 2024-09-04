<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\ProdukController;
use App\Http\Controllers\Foto\FotograferController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\User\PemesananController;

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
Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('user.pass-update');

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
    Route::post('/event/store', [FotograferController::class, 'event_tambah'])->name('event.store');
    // });
});

Route::prefix('pelanggan')->group(function () {
    // Route::group(['middleware' => ['web', 'auth', 'role:admin']], function () {
    //Produk
    Route::get('/foto', [ProdukController::class, 'produk'])->name('user.produk');
    Route::get('/foto/event/{id}', [ProdukController::class, 'event'])->name('user.event');
    Route::post('/event/{id}/check-password', [ProdukController::class, 'checkPassword'])->name('event.check-password');
    Route::post('/similar-foto/hapus', [ProdukController::class, 'HapusSimilar'])->name('similar-foto.hapus');
    Route::get('/search-event', [ProdukController::class, 'search'])->name('event.search');

    //Wishlist & Cart
    Route::get('/cart', [CartController::class, 'cart'])->name('user.cart');
    Route::post('/toggle-whishlist', [CartController::class, 'toggleWishlist'])->name('wishlist.toggle');
    Route::post('/toggle-cart', [CartController::class, 'toggleCart'])->name('cart.toggle');
    Route::delete('/cart/{id}', [CartController::class, 'hapusCart'])->name('cart.destroy');
    Route::post('/cart/buy-now', [CartController::class, 'buyNow'])->name('cart.buyNow');

    //Pemesanan Foto
    Route::get('/pesanan', [PemesananController::class, 'index'])->name('user.pesanan');
    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('user.pemesanan');
    Route::get('/invoice/{id}', [PemesananController::class, 'invoice'])->name('user.invoice');
    Route::get('/checkout/success/{id}', [PemesananController::class, 'success'])->name('checkout.success');

    //user
    Route::get('/profil', [UserController::class, 'profile'])->name('user.profil');
    Route::get('/form-fotodepan', [UserController::class, 'formfoto_depan'])->name('user.formfotodepan');
    Route::post('/form-fotodepan', [UserController::class, 'upload_fotodepan'])->name('user.fotodepan');
    Route::get('/form-fotokiri', [UserController::class, 'formfoto_kiri'])->name('user.formfotokiri');
    Route::post('/form-fotokiri', [UserController::class, 'upload_fotokiri'])->name('user.fotokiri');
    Route::get('/form-fotokanan', [UserController::class, 'formfoto_kanan'])->name('user.formfotokanan');
    Route::post('/form-fotokanan', [UserController::class, 'upload_fotokanan'])->name('user.fotokanan');

    //tree
    Route::get('/tree', [ProdukController::class, 'tree'])->name('event.tree');

    // });
});