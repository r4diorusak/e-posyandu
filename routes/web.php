<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\UsersController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
// Protected routes: require authentication
Route::middleware('auth')->group(function () {
	// Pegawai CRUD (migrated from modul/mod_pegawai)
	Route::resource('pegawai', PegawaiController::class)->except(['show']);

	// Users management (migrated from modul/mod_users)
	Route::resource('users', UsersController::class)->except(['show']);

	// Posyandu (patients + medical records)
	Route::get('/posyandu', [PosyanduController::class,'index'])->name('posyandu.index');
	Route::get('/posyandu/create', [PosyanduController::class,'create'])->name('posyandu.create');
	Route::post('/posyandu', [PosyanduController::class,'storePatient'])->name('posyandu.store');
	Route::get('/posyandu/{id}', [PosyanduController::class,'show'])->name('posyandu.show');
	Route::delete('/posyandu/{id}', [PosyanduController::class,'destroyPatient'])->name('posyandu.destroyPatient');

	// records
	Route::post('/posyandu/{id}/records', [PosyanduController::class,'storeRecord'])->name('posyandu.records.store');
	Route::delete('/posyandu/{id}/records/{no}', [PosyanduController::class,'destroyRecord'])->name('posyandu.records.destroy');

	// Produk (migrated from modul/mod_produk)
	Route::resource('produk', \App\Http\Controllers\ProdukController::class)->except(['show']);

	// Laporan (PDF)
	Route::get('/laporan/pasien/{id}/pdf', [\App\Http\Controllers\LaporanController::class,'rekamPdf'])->name('laporan.pasien.pdf');

	// Password change
	Route::get('/password/change', [\App\Http\Controllers\PasswordController::class,'showChangeForm'])->name('password.form');
	Route::post('/password/change', [\App\Http\Controllers\PasswordController::class,'change'])->name('password.change');

	// Home route (accessible only when authenticated)
	Route::get('/home', [HomeController::class, 'index'])->name('home');
});

