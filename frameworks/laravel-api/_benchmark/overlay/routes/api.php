<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\BenchmarkTelemetry;


/* *** PHP-Frameworks-Bench *** */
Route::get('/hello/index', [App\Http\Controllers\HelloWorldController::class, 'index'])
    ->middleware(BenchmarkTelemetry::class);
