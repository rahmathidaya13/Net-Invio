<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Barang\BarangController;
use App\Http\Controllers\BarangKeluar\BarangKeluarController;
use App\Http\Controllers\BarangMasuk\BarangMasukController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Pelanggan\PelangganController;
use App\Http\Controllers\StokBarang\StokBarangController;
use App\Http\Controllers\Supplier\SupplierController;
use App\Http\Controllers\UserController;
use App\Models\BarangKeluar\BarangKeluarModel;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'role:admin,user'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/home', 'index')->name('home');
    });

    // this user controller
    Route::controller(UserController::class)->group(function () {
        Route::get('/user/list', 'index')->name('user.list');
        Route::get('/user/create', 'create')->name('create.user');
        Route::post('/user/store', 'store')->name('user.store');
        Route::get('/user/edit/{id}', 'edit')->name('user.edit');
        Route::put('/user/update/{id}', 'update')->name('user.update');
        Route::delete('/user/destroy/{id}', 'destroy')->name('user.destroy');
    });

    // this barang controller
    Route::controller(BarangController::class)->group(function () {
        Route::get('/barang/list', 'index')->name('barang.list');
        Route::get('/barang/create', 'create')->name('barang.create');
        Route::get('/barang/edit/{id}', 'edit')->name('barang.edit');
        Route::post('/barang/store', 'store')->name('barang.store');
        Route::put('/barang/update/{id}', 'update')->name('barang.update');
        Route::delete('/barang/destroy/{id}', 'destroy')->name('barang.destroy');
    });

    // this pelanggan controller
    Route::controller(PelangganController::class)->group(function () {
        Route::get('/pelanggan/list', 'index')->name('pelanggan.list');
        Route::get('/pelanggan/create', 'create')->name('pelanggan.create');
        Route::get('/pelanggan/edit/{id}', 'edit')->name('pelanggan.edit');
        Route::post('/pelanggan/store', 'store')->name('pelanggan.store');
        Route::put('/pelanggan/update/{id}', 'update')->name('pelanggan.update');
        Route::delete('/pelanggan/destroy/{id}', 'destroy')->name('pelanggan.destroy');
    });

    // this supplier controller
    Route::controller(SupplierController::class)->group(function () {
        Route::get('/supplier/list', 'index')->name('supplier.list');
        Route::get('/supplier/create', 'create')->name('supplier.create');
        Route::get('/supplier/edit/{id}', 'edit')->name('supplier.edit');
        Route::post('/supplier/store', 'store')->name('supplier.store');
        Route::put('/supplier/update/{id}', 'update')->name('supplier.update');
        Route::delete('/supplier/destroy/{id}', 'destroy')->name('supplier.destroy');
    });


    // this supplier controller
    Route::controller(StokBarangController::class)->group(function () {
        Route::get('/stok/list', 'index')->name('stok.list');
        Route::get('/stok/create', 'create')->name('stok.create');
        Route::get('/stok/edit/{id}', 'edit')->name('stok.edit');
        Route::get('/stok/show/{id}/{val}', 'show')->name('stok.show');
        Route::post('/stok/store', 'store')->name('stok.store');
        Route::put('/stok/update/{id}', 'update')->name('stok.update');
        Route::delete('/stok/destroy/{id}', 'destroy')->name('stok.destroy');
    });


    // this barang masuk controller
    Route::controller(BarangMasukController::class)->group(function () {
        Route::get('/receiving/list', 'index')->name('receiving.list');
        Route::get('/receiving/create', 'create')->name('receiving.create');
        Route::get('/receiving/edit/{id}', 'edit')->name('receiving.edit');
        Route::get('/receiving/show/{id}', 'show')->name('receiving.show');
        Route::post('/receiving/store', 'store')->name('receiving.store');
        Route::put('/receiving/update/{id}', 'update')->name('receiving.update');
        Route::delete('/receiving/destroy/{id}', 'destroy')->name('receiving.destroy');
    });

    // this barang masuk controller
    Route::controller(BarangKeluarController::class)->group(function () {
        Route::get('/outbound/list', 'index')->name('outbound.list');
        Route::get('/outbound/create', 'create')->name('outbound.create');
        Route::get('/outbound/edit/{id}', 'edit')->name('outbound.edit');
        Route::post('/outbound/store', 'store')->name('outbound.store');
        Route::put('/outbound/update/{id}', 'update')->name('outbound.update');
        Route::delete('/outbound/destroy/{id}', 'destroy')->name('outbound.destroy');
    });
});
