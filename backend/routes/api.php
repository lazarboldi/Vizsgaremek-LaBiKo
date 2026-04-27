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
use App\Http\Controllers\FavouritesController;


Route::post('/registration', [RegistrationController::class, 'registration'])
    ->name('registration');

Route::get('/users/{id}', [UserController::class, 'show'])
    ->whereNumber('id')
    ->name('users.show');

Route::post('/login', [AuthController::class, 'authenticate'])
    ->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/me', [UserController::class, 'me'])
        ->name('users.me');

    Route::get('/favourites', [FavouritesController::class, 'index'])
        ->name('favourites.index');
    Route::post('/favourites/{listing}', [FavouritesController::class, 'store'])
        ->whereNumber('listing')
        ->name('favourites.store');
    Route::delete('/favourites/{listing}', [FavouritesController::class, 'destroy'])
        ->whereNumber('listing')
        ->name('favourites.destroy');
});

Route::apiResource('listings', ListingsController::class);

Route::apiResource('cars', CarController::class);

Route::apiResource('carimages', CarimageController::class)->only(['store', 'destroy']);

Route::apiResource('interests', InterestController::class);

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/listings', [AdminListingController::class, 'index'])
        ->name('admin.listings.index');
    Route::patch('/listings/{listing}/approve', [AdminListingController::class, 'approve'])
        ->whereNumber('listing')
        ->name('admin.listings.approve');
    Route::delete('/listings/{listing}', [AdminListingController::class, 'destroy'])
        ->whereNumber('listing')
        ->name('admin.listings.destroy');
});