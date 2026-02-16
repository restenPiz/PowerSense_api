<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecargaController;
use App\Http\Controllers\ContadorController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //*Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //*Recarga Routes
    Route::get('/recargas', [RecargaController::class, 'index'])->name('recargas');

    //*Contador Routes
    Route::get('/contadores', [ContadorController::class, 'index'])->name('contadores');
});

require __DIR__ . '/auth.php';
