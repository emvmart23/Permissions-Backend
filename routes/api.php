<?php

use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/login', [JWTAuthController::class, 'login']);
Route::post('/register', [JWTAuthController::class, 'register']);

Route::middleware(['middleware' => ['auth']])->group(function () {
    Route::get('user', [JWTAuthController::class, 'getUser']);
    Route::post('logout', [JWTAuthController::class, 'logout']);
    Route::post('/create', [RoleController::class, 'create']);
});
