<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;


// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/projects', [ProjectController::class, 'index']);

//Auth
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::get('/reset-password/{token}', function ($token) {
    return response()->json(['token' => $token], 200);
})->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Protected Routes (Require Authentication)
Route::middleware('auth:sanctum')->group(function () {
    //Users
    Route::apiResource('users', UserController::class);
    //Projects
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    Route::patch('/projects/{id}', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
});
