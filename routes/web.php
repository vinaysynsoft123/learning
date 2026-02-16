<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PackageCalculatorController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\HotelCategoryController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelRoomTypeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Admin\PackageCalculationController;
use App\Http\Controllers\Ajax\CalculatorAjaxController;
use App\Http\Controllers\TermsConditionController;

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
    Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [AuthController::class, 'update'])->name('users.update');
    Route::get('/user/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/user/save', [UsersController::class, 'store'])->name('users.save');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

    Route::patch('/admin/profile', [SettingsController::class, 'update_profile'])->name('admin.profile.update');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/admin/profile', [SettingsController::class, 'edit'])->name('admin.profile');
    Route::resource('destinations', DestinationController::class)->except(['show']);
        
    Route::get('/packages/international', [PackageController::class, 'international'])->name('packages.international');
    Route::get('/packages/domestic', [PackageController::class, 'domestic'])->name('packages.domestic');

    Route::resource('packages', PackageController::class);


    Route::resource('themes', ThemeController::class)->except(['show']);
    Route::resource('hotel-categories', HotelCategoryController::class)->except(['show']);
    Route::resource('hotels', HotelController::class);
    
    Route::resource('vehicles', VehicleController::class)->except(['show']);
    Route::resource('terms-conditions', TermsConditionController::class)->except(['show']);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('/package-calculations', [PackageCalculationController::class,'index'])->name('admin.package.calculations');
    Route::get('/package-calculations/{id}', [ PackageCalculationController::class,'show'])->name('admin.package.calculations.show');

    Route::get('/hotel-rooms/{hotel}', [HotelRoomTypeController::class, 'index'])->name('rooms.index');
    Route::get('hotel/{hotel}/rooms/create', [HotelRoomTypeController::class, 'create'])->name('hotel.rooms.create');
    Route::post('hotel/{hotel}/rooms/store', [HotelRoomTypeController::class, 'store'])->name('hotel.rooms.store');

});

    Route::middleware(['auth','agent'])->group(function() {
        Route::get('/agent/dashboard', [AgentController::class, 'dashboard'])->name('agent.dashboard');
        Route::post('/agent/logout', [AgentController::class, 'logout'])->name('agent.logout');
        Route::get('/calculation/report', [AgentController::class, 'calculation_report'])->name('calculation.report');
        Route::get('/agent/company-profile', [AgentController::class, 'company_profile'])->name('agent.company.profile');
        Route::post('/agent/company-profile/update', [AgentController::class, 'update'])->name('agent.company.profile.update');
        Route::get('/agent/profile', [AgentController::class, 'profile'])->name('agent.profile');
        Route::get('/agent/my-target', [AgentController::class, 'my_target'])->name('agent.target');
        Route::get('/calculation/report/{id}', [AgentController::class, 'show'])->name('calculation.show');

    });

Route::prefix('ajax')->group(function () {
    Route::get('themes/{destination}', [CalculatorAjaxController::class, 'themes']);
    Route::get('packages/{theme}', [CalculatorAjaxController::class, 'packages']);
});


Route::get('/', [AuthController::class, 'agent_login'])
    ->name('apgent.login');

Route::get('/package-calculator', [PackageCalculatorController::class, 'index'])
    ->name('package.calculator');


Route::post('/calculator/calculate', [PackageCalculatorController::class, 'calculate'])
    ->name('calculator.calculate');

Route::get('/calculator/pdf/{token}', [PackageCalculatorController::class, 'viewPdf'])
    ->name('calculator.pdf'); //