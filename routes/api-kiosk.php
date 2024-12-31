<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kiosk\UserController;
use App\Http\Controllers\Kiosk\GroupController;
use App\Http\Controllers\Kiosk\AccessController;
use App\Http\Controllers\Kiosk\ConfigController;
use App\Http\Controllers\Kiosk\FingerprintController;

Route::name('config.')->prefix('config')->group(function () {
    Route::post('/setup', [ConfigController::class, 'setup'])->name('setup');
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

    Route::name('group.')->prefix('group')->group(function () {

        Route::post('/search', [GroupController::class, 'search'])->name('search');
        Route::get('/config', [GroupController::class, 'config'])->name('config');
        Route::put('/{id}/status', [GroupController::class, 'status'])->name('status');

        Route::get('/', [GroupController::class, 'index'])->name('index');
        Route::post('/', [GroupController::class, 'store'])->name('store');
        Route::put('/{id}', [GroupController::class, 'update'])->name('update');
        Route::get('/{id}', [GroupController::class, 'show'])->name('show');
        Route::delete('/{id}', [GroupController::class, 'destroy'])->name('destroy');
    });

    Route::name('fingerprint.')->prefix('fingerprint')->group(function () {

        Route::post('/search', [FingerprintController::class, 'search'])->name('search');
        Route::get('/config', [FingerprintController::class, 'config'])->name('config');

        Route::get('/', [FingerprintController::class, 'index'])->name('index');
        Route::post('/', [FingerprintController::class, 'store'])->name('store');
        Route::put('/{id}', [FingerprintController::class, 'update'])->name('update');
        Route::get('/{id}', [FingerprintController::class, 'show'])->name('show');
        Route::delete('/{id}', [FingerprintController::class, 'destroy'])->name('destroy');

    });

    Route::name('user.')->prefix('user')->group(function () {

        Route::get('/notifications', [UserController::class, 'notifications'])->name('notifications');
        Route::post('/matcher/fingerprint', [UserController::class, 'matchFingerprint'])->name('matchFingerprint');
        Route::post('/matcher/face', [UserController::class, 'matchFace'])->name('matchFace');


        Route::get('/info', [UserController::class, 'info'])->name('info');
        Route::get('/scopes', [UserController::class, 'scopes'])->name('scopes');
        Route::get('/test', [UserController::class, 'test'])->name('test');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
    });
});
