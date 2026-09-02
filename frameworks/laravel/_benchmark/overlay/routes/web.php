<?php

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
    return view('welcome');
});


/* *** PHP-Frameworks-Bench *** */
Route::get('/hello/index', [App\Http\Controllers\HelloWorldController::class, 'index']);
Route::get('/hello/{value}/index', [App\Http\Controllers\HelloWorldController::class, 'index']);
Route::get('/hello/index/{value}', [App\Http\Controllers\HelloWorldController::class, 'index']);
Route::get('/{value}/hello/index', [App\Http\Controllers\HelloWorldController::class, 'index']);
Route::get('/hello/pair/{first}/{second}', [App\Http\Controllers\HelloWorldController::class, 'index']);
Route::get('/hello/benchmark/fixed', [App\Http\Controllers\HelloWorldController::class, 'index']);
Route::get('/hello/{value}/fixed', [App\Http\Controllers\HelloWorldController::class, 'index']);
