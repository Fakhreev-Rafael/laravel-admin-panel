<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\PermissionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// GET	        /photos	                index	photos.index
// GET	        /photos/create	        create	photos.create
// POST	        /photos	                store	photos.store
// GET	        /photos/{photo}	        show	photos.show
// GET	        /photos/{photo}/edit	edit	photos.edit
// PUT/PATCH	/photos/{photo}	        update	photos.update
// DELETE	    /photos/{photo}	        destroy	photos.destroy

Route::prefix('/admin')->name('admin.')->group(function() {

    Route::middleware(['guest', /*'throttle:5,1'*/])->group(function() {
        Route::prefix('/auth')->name('auth.')->group(function() {
            Route::prefix('/login')->name('login.')->group(function() {
                Route::get('/', [LoginController::class, 'index'])->name('index');
                Route::post('/', [LoginController::class, 'handle'])->name('handle');
            });
        });
    });

    Route::middleware(['auth:employee', 'throttle:60,1'])->group(function() {
        Route::prefix('/auth')->name('auth.')->group(function() {
            Route::get('/logout', [LogoutController::class, 'handle'])->name('logout.handle');
        });

        Route::prefix('/permissions')->name('permission.')->group(function() {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
        });
    });
});
