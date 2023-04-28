<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DanaController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MAkunController;
use App\Http\Controllers\TMasukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TKeluarController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SampahMasukController;
use App\Http\Controllers\SampahKeluarController;
use App\Http\Controllers\ForgetPasswordController;

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
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Forget Password Routes
|--------------------------------------------------------------------------
*/
Route::get('/forget-password', [ForgetPasswordController::class, 'index'])->name('forget.index');
Route::get('/forget-password/cek', [ForgetPasswordController::class, 'cek'])->name('forget.cek');
Route::get('/forget-password/get-soal/{user:email}', [ForgetPasswordController::class, 'getSoal'])->name('forget.soal');
Route::get('/forget-password/validasi-soal/{user:email}', [ForgetPasswordController::class, 'validasiSoal'])->name('forget.valid');
Route::put('/forget-password/reset-pass/{user:email}', [ForgetPasswordController::class, 'resetPass'])->name('forget.reset');

/*
|--------------------------------------------------------------------------
| Redirect Routes
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/dashboard')->middleware('auth');
Route::redirect('/sampah', '/sampah-masuk')->middleware('auth');
/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard/dashboardData', [DashboardController::class, 'dashboardData'])->middleware('pimpinan');
Route::resource('/dana', DanaController::class)->middleware('pimpinan');
/*
|--------------------------------------------------------------------------
| TMasuk Routes
|--------------------------------------------------------------------------
*/
Route::get('/tmasuk/tmasuk_ajax', [TMasukController::class, 'tmasuk_ajax'])->name('tmasuk.ajax')->middleware('auth');
Route::resource('/tmasuk', TMasukController::class)->middleware('auth');
/*
|--------------------------------------------------------------------------
| TKeluar Routes
|--------------------------------------------------------------------------
*/
Route::get('/tkeluar/tkeluar_ajax', [TKeluarController::class, 'tkeluar_ajax'])->name('tkeluar.ajax')->middleware('auth');
Route::resource('/tkeluar', TKeluarController::class)->middleware('auth');
/*
|--------------------------------------------------------------------------
| Label Routes
|--------------------------------------------------------------------------
*/
Route::get('/label/label_ajax', [LabelController::class, 'label_ajax'])->name('label.ajax')->middleware('pimpinan');
Route::get('/label/label_sum/{label}', [LabelController::class, 'label_sum'])->name('label.sum')->middleware('pimpinan');
Route::resource('/label', LabelController::class)->middleware('pimpinan');
/*
|--------------------------------------------------------------------------
| Sampah Masuk Routes
|--------------------------------------------------------------------------
*/
Route::get('/sampah-masuk/sampah_ajax', [SampahMasukController::class, 'sampah_ajax'])->name('sampah-masuk.ajax')->middleware('auth');
Route::get('/sampah-masuk', [SampahMasukController::class, 'index'])->name('sampah-masuk.index')->middleware('auth');
Route::delete('/sampah-masuk/{id}', [SampahMasukController::class, 'destroy'])->name('sampah-masuk.destroy')->middleware('auth');
Route::put('/sampah-masuk/{id}', [SampahMasukController::class, 'restore'])->name('sampah-masuk.restore')->middleware('auth');
Route::post('/sampah-masuk/dsome/', [SampahMasukController::class, 'destroySelectedData'])->name('sampah-masuk.destroy-some')->middleware('auth');
Route::post('/sampah-masuk/rsome/', [SampahMasukController::class, 'restoreSelectedData'])->name('sampah-masuk.restore-some')->middleware('auth');
Route::delete('/sampah/masuk/delete-all', [SampahMasukController::class, 'destoryAll'])->name('sampah-masuk.destroy-all')->middleware('auth');
Route::put('/sampah/masuk/restore-all', [SampahMasukController::class, 'restoreAll'])->name('sampah-masuk.restore-all')->middleware('auth');
/*
|--------------------------------------------------------------------------
| Sampah Keluar Routes
|--------------------------------------------------------------------------
*/
Route::get('/sampah-keluar/sampah_ajax', [SampahKeluarController::class, 'sampah_ajax'])->name('sampah-keluar.ajax')->middleware('auth');
Route::get('/sampah-keluar', [SampahKeluarController::class, 'index'])->name('sampah-keluar.index')->middleware('auth');
Route::delete('/sampah-keluar/{id}', [SampahKeluarController::class, 'destroy'])->name('sampah-keluar.destroy')->middleware('auth');
Route::put('/sampah-keluar/{id}', [SampahKeluarController::class, 'restore'])->name('sampah-keluar.restore')->middleware('auth');
Route::post('/sampah-keluar/dsome/', [SampahKeluarController::class, 'destroySelectedData'])->name('sampah-keluar.destroy-some')->middleware('auth');
Route::post('/sampah-keluar/rsome/', [SampahKeluarController::class, 'restoreSelectedData'])->name('sampah-keluar.restore-some')->middleware('auth');
Route::delete('/sampah/keluar/delete-all', [SampahKeluarController::class, 'destoryAll'])->name('sampah-keluar.destroy-all')->middleware('auth');
Route::put('/sampah/keluar/restore-all', [SampahKeluarController::class, 'restoreAll'])->name('sampah-keluar.restore-all')->middleware('auth');
/*
|--------------------------------------------------------------------------
| Download Routes
|--------------------------------------------------------------------------
*/
Route::get('/download', [DownloadController::class, 'index'])->name('download.index')->middleware('pimpinan');
Route::get('/download/format/excel', [DownloadController::class, 'downloadExcel'])->name('download-excel')->middleware('pimpinan');
Route::get('/download/format/pdf', [DownloadController::class, 'downloadPDF'])->name('download-pdf')->middleware('pimpinan');
Route::get('/download/template/export/pdf', [DownloadController::class, 'templatePDF'])->name('template-pdf')->middleware('pimpinan');

/*
|--------------------------------------------------------------------------
| Manajemen Akun Routes
|--------------------------------------------------------------------------
*/
Route::get('/makun/makun_ajax', [MAkunController::class, 'makun_ajax'])->name('makun.ajax')->middleware('pimpinan');
Route::resource('/makun', MAkunController::class)->middleware('pimpinan');

/*
|--------------------------------------------------------------------------
| Pengaturan Profile Akun Routes
|--------------------------------------------------------------------------
*/
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');
Route::put('/profile/resetPass/{user:username}', [ProfileController::class, 'resetPass'])->name('profile.resetPass')->middleware('auth');
Route::put('/profile/deletePhoto/{user:username}', [ProfileController::class, 'deletePhoto'])->name('profile.deletePhoto')->middleware('auth');
Route::post('/profile/update/{user:username}', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::get('/profile/recovInfo/{user:username}', [ProfileController::class, 'recovInfo'])->name('profile.recovInfo')->middleware('auth');
Route::put('/profile/updateRecov/{user:username}', [ProfileController::class, 'updateRecov'])->name('profile.updateRecov')->middleware('auth');
