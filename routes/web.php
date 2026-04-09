<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KlantController;
use App\Http\Controllers\LeveranciersController;
use App\Http\Controllers\VoedselpakketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Openbare routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Beveiligde routes
|--------------------------------------------------------------------------
| Alleen ingelogde gebruikers mogen deze functionaliteiten gebruiken.
*/
Route::middleware('auth')->group(function () {
    Route::get('/leveranciers', [LeveranciersController::class, 'index'])->name('leveranciers.index');
    Route::get('/leveranciers/create', [LeveranciersController::class, 'create'])->name('leveranciers.create');
    Route::post('/leveranciers', [LeveranciersController::class, 'store'])->name('leveranciers.store');
    Route::get('/leveranciers/{leverancier}/edit', [LeveranciersController::class, 'edit'])->name('leveranciers.edit');
    Route::put('/leveranciers/{leverancier}', [LeveranciersController::class, 'update'])->name('leveranciers.update');
    Route::delete('/leveranciers/{leverancier}', [LeveranciersController::class, 'destroy'])->name('leveranciers.destroy');

    /*
    |--------------------------------------------------------------------------
    | Klanten CRUD
    |--------------------------------------------------------------------------
    | Resource routes maken automatisch index, create, store, edit, update en destroy.
    */
    Route::resource('klanten', KlantController::class)->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | Voedselpakket routes
    |--------------------------------------------------------------------------
    | Hiermee maken we een voedselpakket voor een specifieke klant.
    */
    Route::get('/voedselpakket/create/{klantId}', [VoedselpakketController::class, 'create'])
        ->name('voedselpakket.create');

    Route::post('/voedselpakket', [VoedselpakketController::class, 'store'])
        ->name('voedselpakket.store');
});