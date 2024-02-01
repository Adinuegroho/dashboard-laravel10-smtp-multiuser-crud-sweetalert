<?php

use App\Http\Controllers\DataMahasiswa;
use App\Http\Controllers\UproleController;
use App\Http\Controllers\UserControlController;
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

Route::middleware(['guest'])->group(function () {
    Route::view('/', 'halaman_depan/index');
    Route::get('/sesi', [\App\Http\Controllers\AuthController::class, 'index'])->name('auth');
    Route::post('/sesi', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::get('/reg', [\App\Http\Controllers\AuthController::class, 'create'])->name('registrasi');
    Route::post('/reg', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::get('/verify/{verify_key}', [\App\Http\Controllers\AuthController::class, 'verify']);
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('/home', '/user');
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin')->middleware('userAkses:admin');
    Route::get('/user', [\App\Http\Controllers\UserController::class, 'index'])->name('user')->middleware('userAkses:user');

    Route::get('/datamahasiswa', [\App\Http\Controllers\DataMahasiswa::class, 'index'])->name('datamahasiswa');
    Route::get('/damatambah', [\App\Http\Controllers\DataMahasiswa::class, 'tambah']);
    Route::get('/damaedit/{id}', [\App\Http\Controllers\DataMahasiswa::class, 'edit']);
    Route::post('/damahapus/{id}', [\App\Http\Controllers\DataMahasiswa::class, 'hapus']);

    Route::get('/usercontrol', [\App\Http\Controllers\UserControlController::class, 'index'])->name('usercontrol');

    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    // new
    Route::post('/tambahdama', [DataMahasiswa::class, 'create']);
    Route::post('/editdama', [DataMahasiswa::class, 'change']);

    Route::get('/tambahuc', [UserControlController::class, 'tambah']);
    Route::get('/edituc/{id}', [UserControlController::class, 'edit']);
    Route::post('/hapusuc/{id}', [UserControlController::class, 'hapus']);
    Route::post('/tambahuc', [UserControlController::class, 'create']);
    Route::post('/edituc', [UserControlController::class, 'change']);

    Route::post('/uprole/{id}', [UproleController::class, 'index']);
});

