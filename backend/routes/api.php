<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarimageController;
use App\Http\Controllers\ListingsController;
use App\Http\Controllers\InterestController;


Route::post('/registration', [RegistrationController::class, 'registration'])
    ->name('registration');

Route::get('/users/{id}', [UserController::class, 'show'])
    ->whereNumber('id')
    ->name('users.show');

Route::post('/login', [AuthController::class, 'authenticate'])
    ->name('login');

Route::apiResource('listings', ListingsController::class);

Route::apiResource('cars', CarController::class);

Route::apiResource('interests', InterestController::class);