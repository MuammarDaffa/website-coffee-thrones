<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\JamOperasionalController;

// FRONTEND (pelanggan)
Route::get('/', [FrontendController::class, 'index'])->name('home');

// AUTH ADMIN
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// ADMIN AREA
Route::middleware(['isAdmin'])->prefix('admin')->group(function () {

    // 💡 RUTE KATEGORI PRODUK
    Route::get('/produk/search', [App\Http\Controllers\Admin\ProdukController::class, 'search'])->name('produk.search');

    Route::get('/produk/kopi', [\App\Http\Controllers\Admin\ProdukController::class, 'kopi'])
        ->name('produk.kopi');
    Route::get('/produk/nonkopi', [\App\Http\Controllers\Admin\ProdukController::class, 'nonkopi'])
        ->name('produk.nonkopi');
    Route::get('/produk/makanan', [\App\Http\Controllers\Admin\ProdukController::class, 'makanan'])
        ->name('produk.makanan');

    // DASHBOARD
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'index'])
        ->name('admin.dashboard');

    // logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    // RESOURCE PRODUK (CRUD)
    Route::resource('/produk', \App\Http\Controllers\Admin\ProdukController::class);
    // CRUD GALERI
    Route::resource('/galeri', \App\Http\Controllers\Admin\GaleriController::class);

    Route::get('/jam-operasional', [JamOperasionalController::class, 'index'])->name('jam.index');
    Route::put('/jam-operasional/{jamOperasional}', [JamOperasionalController::class, 'update'])->name('jam.update');
});
