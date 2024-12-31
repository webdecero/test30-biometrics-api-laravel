<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manager\UserController;
use App\Http\Controllers\Manager\GroupController;
use App\Http\Controllers\Manager\KioskController;
use App\Http\Controllers\Manager\AccessController;
use App\Http\Controllers\Manager\CompanyController;
use App\Http\Controllers\Manager\LocationController;
use App\Http\Controllers\Manager\RegistryController;
use App\Http\Controllers\Manager\TorniquetController;
use App\Http\Controllers\Manager\AccessRulesController;
use App\Http\Controllers\Manager\FingerprintController;
use Webdecero\Package\Core\Controllers\File\FileController;
use Webdecero\Package\Core\Controllers\Image\ImageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware(['auth:admin'])->group(function () {

    Route::name('location.')->prefix('location')->group(function () {
        ///////////////endoints de desarrollo, se deberan borrar al final
        /*
        */

        ///////////////endoints base
        Route::get('/', [LocationController::class, 'index'])->name('index');
        Route::get('/{id}', [LocationController::class, 'show'])->name('show');
        Route::get('/config', [LocationController::class, 'config'])->name('config');
        Route::post('/search', [LocationController::class, 'search'])->name('search');

        ///////////////enpoints de exportaciones
        Route::post('/export', [LocationController::class, 'export'])->name('export');
    });

    Route::name('group.')->prefix('group')->group(function () {

        ///////////////endoints de desarrollo, se deberan borrar al final
        /*
        Route::post('/', [GroupController::class, 'store'])->name('store');
        Route::delete('/{id}', [GroupController::class, 'destroy'])->name('destroy');
        */

        ///////////////endoints base
        Route::get('/', [GroupController::class, 'index'])->name('index');
        Route::get('/config', [GroupController::class, 'config'])->name('config');
        Route::post('/search', [GroupController::class, 'search'])->name('search');
        Route::post('/export', [GroupController::class, 'export'])->name('export');
        Route::get('/catalog/locations', [GroupController::class, 'locations'])->name('catalog.locations');

        Route::put('/{id}/status', [GroupController::class, 'status'])->name('status');

        Route::get('/{id}', [GroupController::class, 'show'])->name('show');
        Route::put('/{id}', [GroupController::class, 'update'])->name('update');

    });

    Route::name('user.')->prefix('user')->group(function(){

        ///////////////endoints de desarrollo, se deberan borrar al final
        /*
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/config', [UserController::class, 'config'])->name('config');
        Route::post('/', [UserController::class, 'store'])->name('store');
        */

        ///////////////endoints base
        Route::post('/export', [UserController::class, 'export'])->name('export');
        Route::post('/search', [UserController::class, 'search'])->name('search');
        Route::get('/catalog/locations', [UserController::class, 'locations'])->name('catalog.locations');
        Route::get('/notifications', [UserController::class, 'notifications'])->name('notifications');

        Route::put('/{id}/status', [UserController::class, 'status'])->name('status');

        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');

    });

    Route::name('registry.')->prefix('registry')->group(function () {

        ///////////////endoints de desarrollo, se deberan borrar al final
        /*
        Route::post('/', [KioskController::class, 'store'])->name('store');
        Route::put('/{id}', [KioskController::class, 'update'])->name('update');
        Route::delete('/{id}', [KioskController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/status', [KioskController::class, 'status'])->name('status');
        */

        ///////////////endoints base
        Route::get('/', [RegistryController::class, 'index'])->name('index');
        Route::get('/config', [RegistryController::class, 'config'])->name('config');
        Route::post('/export', [RegistryController::class, 'export'])->name('export');
        Route::post('/search', [RegistryController::class, 'search'])->name('search');
        Route::get('/catalog/locations', [RegistryController::class, 'locations'])->name('catalog.locations');

        Route::get('/{id}', [RegistryController::class, 'show'])->name('show');
    });

    Route::name('kiosk.')->prefix('kiosk')->group(function () {

        ///////////////endoints de desarrollo, se deberan borrar al final
        /*
        Route::post('/', [KioskController::class, 'store'])->name('store');
        Route::put('/{id}', [KioskController::class, 'update'])->name('update');
        Route::delete('/{id}', [KioskController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/status', [KioskController::class, 'status'])->name('status');
        */

        ///////////////endoints base
        Route::get('/', [KioskController::class, 'index'])->name('index');
        Route::get('/config', [KioskController::class, 'config'])->name('config');
        Route::post('/search', [KioskController::class, 'search'])->name('search');
        Route::post('/export', [KioskController::class, 'export'])->name('export');
        Route::get('/catalog/locations', [KioskController::class, 'locations'])->name('catalog.locations');

        Route::get('/{id}', [KioskController::class, 'show'])->name('show');
    });

    Route::name('torniquet.')->prefix('torniquet')->group(function () {

        ///////////////endoints de desarrollo, se deberan borrar al final
        /*
        Route::post('/', [TorniquetController::class, 'store'])->name('store');
        Route::put('/{id}', [TorniquetController::class, 'update'])->name('update');
        Route::delete('/{id}', [TorniquetController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/status', [TorniquetController::class, 'status'])->name('status');
        */

        ///////////////endoints base
        Route::get('/', [TorniquetController::class, 'index'])->name('index');
        Route::get('/config', [TorniquetController::class, 'config'])->name('config');
        Route::post('/search', [TorniquetController::class, 'search'])->name('search');
        Route::post('/export', [TorniquetController::class, 'export'])->name('export');
        Route::get('/catalog/locations', [TorniquetController::class, 'locations'])->name('catalog.locations');

        Route::get('/{id}', [TorniquetController::class, 'show'])->name('show');
    });

    Route::name('company.')->prefix('company')->group(function(){
        ///////////////endoints de desarrollo, se deberan borrar al final
        /*
        Route::get('/',[CompanyController::class, 'index'])->name('index');
        Route::post('/',[CompanyController::class, 'store'])->name('store');
        Route::get('/config', [CompanyController::class, 'config'])->name('config');
        Route::post('/search', [CompanyController::class, 'search'])->name('search');
        Route::delete('/{id}',[CompanyController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/status', [CompanyController::class, 'status'])->name('status');
        */

        ///////////////endoints base
        Route::get('/{id}',[CompanyController::class, 'show'])->name('show');
        Route::put('/{id}',[CompanyController::class, 'update'])->name('update');
    });


    Route::name('fingerprint.')->prefix('fingerprint')->group(function () {

        ///////////////endoints de desarrollo, se deberan borrar al final
        /*
        Route::get('/', [FingerprintController::class, 'index'])->name('index');
        Route::get('/config', [FingerprintController::class, 'config'])->name('config');
        */

        ///////////////endoints base
        Route::post('/search', [FingerprintController::class, 'search'])->name('search');

        Route::get('/{id}', [FingerprintController::class, 'show'])->name('show');
        Route::delete('/{id}', [FingerprintController::class, 'destroy'])->name('destroy');
    });

    Route::name('access.')->prefix('access')->group(function () {

        ///////////////endoints de desarrollo, se deberan borrar al final
        /*
        */

        ///////////////endoints base
        Route::get('/', [AccessController::class, 'index'])->name('index');
        Route::post('/', [AccessController::class, 'store'])->name('store');
        Route::get('/config', [AccessController::class, 'config'])->name('config');
        Route::post('/search', [AccessController::class, 'search'])->name('search');
        Route::get('/catalog/companies', [AccessController::class, 'companies'])->name('catalog.companies');
        Route::get('/catalog/locations', [AccessController::class, 'locations'])->name('catalog.locations');

        Route::get('/{id}', [AccessController::class, 'show'])->name('show');
        Route::put('/{id}', [AccessController::class, 'update'])->name('update');
        Route::delete('/{id}', [AccessController::class, 'destroy'])->name('destroy');
    });

    Route::name('image.')->prefix('image')->group(function () {

        ///////////////endoints de desarrollo, se deberan borrar al final
        /*
        Route::put('/{id}', [ImageController::class, 'update'])->name('update');
        Route::get('/config', [ImageController::class, 'config'])->name('config');
        Route::post('/search', [ImageController::class, 'search'])->name('search');
        Route::post('/delete', [ImageController::class, 'delete'])->name('delete');
        Route::delete('/{id}', [ImageController::class, 'destroy'])->name('destroy');
        */

        ///////////////endoints base
        Route::post('/', [ImageController::class, 'store'])->name('store');

        Route::get('/{id}', [ImageController::class, 'show'])->name('show');
    });

    Route::name('file.')->prefix('file')->group(function () {

        ///////////////endoints de desarrollo, se deberan borrar al final
        /*
        Route::put('/{id}', [FileController::class, 'update'])->name('update');
        Route::get('/config', [FileController::class, 'config'])->name('config');
        Route::post('/delete', [FileController::class, 'delete'])->name('delete');
        Route::post('/search', [FileController::class, 'search'])->name('search');
        Route::delete('/{id}', [FileController::class, 'destroy'])->name('destroy');
        Route::post('/parts', [FileController::class, 'uploadParts'])->name('parts');
        */

        ///////////////endoints base
        Route::post('/', [FileController::class, 'store'])->name('store');

        Route::get('/{id}', [FileController::class, 'show'])->name('show');
    });

    Route::name('access-rules.')->prefix('access-rules')->group(function () {

        ///////////////endoints de desarrollo, se deberan borrar al final
        /*
        */

        ///////////////endoints base
        Route::post('/', [AccessRulesController::class, 'store'])->name('store');
        Route::get('/', [AccessRulesController::class, 'index'])->name('index');
        Route::get('/config', [AccessRulesController::class, 'config'])->name('config');
        Route::post('/search', [AccessRulesController::class, 'search'])->name('search');
        Route::get('/validations', [AccessRulesController::class, 'validations'])->name('validations');

        //Route::get('/{id}', [AccessRulesController::class, 'show'])->name('show');
        Route::put('/{id}', [AccessRulesController::class, 'update'])->name('update');
        Route::delete('/{id}', [AccessRulesController::class, 'destroy'])->name('destroy');

    });
});

