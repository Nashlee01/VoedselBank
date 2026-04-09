<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeveranciersController;
use App\Http\Controllers\KlantController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect oude klantenlink naar de nieuwe klantadministratie.
Route::redirect('/donate', '/klanten');

Route::middleware('auth')->group(function () {
    // Klant-CRUD routes voor admins.
    Route::get('/klanten', [KlantController::class, 'index']);
    Route::get('/klanten/create', [KlantController::class, 'create']);
    Route::post('/klanten', [KlantController::class, 'store']);
    Route::get('/klanten/{klant}/edit', [KlantController::class, 'edit']);
    Route::put('/klanten/{klant}', [KlantController::class, 'update']);
    Route::delete('/klanten/{klant}', [KlantController::class, 'destroy']);

    Route::get('/leveranciers', [LeveranciersController::class, 'index']);
    Route::get('/leveranciers/create', [LeveranciersController::class, 'create']);
    Route::post('/leveranciers', [LeveranciersController::class, 'store']);
    Route::get('/leveranciers/{leverancier}/edit', [LeveranciersController::class, 'edit']);
    Route::put('/leveranciers/{leverancier}', [LeveranciersController::class, 'update']);
    Route::delete('/leveranciers/{leverancier}', [LeveranciersController::class, 'destroy']);
});
