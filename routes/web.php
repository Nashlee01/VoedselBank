<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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
