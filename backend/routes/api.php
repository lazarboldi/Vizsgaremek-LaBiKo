<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;


Route::post('/registration', [RegistrationController::class, 'registration'])
    ->name('registration');

Route::get('/users/{id}', [UserController::class, 'show'])
    ->whereNumber('id')
    ->name('users.show');

Route::post('/login', [AuthController::class, 'authenticate'])
    ->name('login');