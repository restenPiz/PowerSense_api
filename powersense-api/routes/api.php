<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecargaController;
use App\Http\Controllers\Api\ContadorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Dashboard
    Route::get('/dashboard', [ContadorController::class, 'dashboard']);
    Route::get('/consumo/semanal', [ContadorController::class, 'consumoSemanal']);

    // Recargas
    Route::post('/recarga', [RecargaController::class, 'store']);
    Route::get('/recargas', [RecargaController::class, 'index']);
    Route::get('/recarga/{id}', [RecargaController::class, 'show']);
});
