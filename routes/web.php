<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PackageCalculatorController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\HotelCategoryController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ReportController;


Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');
    Route::get('/users',[AuthController::class, 'user_list'])->name('users');
    Route::get('/users/{user}/edit', [AuthController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AuthController::class, 'update'])->name('users.update');

    Route::get('/admin/profile', [AuthController::class, 'edit'])->name('admin.profile');
    Route::patch('/admin/profile', [SettingsController::class, 'update_profile'])->name('admin.profile.update');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::resource('destinations', DestinationController::class)
        ->except(['show']);
        
    Route::resource('packages', PackageController::class);

    Route::resource('themes', ThemeController::class)
        ->except(['show']);

    Route::resource('hotel-categories', HotelCategoryController::class)
        ->except(['show']);
        Route::resource('vehicles', VehicleController::class)
        ->except(['show']);

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

});





// Calculator page
Route::get('/package-calculator', [PackageCalculatorController::class, 'index'])
    ->name('package.calculator');

// Calculate price
Route::post('/calculator/calculate', [PackageCalculatorController::class, 'calculate'])
    ->name('calculator.calculate');

// 🔥 View PDF (new tab + download)
Route::get('/calculator/pdf/{token}', [PackageCalculatorController::class, 'viewPdf'])
    ->name('calculator.pdf');