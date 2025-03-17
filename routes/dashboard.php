<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;

Route::get('/dashboard/index', [DashboardController::class,'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::resource('dashboard/categories', CategoriesController::class)
    ->middleware(['auth']);

// Route::prefix('admin')->group([
//     ->middleware(['auth', 'verified'])
// ],
// function () {
//     Route::resource('dashboard/categories', CategoriesController::class)
//     Route::resource('dashboard/products', CategoriesController::class)

// });
