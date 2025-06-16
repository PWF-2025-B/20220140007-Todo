<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TodoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// =======================
// PUBLIC ROUTES
// =======================

// Login (tanpa auth middleware)
Route::post('/login', [AuthController::class, 'login']);

// =======================
// PROTECTED ROUTES
// =======================
Route::middleware('auth:api')->group(function () {
    // Logout (butuh token JWT)
    Route::post('/logout', [AuthController::class, 'logout']);

    // Todo routes
    Route::post('/todos/search', [TodoController::class, 'search']);
    Route::apiResource('/todos', TodoController::class);

    // Cek user login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
