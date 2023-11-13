<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\TransaksiController;
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



Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::group(['middleware' => 'auth'], function () {    
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::get('/stok', [StokBarangController::class, 'index'])->name('stok.index');

    Route::get('/jenis', [JenisBarangController::class, 'index'])->name('jenis.index');
    Route::post('/jenis', [JenisBarangController::class, 'store'])->name('jenis.store');
    Route::put('/jenis/{id}', [JenisBarangController::class, 'update'])->name('jenis.update');
    Route::DELETE('/jenis/{id}', [JenisBarangController::class, 'delete'])->name('jenis.destroy');

    Route::resource('transaksi', TransaksiController::class)->except([
        'edit', 'update'
    ]);

    Route::resource('pembelian', PembelianController::class)->except([
        'edit', 'update'
    ]);

});
