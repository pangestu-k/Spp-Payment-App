<?php

use App\Http\Controllers\KelasController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SppController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('kelas', KelasController::class);
    Route::resource('spp', SppController::class);
    Route::resource('petugas', PetugasController::class);
    Route::resource('siswa', SiswaController::class);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('pembayaran/history', [PembayaranController::class, 'history'])->name('pembayaran.history')->middleware('auth');

Route::middleware('isTwice')->group(function(){
    Route::get('pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('pembayaran/create', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('pembayaran/create', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::delete('pembayaran/{pembayaran}/destroy', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
    Route::put('pembayaran/{pembayaran}/update', [PembayaranController::class, 'update'])->name('pembayaran.update');
    Route::get('pembayaran/{pembayaran}/edit', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
});

Route::get('pembayaran/{pembayaran}', [PembayaranController::class, 'show'])->name('pembayaran.show');
// Route::resource('pembayaran', PembayaranController::class)->middleware('isTwice');
Route::get('export/pembayaran', [PembayaranController::class, 'excelExport'])->name('pembayaran.export')->middleware('isTwice');
Route::get('pembayaran/getData/{nisn}/{berapa}', [PembayaranController::class, 'getData'])->name('pembayaran.getData')->middleware('isTwice');

Auth::routes();
