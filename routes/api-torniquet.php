<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Torniquet\UserController;

use App\Http\Controllers\Torniquet\AccessController;
use App\Http\Controllers\Torniquet\ConfigController;

Route::name('config.')->prefix('config')->group(function () {
    Route::post('/setup', [ConfigController::class, 'setup'])->name('setup');
    Route::post('/theme', [ConfigController::class, 'theme'])->name('theme');
});



Route::middleware('api')->group(function () {

    Route::name('access.')->prefix('access')->group(function () {

        Route::post('/search', [AccessController::class, 'search'])->name('search');
        Route::get('/config', [AccessController::class, 'config'])->name('config');

        Route::get('/', [AccessController::class, 'index'])->name('index');
        Route::post('/', [AccessController::class, 'store'])->name('store');
        Route::put('/{id}', [AccessController::class, 'update'])->name('update');
        Route::get('/{id}', [AccessController::class, 'show'])->name('show');
        Route::delete('/{id}', [AccessController::class, 'destroy'])->name('destroy');

    });
    Route::name('user.')->prefix('user')->group(function () {
        Route::get('/notifications', [UserController::class, 'notifications'])->name('notifications');
        Route::post('/matcher/fingerprint', [UserController::class, 'matchFingerprint'])->name('matchFingerprint');
        Route::post('/matcher/face', [UserController::class, 'matchFace'])->name('matchFace');
    });


});
