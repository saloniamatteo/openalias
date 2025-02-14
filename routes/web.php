<?php

// Don't forget to run this in production!
// php artisan route:cache

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Throttle all requests using the "global" throttler.
Route::middleware(['throttle:global'])->group(function () {
    // Page request (can be blank for index)
    Route::get('/', [PageController::class, 'index']);
});
