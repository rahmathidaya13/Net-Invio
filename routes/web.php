<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Barang\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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
    Route::controller(UserController::class)->group(function () {
        Route::get('/user/list', 'index')->name('user.list');
        Route::get('/user/create', 'create')->name('create.user');
        Route::post('/user/store', 'store')->name('user.store');
        Route::get('/user/edit/{id}', 'edit')->name('user.edit');
        Route::put('/user/update/{id}', 'update')->name('user.update');
        Route::delete('/user/destroy/{id}', 'destroy')->name('user.destroy');
    });
    Route::controller(BarangController::class)->group(function () {
        Route::get('/barang/list', 'index')->name('barang.list');
        Route::get('/barang/create', 'create')->name('barang.create');
        Route::get('/barang/edit/{id}', 'edit')->name('barang.edit');
        Route::post('/barang/store', 'store')->name('barang.store');
        Route::put('/barang/update/{id}', 'update')->name('barang.update');
        Route::delete('/barang/destroy/{id}', 'destroy')->name('barang.destroy');
    });
});
