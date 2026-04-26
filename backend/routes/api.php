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
use App\Http\Controllers\AdminListingController;


Route::post('/registration', [RegistrationController::class, 'registration'])
    ->name('registration');

Route::get('/users/{id}', [UserController::class, 'show'])
    ->whereNumber('id')
    ->name('users.show');

Route::post('/login', [AuthController::class, 'authenticate'])
    ->name('login');

Route::apiResource('listings', ListingsController::class);

Route::apiResource('cars', CarController::class);

Route::apiResource('carimages', CarimageController::class)->only(['store', 'destroy']);

Route::apiResource('interests', InterestController::class);

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/listings', [AdminListingController::class, 'index'])
        ->name('admin.listings.index');
    Route::delete('/listings/{listing}', [AdminListingController::class, 'destroy'])
        ->whereNumber('listing')
        ->name('admin.listings.destroy');
});