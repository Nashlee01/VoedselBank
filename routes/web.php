<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeveranciersController;
use App\Http\Controllers\VoorraadController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('voorraad')->name('voorraad.')->group(function () {
    Route::get('/', [VoorraadController::class, 'index'])->name('index');
    Route::get('/create', [VoorraadController::class, 'create'])->name('create');
    Route::post('/', [VoorraadController::class, 'store'])->name('store');
    Route::get('/{product}/edit', [VoorraadController::class, 'edit'])->name('edit');
    Route::put('/{product}', [VoorraadController::class, 'update'])->name('update');
    Route::delete('/{product}', [VoorraadController::class, 'destroy'])->name('destroy');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/leveranciers', [LeveranciersController::class, 'index']);
    Route::get('/leveranciers/create', [LeveranciersController::class, 'create']);
    Route::post('/leveranciers', [LeveranciersController::class, 'store']);
    Route::get('/leveranciers/{leverancier}/edit', [LeveranciersController::class, 'edit']);
    Route::put('/leveranciers/{leverancier}', [LeveranciersController::class, 'update']);
    Route::delete('/leveranciers/{leverancier}', [LeveranciersController::class, 'destroy']);
});
