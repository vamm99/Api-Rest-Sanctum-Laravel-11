<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RFIDTagController;
use App\Http\Controllers\PointController;
use Illuminate\Support\Facades\Route;

//juntar todas las rutas con un solo prefijo
Route::prefix('users')->group(function () {
    Route::post('/registerAdmin', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/tag', [RFIDTagController::class, 'store']);
    Route::post('/puntos', [PointController::class, 'update']);
    Route::get('/puntos', [PointController::class, 'index']);
    Route::get('/prueba', [PointController::class, 'prueba']);
    // Protejemos las rutas 
    Route::middleware('auth:sanctum')->group(function () {
        // CRUD Básico
        Route::get('/fetchUser', [CustomerController::class, 'index']);
        Route::post('/register', [CustomerController::class, 'store']);
        Route::get('/show/{id}', [CustomerController::class, 'show']);
        Route::put('/update/{cc}', [CustomerController::class, 'update']);
        Route::delete('/delete/{id}', [CustomerController::class, 'destroy']);

        // Métodos de Filtrado
        Route::get('/filterByNombre', [CustomerController::class, 'filterByNombre']);
        Route::get('/filterByCC', [CustomerController::class, 'filterByCC']);
        Route::get('/filterByUID', [CustomerController::class, 'filterByUID']);

        // Actualizar saldo acumulado
        Route::put('/{id}/saldo', [CustomerController::class, 'updateSaldoAcumulado']);
        Route::get('/users/search', [CustomerController::class, 'searchByUIDOrCC']);



        //logout
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
