<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\UserController;


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
    return view('welcome');
});

Route::get('backend/beranda', [BerandaController::class, 'berandaBackend'])->name('backend.beranda')->middleware('auth');

//route login and logout
Route::get('backend/login', [LoginController::class, 'loginBackend'])->name('backend.login');
Route::post('backend/login', [LoginController::class, 'authenticateBackend'])->name('backend.login');
Route::post('backend/logout', [LoginController::class, 'logoutBackend'])->name('backend.logout');

// Route::resource('backend/user', UserController::class)->middleware('auth');
Route::resource('backend/user', UserController::class, ['as' => 'backend'])->middleware('auth');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('backend.user.destroy');


//route cetak laporan user
Route::get('backend/laporan/formuser', [UserController::class, 'formUser'])->name('backend.laporan.formuser')->middleware('auth'); 
Route::post('backend/laporan/cetakuser', [UserController::class, 'cetakUser'])->name('backend.laporan.cetakuser')->middleware('auth'); 
 


Route::resource('backend/merk', MerkController::class, ['as' => 'backend'])->middleware('auth'); 
Route::delete('/merk/{id}', [MerkController::class, 'destroy'])->name('backend.merk.destroy');
// Menambahkan route update untuk merk mobil
Route::put('/merk/{id}', [MerkController::class, 'update'])->name('update');

Route::resource('backend/mobil', MobilController::class, ['as' => 'backend'])->middleware('auth');


// Route untuk menambahkan foto 
Route::post('foto-mobil/store', [MobilController::class, 'storeFoto'])->name('backend.foto_mobil.store')->middleware('auth'); 
// Route untuk menghapus foto 
Route::delete('foto-mobil/{id}', [MobilController::class, 'destroyFoto'])->name('backend.foto_mobil.destroy')->middleware('auth'); 

// route form dan cetak laporan mobil
Route::get('backend/laporan/formmobil', [MobilController::class, 'formMobil'])->name('backend.laporan.formmobil')->middleware('auth'); 
Route::post('backend/laporan/cetakmobil', [MobilController::class, 'cetakMobil'])->name('backend.laporan.cetakmobil')->middleware('auth'); 

// route form dan cetak laporan merk
Route::get('backend/laporan/formmerk', [MerkController::class, 'formMerk'])->name('backend.laporan.formmerk')->middleware('auth'); 
Route::post('backend/laporan/cetakmerk', [MerkController::class, 'cetakMerk'])->name('backend.laporan.cetakmerk')->middleware('auth'); 

// route penyewa
Route::resource('backend/penyewa', PenyewaController::class, ['as' => 'backend'])->middleware('auth');

// Route untuk menambahkan foto 
Route::post('foto-penyewa/store', [PenyewaController::class, 'storeFoto'])->name('backend.foto_penyewa.store')->middleware('auth'); 
// Route untuk menghapus foto 
Route::delete('foto-penyewa/{id}', [PenyewaController::class, 'destroyFoto'])->name('backend.foto_penyewa.destroy')->middleware('auth'); 


Route::get('backend/laporan/formpenyewa', [PenyewaController::class, 'formPenyewa'])->name('backend.laporan.formpenyewa')->middleware('auth'); 
Route::post('backend/laporan/cetakpenyewa', [PenyewaController::class, 'cetakPenyewa'])->name('backend.laporan.cetakpenyewa')->middleware('auth'); 


Route::resource('backend/penyewaan', PenyewaanController::class, ['as' => 'backend'])->middleware('auth'); 
Route::prefix('backend/penyewaan')->name('backend.penyewaan.')->group(function() {
    Route::get('/create', [PenyewaanController::class, 'create'])->name('create');
    Route::post('/store', [PenyewaanController::class, 'store'])->name('store');
});
Route::prefix('backend/penyewaan')->name('backend.penyewaan.')->group(function() {
    Route::get('/edit/{penyewaan_id}', [PenyewaanController::class, 'edit'])->name('edit');
    Route::put('/update/{penyewaan_id}', [PenyewaanController::class, 'update'])->name('update');
});
Route::get('/penyewaan/edit/{penyewaan_id}', [PenyewaanController::class, 'edit'])->name('penyewaan.edit');



Route::get('backend/laporan/formpenyewaan', [PenyewaanController::class, 'formPenyewaan'])->name('backend.laporan.formpenyewaan')->middleware('auth'); 
Route::post('backend/laporan/cetakpenyewaan', [PenyewaanController::class, 'cetakPenyewaan'])->name('backend.laporan.cetakpenyewaan')->middleware('auth'); 



