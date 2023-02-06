<?php

use Illuminate\Support\Facades\Route;
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
| Login Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/dashboard');

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/tmasuk/tmasuk_ajax', [TMasukController::class, 'tmasuk_ajax'])->name('tmasuk.ajax');
// Route::get('/tmasuk/search', [TMasukController::class, 'search'])->name('tmasuk.search');
// Route::get('tmasuk/list', [TMasukController::class, 'tableMaker'])->name('tmasuk.list');
Route::resource('/tmasuk', TMasukController::class);
Route::resource('/tkeluar', TKeluarController::class);
Route::resource('/label', LabelController::class);
Route::get('/sampah', function () {
    return view('dashboard.sampah');
});

Route::get('/download', function () {
    return view('dashboard.download');
});
Route::resource('/makun', MAkunController::class);
