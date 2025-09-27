<?php

use App\Http\Controllers\Auth\MasyarakatAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Masyarakat\PengajuanController;
use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\MasyarakatController;

use Illuminate\Support\Facades\Route;

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

//Routes Umum
Route::get('/', function () {
    return view('welcome');
});

// Masyarakat Authentication Routes
Route::prefix('masyarakat')->group(function () {
    Route::get('/login', [MasyarakatAuthController::class, 'showLoginForm'])->name('masyarakat.login');
    Route::post('/login', [MasyarakatAuthController::class, 'login']);
    Route::get('/register', [MasyarakatAuthController::class, 'showRegisterForm'])->name('masyarakat.register');
    Route::post('/register', [MasyarakatAuthController::class, 'register']);
    Route::post('/logout', [MasyarakatAuthController::class, 'logout'])->name('masyarakat.logout');
});

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// Protected Masyarakat Routes
Route::middleware(['auth:masyarakat'])->prefix('masyarakat')->group(function () {
    Route::get('/dashboard', function () {
        return view('masyarakat.dashboard');
    })->name('masyarakat.dashboard');

    // Routes untuk profil - 
    Route::get('/profil', [MasyarakatController::class, 'showProfil'])->name('masyarakat.profil');
    Route::get('/profil/edit', [MasyarakatController::class, 'editProfil'])->name('masyarakat.profil.edit');
    Route::put('/profil/update', [MasyarakatController::class, 'updateProfil'])->name('masyarakat.profil.update');
    Route::get('/profil/change-password', [MasyarakatController::class, 'showChangePassword'])->name('masyarakat.password.edit');
    Route::put('/profil/change-password', [MasyarakatController::class, 'updatePassword'])->name('masyarakat.password.update');
    
    Route::resource('/pengajuan', PengajuanController::class);
});

// Protected Admin Routes
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/pengajuan', [AdminController::class, 'pengajuan'])->name('admin.pengajuan');
    Route::put('/pengajuan/{id}', [AdminController::class, 'updatePengajuan'])->name('admin.pengajuan.update');
    
    // Routes untuk manajemen masyarakat - PASTIKAN INI ADA
    Route::get('/masyarakat', [AdminController::class, 'dataMasyarakat'])->name('admin.masyarakat');
    Route::get('/masyarakat/belum-verifikasi', [AdminController::class, 'masyarakatBelumVerifikasi'])->name('admin.masyarakat.belum-verifikasi');
    
    Route::get('/masyarakat/terhapus', [AdminController::class, 'masyarakatTerhapus'])->name('admin.masyarakat.terhapus'); // ← INI YANG DITAMBAH
    Route::get('/masyarakat/{id}', [AdminController::class, 'detailMasyarakat'])->name('admin.masyarakat.detail');
    Route::post('/masyarakat/{id}/verifikasi', [AdminController::class, 'verifikasiMasyarakat'])->name('admin.masyarakat.verifikasi');
    Route::post('/masyarakat/{id}/batalkan-verifikasi', [AdminController::class, 'batalkanVerifikasiMasyarakat'])->name('admin.masyarakat.batalkan-verifikasi');
    Route::delete('/masyarakat/{id}/hapus', [AdminController::class, 'hapusMasyarakat'])->name('admin.masyarakat.hapus');
    Route::post('/masyarakat/{id}/pulihkan', [AdminController::class, 'pulihkanMasyarakat'])->name('admin.masyarakat.pulihkan');
    Route::delete('/masyarakat/{id}/hapus-permanen', [AdminController::class, 'hapusPermanenMasyarakat'])->name('admin.masyarakat.hapus.permanen');
});