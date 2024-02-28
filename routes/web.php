<?php

use Illuminate\Support\Facades\Route;

#--> ROUTE CONTROLLER--------------------------------------
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\data\UserController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\data\ProdukController;
use App\Http\Controllers\data\PelangganController;
use App\Http\Controllers\data\PenjualanController;
use App\Http\Controllers\auth\RegistrasiController;
use App\Http\Controllers\data\DetailPenjualanController;
#--> END ROUTE CONTROLLER---------------------------------
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LoginController::class, 'login'])->name('login'); // ROUTE TAMPILAN LOGIN
Route::post('/authentication', [LoginController::class, 'authentication'])->name('authentication'); // ROUTE UNTUK AUTH USER
Route::get('/logout', [LoginController::class, 'logout'])->name('logout'); // ROUTE LOGOUT
Route::get('/registrasi/akun', [RegistrasiController::class, 'index'])->name('registrasi_petugas');
Route::post('/registrasi/akun/simpan', [RegistrasiController::class, 'simpan'])->name('registrasi_petugas.simpan');


// ROUTE SETELAH LOGIN
Route::prefix('dashboard')->middleware('auth')->group(function () {

    // ROUTE DASHBOARD
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // -> ROUTE DATA PENJUALAN
    Route::resource('data_penjualan', PenjualanController::class);
    Route::get('/pembelian/{id}', [PenjualanController::class, 'pembelian'])->name('pembelian');
    Route::post('/transaksi/{id}', [PenjualanController::class, 'transaksi'])->name('transaksi');
    Route::post('/simpan_penjualan', [PenjualanController::class, 'simpan_penjualan'])->name('simpan_penjualan');
    Route::get('data_penjualan_export_pdf', [PenjualanController::class, 'export_pdf'])->name('data_penjualan.export_pdf');
    Route::get('data_penjualan_export_excel', [PenjualanController::class, 'export_excel'])->name('data_penjualan.export_excel');
    // END ROUTE DATA PENJUALAN

    // ROUTE CRUD DATA DETAIL PENJUALAN
    Route::resource('detail_penjualan', DetailPenjualanController::class);

    // -> ROUTE DATA PELANGGAN
    Route::resource('data_pelanggan', PelangganController::class);
    Route::get('data_pelanggan_export_pdf', [PelangganController::class, 'export_pdf'])->name('data_pelanggan.export_pdf');
    Route::get('data_pelanggan_export_excel', [PelangganController::class, 'export_excel'])->name('data_pelanggan.export_excel');
    Route::post('data_pelanggan_import_excel', [PelangganController::class, 'import_excel'])->name('data_pelanggan.import_excel');
    // -> END ROUTE DATA PELANGGAN

    // -> ROUTE DATA PRODUK
    Route::resource('/data_produk', ProdukController::class);
    Route::get('/data_produk_export_pdf', [ProdukController::class, 'export_pdf'])->name('data_produk.export_pdf');
    Route::get('/data_produk_export_excel', [ProdukController::class, 'export_excel'])->name('data_produk.export_excel');
    Route::post('/data_produk_import_excel', [ProdukController::class, 'import_excel'])->name('data_produk.import_excel');

    // -> ROUTE MIDDLEWARE UNTUK ADMINISTRATOR
    Route::middleware(['role:administrator'])->group(function () {

        // -> ROUTE HISTORY AKTIVITAS
        Route::get('/history',[HistoryController::class, 'index'])->name('history');

        // -> ROUTE DATA USER
        Route::resource('/data_user', UserController::class);
        Route::get('/data_user_export_pdf', [UserController::class, 'export_pdf'])->name('data_user.export_pdf');
        Route::get('/data_user_export_excel', [UserController::class, 'export_excel'])->name('data_user.export_excel');
        Route::post('/data_user_import_excel', [UserController::class, 'import_excel'])->name('data_user.import_excel');
        // -> END ROUTE DATA USER
    });
});
