<?php

use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/login', [JWTAuthController::class, 'login']);
Route::post('/register', [JWTAuthController::class, 'register']);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::controller(JWTAuthController::class)->group(function () {
        Route::get('/user',  'getUser');
        Route::post('/logout', 'logout');
    });
    Route::controller(PermissionController::class)->group(function () {
        Route::get('/permissions', 'show');
        Route::post('/permissions/create',  'create');
        Route::post('/permissions/update/{id}', 'update');
        Route::post('/permissions/delete/{id}', 'delete');
    });
    
    Route::controller(RoleController::class)->group(function () {
        Route::get('/roles', 'show');
        Route::post('/roles/create',  'create');
        Route::post('/roles/update/{id}', 'update');
        Route::post('/roles/delete/{id}', 'delete');
    });
});
