<?php

use Illuminate\Support\Facades\Route;


/* *** PHP-Frameworks-Bench *** */
Route::get('/hello/index', [App\Http\Controllers\HelloWorldController::class, 'index']);
Route::get('/hello/{value}/index', [App\Http\Controllers\HelloWorldController::class, 'index']);
Route::get('/hello/index/{value}', [App\Http\Controllers\HelloWorldController::class, 'index']);
