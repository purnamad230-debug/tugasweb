<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;

Route::get('/menus', [MenuController::class, 'index']);
Route::post('/menus', [MenuController::class, 'store']);
Route::put('/menus/{id}', [MenuController::class, 'update']);
Route::delete('/menus/{id}', [MenuController::class, 'destroy']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('menus', MenuController::class);
});    

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();


});

// Route ini bisa diakses tanpa login untuk mendapatkan token
Route::post('/login', [AuthController::class, 'login']);

// Semua route di dalam grup ini wajib mengirimkan "Bearer Token" di Header
Route::middleware('auth:sanctum')->group(function () {
    
    // Route untuk Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route CRUD Menu (Index, Store, Update, Show)
    // Khusus untuk Delete, pengecekan Role Admin dilakukan di dalam Controller
    Route::apiResource('menus', MenuController::class);
});