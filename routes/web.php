<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DanaController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MAkunController;
use App\Http\Controllers\TMasukController;
use App\Http\Controllers\TKeluarController;
use App\Http\Controllers\DashboardController;

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
| Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/dashboard');

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/dashboard/dashboardData', [DashboardController::class, 'dashboardData']);
Route::get('/tmasuk/tmasuk_ajax', [TMasukController::class, 'tmasuk_ajax'])->name('tmasuk.ajax');
Route::resource('/tmasuk', TMasukController::class);
Route::get('/tkeluar/tkeluar_ajax', [TKeluarController::class, 'tkeluar_ajax'])->name('tkeluar.ajax');
Route::resource('/tkeluar', TKeluarController::class);
Route::get('/label/label_ajax', [LabelController::class, 'label_ajax'])->name('label.ajax');
Route::resource('/label', LabelController::class);
Route::get('/sampah', function () {
    return view('dashboard.sampah');
});

Route::get('/download', function () {
    return view('dashboard.download');
});

Route::get('/makun/makun_ajax', [MAkunController::class, 'makun_ajax'])->name('makun.ajax');
Route::resource('/makun', MAkunController::class);
Route::resource('/dana', DanaController::class);
