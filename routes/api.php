<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    
    // Users routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/create', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/view/{id?}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/update/{id?}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{id?}', [UserController::class, 'destroy'])->name('users.destroy');
});
