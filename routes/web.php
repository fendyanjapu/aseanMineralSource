<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KondisiBatuController;
use App\Http\Controllers\KondisiLapanganController;
use App\Http\Controllers\LaporanPemasukanController;
use App\Http\Controllers\LaporanPengeluaranController;
use App\Http\Controllers\OperasionalSiteController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PembelianBarangController;
use App\Http\Controllers\PembelianBatuController;
use App\Http\Controllers\PengapalanController;
use App\Http\Controllers\PenggajihanController;
use App\Http\Controllers\PerbaikanUnitController;
use App\Http\Controllers\RotasiUnitController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserSiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KaryawanController;
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

Route::get('/', function () {
    return view('home');
});

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('signin', [LoginController::class, 'signin'])->name('signin');
Route::post('logout', [LoginController::class,'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('laporanPemasukan', [LaporanPemasukanController::class, 'index'])->name('laporanPemasukan');
    Route::get('laporanPengeluaran', [LaporanPengeluaranController::class, 'index'])->name('laporanPengeluaran');
    Route::post('laporanPemasukan/print', [LaporanPemasukanController::class, 'print'])->name('laporanPemasukan.print');
    Route::post('laporanPengeluaran/print', [LaporanPengeluaranController::class, 'print'])->name('laporanPengeluaran.print');

    Route::get('/getSite', [PengapalanController::class, 'getSite'] )->name('getSite');
    Route::get('/getTotalRotasi', [RotasiUnitController::class, 'getTotalRotasi'] )->name('getTotalRotasi');

    Route::resource('user', UserController::class)->except('show');
    Route::resource('userSite', UserSiteController::class)->except('show');
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('barang', BarangController::class)->except('show');
    Route::resource('site', SiteController::class)->except('show');
    Route::resource('unit', UnitController::class)->except('show');
    Route::resource('pemasukan', PemasukanController::class)->except('show');
    Route::resource('pembelianBarang', PembelianBarangController::class)->except('show');
    Route::resource('perbaikanUnit', PerbaikanUnitController::class)->except('show');
    Route::resource('penggajihan', PenggajihanController::class)->except('show');
    Route::resource('kondisiBatu', KondisiBatuController::class)->except('show');
    Route::resource('kondisiLapangan', KondisiLapanganController::class)->except('show');
    Route::resource('pembelianBatu', PembelianBatuController::class)->except('show');
    Route::resource('operasionalSite', OperasionalSiteController::class)->except('show');
    Route::resource('pengapalan', PengapalanController::class)->except('show');
    Route::resource('rotasiUnit', RotasiUnitController::class)->except('show');
});


