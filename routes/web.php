<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminFotograferController;
use App\Http\Controllers\Admin\AdminPemesananController;
use App\Http\Controllers\Admin\AdminPenggunaController;
use App\Http\Controllers\Admin\FotomuAdminController;
use App\Http\Controllers\User\ProdukController;
use App\Http\Controllers\Foto\FotograferController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Foto\DashFotograferController;
use App\Http\Controllers\Foto\FotoFotograferController;
use App\Http\Controllers\Foto\PembayaranController;
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
    Route::get('/setting', [AdminController::class, 'setting'])->name('admin.setting');

    Route::get('/foto-kontrol', [FotomuAdminController::class, 'fotomu_kontrol'])->name('admin.fotokontrol');
    Route::get('/foto-kontrol/event/{id}', [FotomuAdminController::class, 'foto'])->name('admin.fotoevent');
    Route::get('/admin-fotohapus', [FotomuAdminController::class, 'AdmindeleteSelectedPhotos'])->name('admin.hapusfoto');
    Route::get('/event', [FotomuAdminController::class, 'event'])->name('admin.event');
    Route::put('/event/update/{id}', [FotomuAdminController::class, 'event_update'])->name('admin.event-update');

    Route::get('/daftar-fotografer', [AdminFotograferController::class, 'pendaftaran_fotografer'])->name('admin.daftar-foto');
    Route::get('/fotografer', [AdminFotograferController::class, 'fotografer'])->name('admin.fotografer');
    Route::put('/daftar-fotografer/proses/{id}', [AdminFotograferController::class, 'setujui_fotografer'])->name('admin.validasi-foto');
    Route::put('/fotografer/reject/{id}', [AdminFotograferController::class, 'fotografer_reject'])->name('admin.reject-foto');
    Route::get('/pembayaran', [AdminFotograferController::class, 'pembayaran'])->name('admin.pembayaran-foto');
    Route::put('/pembayaran/proses/{id}', [AdminFotograferController::class, 'pembayaran_proses'])->name('admin.proses-pembayaran');
    Route::put('/fotografer/update-status/{id}', [AdminFotograferController::class, 'updateStatusFotografer'])->name('admin.update-statusfoto');

    Route::get('/riwayat-pemesanan', [AdminPemesananController::class, 'riwayat'])->name('admin.riwayat-pemesanan');
    Route::get('/akumulasi-pemesanan', [AdminPemesananController::class, 'akumulasi'])->name('admin.akumulasi-pemesanan');
    
    Route::get('/daftar-pengguna', [AdminPenggunaController::class, 'pengguna'])->name('admin.pengguna');
    Route::put('/user/update-active/{id}', [AdminPenggunaController::class, 'updateStatusActive'])->name('admin.pengguna-update');
    Route::get('/tambah-admin', [AdminPenggunaController::class, 'tambah'])->name('admin.tambah-pengguna');
    Route::post('/tambah-admin', [AdminPenggunaController::class, 'store_user'])->name('admin.store-pengguna');
    // });
});

Route::prefix('fotografer')->group(function () {
    // Route::group(['middleware' => ['web', 'auth', 'role:admin']], function () {

    //dashboard
    Route::get('/dashboard', [DashFotograferController::class, 'index'])->name('foto.dashboard');
    Route::get('/dashboard/search', [DashFotograferController::class, 'index_search'])->name('foto.dashboardsearch');
 
    //Upload Foto
    Route::get('/upload', [FotoFotograferController::class, 'upload'])->name('foto.upload');
    Route::post('/foto/upload', [FotoFotograferController::class, 'upload_foto'])->name('photos.upload');
    Route::post('/foto/store', [FotoFotograferController::class, 'store'])->name('photos.store');
    Route::post('/event/store', [FotograferController::class, 'event_tambah'])->name('event.store');
    Route::get('/file-manager', [FotoFotograferController::class, 'file_manager'])->name('foto.filemanager');
    Route::get('/file-manager/event/{id}', [FotoFotograferController::class, 'foto'])->name('foto.foto');
    Route::delete('/hapus-foto', [FotoFotograferController::class, 'deleteSelectedPhotos'])->name('foto.hapus-foto');
    Route::get('/get-foto/{id}', [FotoFotograferController::class, 'getFoto'])->name('foto.edit-getfoto');
    Route::post('/update-selected-photos', [FotoFotograferController::class, 'updateSelectedPhotos'])->name('foto.updatefoto');

    //profil
    Route::get('/profil', [FotograferController::class, 'profil'])->name('foto.profil');
    Route::get('/tree', [FotograferController::class, 'tree'])->name('foto.tree');

    //Pembayaran
    Route::get('/pembayaran', [PembayaranController::class, 'pembayaran'])->name('foto.pembayaran');
    Route::post('/bank/store', [PembayaranController::class, 'store_bank'])->name('bank.store');
    Route::post('/bank/verify-otp', [PembayaranController::class, 'verifyOtp'])->name('bank.verifyOtp');
    Route::post('/bank/resend-otp', [PembayaranController::class, 'resendOtp'])->name('bank.resendOtp');
    Route::delete('/bank/{id}', [PembayaranController::class, 'bank_destroy'])->name('bank.destroy');
    Route::get('/cek-rekening-fotografer', [PembayaranController::class, 'cekRekeningFotografer'])->name('bank.cekrekening');
    Route::post('/penarikan', [PembayaranController::class, 'withdrawal_store'])->name('bank.penarikan');
    Route::delete('/penarikan/{id}', [PembayaranController::class, 'withdrawal_destroy'])->name('bank.penarikan-hapus');

    // });
});

Route::prefix('pelanggan')->group(function () {
    // Route::group(['middleware' => ['web', 'auth', 'role:admin']], function () {
    //Produk
    Route::get('/foto', [ProdukController::class, 'produk'])->name('user.produk');
    Route::get('/foto/event/{id}', [ProdukController::class, 'event'])->name('user.event');
    Route::post('/event/{id}/check-password', [ProdukController::class, 'checkPassword'])->name('event.check-password');
    Route::post('/similar-foto/hapus', [ProdukController::class, 'HapusSimilar'])->name('similar-foto.hapus');
    Route::post('/similar-foto/pulihkan', [ProdukController::class, 'PulihkanSimilar'])->name('similar-foto.pulihkan');
    Route::get('/search-event', [ProdukController::class, 'search'])->name('event.search');
    Route::get('/foto/terhapus', [ProdukController::class, 'konten_terhapus'])->name('user.konten-terhapus');

    //Wishlist & Cart
    Route::get('/cart', [CartController::class, 'cart'])->name('user.cart');
    Route::get('/wishlist', [CartController::class, 'wishlist'])->name('user.wishlist');
    Route::post('/toggle-whishlist', [CartController::class, 'toggleWishlist'])->name('wishlist.toggle');
    Route::post('/toggle-cart', [CartController::class, 'toggleCart'])->name('cart.toggle');
    Route::delete('/cart/{id}', [CartController::class, 'hapusCart'])->name('cart.destroy');
    Route::post('/cart/buy-now', [CartController::class, 'buyNow'])->name('cart.buyNow');

    //Pemesanan Foto
    Route::get('/pesanan', [PemesananController::class, 'index'])->name('user.pesanan');
    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('user.pemesanan');
    Route::get('/invoice/{id}', [PemesananController::class, 'invoice'])->name('user.invoice');
    Route::get('/checkout/success/{id}', [PemesananController::class, 'success'])->name('checkout.success');
    Route::get('/download', [PemesananController::class, 'download'])->name('user.download');
    Route::post('/pesanan/dibatalkan/{id}', [PemesananController::class, 'cancelOrder'])->name('user.pesanan-dibatalkan');

    //user
    Route::get('/profil', [UserController::class, 'profile'])->name('user.profil');
    Route::get('/form-fotodepan', [UserController::class, 'formfoto_depan'])->name('user.formfotodepan');
    Route::get('/retake', [UserController::class, 'retake'])->name('user.retake');
    Route::get('/robomu', [UserController::class, 'robomu'])->name('user.robomu');
    Route::post('/form-fotodepan', [UserController::class, 'upload_fotodepan'])->name('user.fotodepan');
    Route::get('/form-fotokiri', [UserController::class, 'formfoto_kiri'])->name('user.formfotokiri');
    Route::post('/form-fotokiri', [UserController::class, 'upload_fotokiri'])->name('user.fotokiri');
    Route::get('/form-fotokanan', [UserController::class, 'formfoto_kanan'])->name('user.formfotokanan');
    Route::post('/form-fotokanan', [UserController::class, 'upload_fotokanan'])->name('user.fotokanan');
    Route::get('/upgrade', [UserController::class, 'become'])->name('user.upgrade');
    Route::post('/upgrade', [UserController::class, 'store_fotografer'])->name('user.upgrade-store');


    //tree
    Route::get('/tree', [ProdukController::class, 'tree'])->name('event.tree');
    Route::get('/events', [ProdukController::class, 'getEvents']);


    // });
});