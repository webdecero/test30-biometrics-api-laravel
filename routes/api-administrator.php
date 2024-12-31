<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Administrator\GroupController;
use App\Http\Controllers\Administrator\KioskController;
use App\Http\Controllers\Administrator\CompanyController;
use App\Http\Controllers\Administrator\LocationController;
use App\Http\Controllers\Administrator\RegistryController;
use App\Http\Controllers\Administrator\TorniquetController;
use App\Http\Controllers\Administrator\RecognitionController;

Route::middleware(['api', 'client'])->group(function () {

    Route::name('company.')->prefix('company')->group(function () {

        Route::put('/{id}/status', [CompanyController::class, 'status'])->name('status');
        Route::get('/', [CompanyController::class, 'index'])->name('index');
        Route::post('/', [CompanyController::class, 'store'])->name('store');
        Route::put('/{id}', [CompanyController::class, 'update'])->name('update');
        Route::get('/{id}', [CompanyController::class, 'show'])->name('show');

    });

    Route::name('location.')->prefix('location')->group(function () {

        Route::put('/{id}/status', [LocationController::class, 'status'])->name('status');
        Route::get('/', [LocationController::class, 'index'])->name('index');
        Route::post('/', [LocationController::class, 'store'])->name('store');
        Route::put('/{id}', [LocationController::class, 'update'])->name('update');
        Route::get('/{id}', [LocationController::class, 'show'])->name('show');
        Route::delete('/{id}', [LocationController::class, 'destroy'])->name('destroy');
    });


    Route::name('recognition.')->prefix('recognition')->group(function () {

        Route::put('/{id}/reset', [RecognitionController::class, 'reset'])->name('reset');
        Route::put('/{id}/status', [RecognitionController::class, 'status'])->name('status');
        Route::get('/', [RecognitionController::class, 'index'])->name('index');
        Route::post('/', [RecognitionController::class, 'store'])->name('store');
        Route::put('/{id}', [RecognitionController::class, 'update'])->name('update');
        Route::get('/{id}', [RecognitionController::class, 'show'])->name('show');
        Route::delete('/{id}', [RecognitionController::class, 'destroy'])->name('destroy');
    });


    Route::name('registry.')->prefix('registry')->group(function () {

        Route::put('/{id}/reset', [RegistryController::class, 'reset'])->name('reset');
        Route::put('/{id}/status', [RegistryController::class, 'status'])->name('status');
        Route::get('/', [RegistryController::class, 'index'])->name('index');
        Route::post('/', [RegistryController::class, 'store'])->name('store');
        Route::put('/{id}', [RegistryController::class, 'update'])->name('update');
        Route::get('/{id}', [RegistryController::class, 'show'])->name('show');
        Route::delete('/{id}', [RegistryController::class, 'destroy'])->name('destroy');
    });

    Route::name('torniquet.')->prefix('torniquet')->group(function () {

        Route::put('/{id}/reset', [TorniquetController::class, 'reset'])->name('reset');
        Route::put('/{id}/status', [TorniquetController::class, 'status'])->name('status');
        Route::get('/', [TorniquetController::class, 'index'])->name('index');
        Route::post('/', [TorniquetController::class, 'store'])->name('store');
        Route::put('/{id}', [TorniquetController::class, 'update'])->name('update');
        Route::get('/{id}', [TorniquetController::class, 'show'])->name('show');
        Route::delete('/{id}', [TorniquetController::class, 'destroy'])->name('destroy');
    });


    Route::name('kiosk.')->prefix('kiosk')->group(function () {

        Route::put('/{id}/reset', [KioskController::class, 'reset'])->name('reset');
        Route::put('/{id}/status', [KioskController::class, 'status'])->name('status');
        Route::get('/', [KioskController::class, 'index'])->name('index');
        Route::post('/', [KioskController::class, 'store'])->name('store');
        Route::put('/{id}', [KioskController::class, 'update'])->name('update');
        Route::get('/{id}', [KioskController::class, 'show'])->name('show');
        Route::delete('/{id}', [KioskController::class, 'destroy'])->name('destroy');
    });




    /////////////////////////////////Finalizado/////////////////////////////////



    Route::name('group.')->prefix('group')->group(function () {
        Route::get('/', [GroupController::class, 'index'])->name('index');
        Route::post('/', [GroupController::class, 'store'])->name('store');
        Route::put('/{id}', [GroupController::class, 'update'])->name('update');
        Route::get('/{id}', [GroupController::class, 'show'])->name('show');
    });
});
