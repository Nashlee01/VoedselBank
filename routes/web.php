<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeveranciersController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/leveranciers', [LeveranciersController::class, 'index']);
