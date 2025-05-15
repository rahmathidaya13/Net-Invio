<?php

use App\Exports\StokBarangExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\BarangKeluar\BarangKeluarModel;
use App\Http\Controllers\Barang\BarangController;
use App\Http\Controllers\Supplier\SupplierController;
use App\Http\Controllers\Barang\BarangExportController;
use App\Http\Controllers\Pelanggan\PelangganController;
use App\Http\Controllers\StokBarang\StokBarangController;
use App\Http\Controllers\BarangMasuk\BarangMasukController;
use App\Http\Controllers\ReturBarang\ReturBarangController;
use App\Http\Controllers\BarangKeluar\BarangKeluarController;
use App\Http\Controllers\BarangKeluar\BarangKeluarExportController;
use App\Http\Controllers\StokBarang\StokBarangExportController;
use App\Http\Controllers\BarangMasuk\BarangMasukExportController;
use App\Http\Controllers\Pelanggan\PelangganExportController;
use App\Http\Controllers\ReturBarang\BarangKembaliExportController;
use App\Http\Controllers\Supplier\SupplierExportController;

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

Auth::routes();
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'role:develop,admin,user'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/home', 'index')->name('home');
    });

    // this user controller
    Route::controller(UserController::class)->group(function () {
        Route::middleware('can:onlyDevelop')->group(function () {
            Route::get('/user/list', 'index')->name('user.list');
            Route::get('/user/create', 'create')->name('user.create');
            Route::post('/user/store', 'store')->name('user.store');
            Route::get('/user/edit/{id}', 'edit')->name('user.edit');
            Route::put('/user/update/{id}', 'update')->name('user.update');
            Route::delete('/user/destroy/{id}', 'destroy')->name('user.destroy');
        });
    });

    // this barang controller
    Route::controller(BarangController::class)->group(function () {
        Route::get('/barang/list', 'index')->name('barang.list')->middleware('can:view');
        Route::get('/barang/create', 'create')->name('barang.create')->middleware('can:add');
        Route::get('/barang/edit/{id}', 'edit')->name('barang.edit')->middleware('can:edit');
        Route::post('/barang/store', 'store')->name('barang.store')->middleware('can:add');
        Route::put('/barang/update/{id}', 'update')->name('barang.update')->middleware('can:edit');
        Route::delete('/barang/destroy/{id}', 'destroy')->name('barang.destroy')->middleware('can:delete');
    });

    // this pelanggan controller
    Route::controller(PelangganController::class)->group(function () {
        Route::get('/pelanggan/list', 'index')->name('pelanggan.list')->middleware('can:view');
        Route::get('/pelanggan/create', 'create')->name('pelanggan.create')->middleware('can:add');
        Route::get('/pelanggan/edit/{id}', 'edit')->name('pelanggan.edit')->middleware('can:edit');
        Route::post('/pelanggan/store', 'store')->name('pelanggan.store')->middleware('can:add');
        Route::put('/pelanggan/update/{id}', 'update')->name('pelanggan.update')->middleware('can:edit');
        Route::delete('/pelanggan/destroy/{id}', 'destroy')->name('pelanggan.destroy')->middleware('can:delete');
    });

    // this supplier controller
    Route::controller(SupplierController::class)->group(function () {
        Route::get('/supplier/list', 'index')->name('supplier.list')->middleware('can:view');
        Route::get('/supplier/create', 'create')->name('supplier.create')->middleware('can:add');
        Route::get('/supplier/edit/{id}', 'edit')->name('supplier.edit')->middleware('can:edit');
        Route::post('/supplier/store', 'store')->name('supplier.store')->middleware('can:add');
        Route::put('/supplier/update/{id}', 'update')->name('supplier.update')->middleware('can:edit');
        Route::delete('/supplier/destroy/{id}', 'destroy')->name('supplier.destroy')->middleware('can:delete');
    });


    // this supplier controller
    Route::controller(StokBarangController::class)->group(function () {
        Route::get('/stok/list', 'index')->name('stok.list')->middleware('can:view');
        Route::get('/stok/create', 'create')->name('stok.create')->middleware('can:add');
        Route::get('/stok/edit/{id}', 'edit')->name('stok.edit')->middleware('can:edit');
        Route::get('/stok/show/{id}', 'show')->name('stok.show');
        Route::post('/stok/store', 'store')->name('stok.store')->middleware('can:add');
        Route::put('/stok/update/{id}', 'update')->name('stok.update')->middleware('can:edit');
        Route::delete('/stok/destroy/{id}', 'destroy')->name('stok.destroy')->middleware('can:delete');
    });


    // this barang masuk controller
    Route::controller(BarangMasukController::class)->group(function () {
        Route::get('/receiving/list', 'index')->name('receiving.list')->middleware('can:view');
        Route::get('/receiving/create', 'create')->name('receiving.create')->middleware('can:add');
        Route::get('/receiving/edit/{id}', 'edit')->name('receiving.edit')->middleware('can:edit');
        Route::get('/receiving/show/{id}', 'show')->name('receiving.show');
        Route::post('/receiving/store', 'store')->name('receiving.store')->middleware('can:add');
        Route::put('/receiving/update/{id}', 'update')->name('receiving.update')->middleware('can:edit');
        Route::delete('/receiving/destroy/{id}', 'destroy')->name('receiving.destroy')->middleware('can:delete');
    });

    // this barang masuk controller
    Route::controller(BarangKeluarController::class)->group(function () {
        Route::get('/outbound/list', 'index')->name('outbound.list')->middleware('can:view');
        Route::get('/outbound/create', 'create')->name('outbound.create')->middleware('can:add');
        Route::get('/outbound/edit/{id}', 'edit')->name('outbound.edit')->middleware('can:edit');
        Route::post('/outbound/store', 'store')->name('outbound.store')->middleware('can:add');
        Route::put('/outbound/update/{id}', 'update')->name('outbound.update')->middleware('can:edit');
        Route::delete('/outbound/destroy/{id}', 'destroy')->name('outbound.destroy')->middleware('can:delete');
    });

    // this barang kembali controller
    Route::controller(ReturBarangController::class)->group(function () {
        Route::get('/retur/list', 'index')->name('retur.list')->middleware('can:view');
        Route::get('/retur/create', 'create')->name('retur.create')->middleware('can:add');
        Route::get('/retur/edit/{id}', 'edit')->name('retur.edit')->middleware('can:edit');
        Route::post('/retur/store', 'store')->name('retur.store')->middleware('can:add');
        Route::put('/retur/update/{id}', 'update')->name('retur.update')->middleware('can:edit');
        Route::delete('/retur/destroy/{id}', 'destroy')->name('retur.destroy')->middleware('can:delete');
    });

    // route khusus cetak file
    Route::controller(BarangExportController::class)->group(function () {
        Route::any('/barang/export', 'export')->name('barang.export');
        Route::any('/barang/pdf', 'printPdf')->name('barang.pdf');
    });
    Route::controller(StokBarangExportController::class)->group(function () {
        Route::any('/stok/export', 'export')->name('stok.export');
        Route::any('/stok/pdf', 'printPdf')->name('stok.pdf');
    });
    Route::controller(BarangMasukExportController::class)->group(function () {
        Route::any('/receiving/export', 'export')->name('receiving.export');
        Route::any('/receiving/pdf', 'printPdf')->name('receiving.pdf');
    });
    Route::controller(BarangKeluarExportController::class)->group(function () {
        Route::any('/outbound/export', 'export')->name('outbound.export');
        Route::any('/outbound/pdf', 'printPdf')->name('outbound.pdf');
    });
    Route::controller(BarangKembaliExportController::class)->group(function () {
        Route::any('/retur/export', 'export')->name('retur.export');
        Route::any('/retur/pdf', 'printPdf')->name('retur.pdf');
    });
    Route::controller(PelangganExportController::class)->group(function () {
        Route::any('/pelanggan/export', 'export')->name('pelanggan.export');
        Route::any('/pelanggan/pdf', 'printPdf')->name('pelanggan.pdf');
    });
    Route::controller(SupplierExportController::class)->group(function () {
        Route::any('/supplier/export', 'export')->name('supplier.export');
        Route::any('/supplier/pdf', 'printPdf')->name('supplier.pdf');
    });
});
