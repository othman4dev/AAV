<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CRUD\UserController;
use App\Http\Controllers\VoitureController;
use App\Http\Middleware\Permission;
use Illuminate\Support\Facades\Route;

Route::post('/Login', [AuthController::class, 'Login']);
Route::post('/Register', [AuthController::class, 'Register']);
Route::get('/Logout', [AuthController::class, 'logout']);
Route::get('/All-Voitures', [VoitureController::class, 'index']);
Route::post('/Estimation-Voitures', [VoitureController::class, 'estimation']);

Route::resources([
    '/User' => UserController::class,
]);
