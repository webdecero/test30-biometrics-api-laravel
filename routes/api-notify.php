<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Notify\KioskController;
use App\Http\Controllers\Notify\RegistryController;
use App\Http\Controllers\Notify\TorniquetController;



Route::name('registry.')->prefix('registry')->group(function () {
    Route::post('/valid', [RegistryController::class, 'valid'])->name('valid');
});

Route::name('kiosk.')->prefix('kiosk')->group(function () {
    Route::post('/valid', [KioskController::class, 'valid'])->name('valid');
});


Route::name('torniquet.')->prefix('torniquet')->group(function () {
    Route::post('/valid', [TorniquetController::class, 'valid'])->name('valid');
});

