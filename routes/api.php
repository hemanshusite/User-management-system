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
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id?}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{id?}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id?}', [UserController::class, 'destroy'])->name('users.destroy');
});