<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[AuthController::class, 'register']);

Route::post('/login',[AuthController::class, 'login']);

// Protejemos las rutas 
Route::middleware('auth:sanctum')->group(function () {

    // products
    Route::apiResource('/products',ProductController::class);

    //logout
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Route::apiResource('products',ProductController::class)->middleware('auth:sanctum');

// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');