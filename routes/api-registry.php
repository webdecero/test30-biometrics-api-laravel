<?php


use App\Http\Controllers\Registry\FaceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Registry\UserController;
use App\Http\Controllers\Registry\GroupController;
use App\Http\Controllers\Registry\LoginController;
use App\Http\Controllers\Registry\AccessController;
use App\Http\Controllers\Registry\ConfigController;
use App\Http\Controllers\Registry\FingerprintController;
use Webdecero\Package\Core\Controllers\File\FileController;
use App\Http\Controllers\Registry\Profile\ProfileController;
use Webdecero\Package\Core\Controllers\Image\ImageController;
use App\Http\Controllers\Registry\Profile\NotificationController;


Route::name('admin.')->prefix('admin')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/recovery', [LoginController::class, 'recovery'])->name('recovery');

    Route::name('validate.')->prefix('validate')->group(function () {
        Route::post('/auth', [LoginController::class, 'validateAuth'])->name('auth');
        Route::post('/recovery', [LoginController::class, 'validateRecovery'])->name('recovery');
        Route::post('/resend', [LoginController::class, 'validateResend'])->name('resend');
    });

});

Route::name('config.')->prefix('config')->group(function () {
    Route::post('/setup', [ConfigController::class, 'setup'])->name('setup');
    Route::post('/theme', [ConfigController::class, 'theme'])->name('theme');
});


Route::middleware(['auth:admin'])->group(function () {

    Route::name('profile.')->prefix('profile')->group(function () {

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('/config', [ProfileController::class, 'config'])->name('config');

        Route::get('/access', [ProfileController::class, 'access'])->name('access');
        Route::put('/password', [ProfileController::class, 'password'])->name('password');

        Route::get('/', [ProfileController::class, 'info'])->name('info');
        Route::put('/', [ProfileController::class, 'updateProfile'])->name('update');


        Route::name('notification.')->prefix('notification')->group(function () {

            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::put('/{id}/clicked', [NotificationController::class, 'clicked'])->name('clicked');
            Route::delete('/all', [NotificationController::class, 'destroyAll'])->name('destroy.all');
            Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        });



    });

    Route::name('user.')->prefix('user')->group(function () {

        Route::post('/search', [UserController::class, 'search'])->name('search');
        Route::post('/export', [UserController::class, 'export'])->name('export');
        Route::get('/config', [UserController::class, 'config'])->name('config');

        Route::get('/catalog/groups', [UserController::class, 'groups'])->name('catalog.groups');
        Route::get('/catalog/locations', [UserController::class, 'locations'])->name('catalog.locations');

        Route::put('/{id}/status', [UserController::class, 'status'])->name('status');
        Route::get('/{id}/faces', [UserController::class, 'faces'])->name('faces');
        Route::get('/{id}/fingerprints', [UserController::class, 'fingerprints'])->name('fingerprints');

        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::name('group.')->prefix('group')->group(function () {

        Route::post('/search', [GroupController::class, 'search'])->name('search');
        Route::get('/config', [GroupController::class, 'config'])->name('config');
        Route::put('/{id}/status', [GroupController::class, 'status'])->name('status');
        Route::get('/catalog/locations', [GroupController::class, 'locations'])->name('catalog.locations');
        Route::post('/export', [GroupController::class, 'export'])->name('export');

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
        Route::get('/{id}', [FingerprintController::class, 'show'])->name('show');
        Route::delete('/{id}', [FingerprintController::class, 'destroy'])->name('destroy');
    });




    Route::name('face.')->prefix('face')->group(function () {

        Route::post('/search', [FaceController::class, 'search'])->name('search');
        Route::get('/config', [FaceController::class, 'config'])->name('config');

        Route::get('/', [FaceController::class, 'index'])->name('index');
        Route::post('/', [FaceController::class, 'store'])->name('store');
        Route::get('/{id}', [FaceController::class, 'show'])->name('show');
        Route::delete('/{id}', [FaceController::class, 'destroy'])->name('destroy');
    });


    ///////////////////////// Finalizados ///////////////////////////////////////


    Route::name('access.')->prefix('access')->group(function () {

        Route::post('/search', [AccessController::class, 'search'])->name('search');
        Route::get('/config', [AccessController::class, 'config'])->name('config');

        Route::get('/', [AccessController::class, 'index'])->name('index');
        Route::post('/', [AccessController::class, 'store'])->name('store');
        Route::put('/{id}', [AccessController::class, 'update'])->name('update');
        Route::get('/{id}', [AccessController::class, 'show'])->name('show');
        Route::delete('/{id}', [AccessController::class, 'destroy'])->name('destroy');
    });




    Route::name('image.')->prefix('image')->group(function () {

        /*
        Route::post('/search', [ImageController::class, 'search'])->name('search');
        Route::get('/config', [ImageController::class, 'config'])->name('config');
        Route::post('/delete', [ImageController::class, 'delete'])->name('delete');
        Route::put('/{id}', [ImageController::class, 'update'])->name('update');
        Route::delete('/{id}', [ImageController::class, 'destroy'])->name('destroy');
        */

        Route::post('/', [ImageController::class, 'store'])->name('store');
        Route::get('/{id}', [ImageController::class, 'show'])->name('show');
    });

    Route::name('file.')->prefix('file')->group(function () {

        Route::post('/search', [FileController::class, 'search'])->name('search');
        Route::get('/config', [FileController::class, 'config'])->name('config');
        Route::post('/delete', [FileController::class, 'delete'])->name('delete');

        // Route::post('/parts', [FileController::class, 'uploadParts'])->name('parts');

        Route::post('/', [FileController::class, 'store'])->name('store');
        Route::put('/{id}', [FileController::class, 'update'])->name('update');
        Route::get('/{id}', [FileController::class, 'show'])->name('show');
        Route::delete('/{id}', [FileController::class, 'destroy'])->name('destroy');
    });
});
