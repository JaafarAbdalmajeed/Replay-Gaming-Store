<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;

Route::resource('dashboard/categories', CategoriesController::class);
Route::get('/dashboard/index', [DashboardController::class,'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
