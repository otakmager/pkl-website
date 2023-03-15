<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DanaController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MAkunController;
use App\Http\Controllers\TMasukController;
use App\Http\Controllers\TKeluarController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SampahMasukController;
use App\Http\Controllers\SampahKeluarController;

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

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| Redirect Routes
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/dashboard');
Route::redirect('/sampah', '/sampah-masuk');
/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/dashboard/dashboardData', [DashboardController::class, 'dashboardData']);
Route::resource('/dana', DanaController::class);
/*
|--------------------------------------------------------------------------
| TMasuk Routes
|--------------------------------------------------------------------------
*/
Route::get('/tmasuk/tmasuk_ajax', [TMasukController::class, 'tmasuk_ajax'])->name('tmasuk.ajax');
Route::resource('/tmasuk', TMasukController::class);
/*
|--------------------------------------------------------------------------
| TKeluar Routes
|--------------------------------------------------------------------------
*/
Route::get('/tkeluar/tkeluar_ajax', [TKeluarController::class, 'tkeluar_ajax'])->name('tkeluar.ajax');
Route::resource('/tkeluar', TKeluarController::class);
/*
|--------------------------------------------------------------------------
| Label Routes
|--------------------------------------------------------------------------
*/
Route::get('/label/label_ajax', [LabelController::class, 'label_ajax'])->name('label.ajax');
Route::get('/label/label_sum/{label}', [LabelController::class, 'label_sum'])->name('label.sum');
Route::resource('/label', LabelController::class);
/*
|--------------------------------------------------------------------------
| Sampah Masuk Routes
|--------------------------------------------------------------------------
*/
Route::get('/sampah-masuk/sampah_ajax', [SampahMasukController::class, 'sampah_ajax'])->name('sampah-masuk.ajax');
Route::get('/sampah-masuk', [SampahMasukController::class, 'index'])->name('sampah-masuk.index');
Route::delete('/sampah-masuk/{id}', [SampahMasukController::class, 'destroy'])->name('sampah-masuk.destroy');
Route::put('/sampah-masuk/{id}', [SampahMasukController::class, 'restore'])->name('sampah-masuk.restore');
Route::post('/sampah-masuk/dsome/', [SampahMasukController::class, 'destroySelectedData'])->name('sampah-masuk.destroy-some');
Route::post('/sampah-masuk/rsome/', [SampahMasukController::class, 'restoreSelectedData'])->name('sampah-masuk.restore-some');
Route::delete('/sampah/masuk/delete-all', [SampahMasukController::class, 'destoryAll'])->name('sampah-masuk.destroy-all');
Route::put('/sampah/masuk/restore-all', [SampahMasukController::class, 'restoreAll'])->name('sampah-masuk.restore-all');
/*
|--------------------------------------------------------------------------
| Sampah Keluar Routes
|--------------------------------------------------------------------------
*/
Route::get('/sampah-keluar/sampah_ajax', [SampahKeluarController::class, 'sampah_ajax'])->name('sampah-keluar.ajax');
Route::get('/sampah-keluar', [SampahKeluarController::class, 'index'])->name('sampah-keluar.index');
Route::delete('/sampah-keluar/{id}', [SampahKeluarController::class, 'destroy'])->name('sampah-keluar.destroy');
Route::put('/sampah-keluar/{id}', [SampahKeluarController::class, 'restore'])->name('sampah-keluar.restore');
Route::post('/sampah-keluar/dsome/', [SampahKeluarController::class, 'destroySelectedData'])->name('sampah-keluar.destroy-some');
Route::post('/sampah-keluar/rsome/', [SampahKeluarController::class, 'restoreSelectedData'])->name('sampah-keluar.restore-some');
Route::delete('/sampah/keluar/delete-all', [SampahKeluarController::class, 'destoryAll'])->name('sampah-keluar.destroy-all');
Route::put('/sampah/keluar/restore-all', [SampahKeluarController::class, 'restoreAll'])->name('sampah-keluar.restore-all');
/*
|--------------------------------------------------------------------------
| Download Routes
|--------------------------------------------------------------------------
*/
Route::get('/download', [DownloadController::class, 'index'])->name('download.index');
Route::get('/download/format/excel', [DownloadController::class, 'downloadExcel'])->name('download-excel');
Route::get('/download/format/pdf', [DownloadController::class, 'downloadPDF'])->name('download-pdf');

/*
|--------------------------------------------------------------------------
| Manajemen Akun Routes
|--------------------------------------------------------------------------
*/
Route::get('/makun/makun_ajax', [MAkunController::class, 'makun_ajax'])->name('makun.ajax');
Route::resource('/makun', MAkunController::class);
