<?php

use Illuminate\Support\Facades\Route;


/* *** PHP-Frameworks-Bench *** */
Route::get('/hello/index', [App\Http\Controllers\HelloWorldController::class, 'index']);
Route::get('/hello/{value}/index', [App\Http\Controllers\HelloWorldController::class, 'index']);
Route::get('/hello/index/{value}', [App\Http\Controllers\HelloWorldController::class, 'index']);
Route::get('/{value}/hello/index', [App\Http\Controllers\HelloWorldController::class, 'index']);
Route::get('/hello/pair/{first}/{second}', [App\Http\Controllers\HelloWorldController::class, 'index']);
Route::get('/hello/benchmark/fixed', [App\Http\Controllers\HelloWorldController::class, 'index']);
Route::get('/hello/{value}/fixed', [App\Http\Controllers\HelloWorldController::class, 'index']);
