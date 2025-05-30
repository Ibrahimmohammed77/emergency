<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AccidentController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\MedicalCenterController;

Route::prefix('admin')->group(function () {
    // Authentication Routes
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Protected Admin Routes
    Route::middleware(['auth:admin'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::put('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

        // Admin Management
        Route::prefix('admins')->name('admins.')->group(function() {
            Route::get('/', [AdminController::class, 'index'])->name('index');
            Route::get('/create', [AdminController::class, 'create'])->name('create');
            Route::post('/', [AdminController::class, 'store'])->name('store');
            Route::get('/{admin}', [AdminController::class, 'show'])->name('show');
            Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('edit');
            Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
            Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');
            Route::put('/{admin}/update-status', [AdminController::class, 'updateStatus'])->name('update-status');
        });

        // User Management
        Route::prefix('users')->name('admin.users.')->group(function() {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
            Route::put('/{user}/update-status', [UserController::class, 'updateStatus'])->name('update-status');
        });

        // Medical Centers Management
        Route::prefix('medical-centers')->name('admin.medical-centers.')->group(function() {
            Route::get('/', [MedicalCenterController::class, 'index'])->name('index');
            Route::get('/create', [MedicalCenterController::class, 'create'])->name('create');
            Route::post('/', [MedicalCenterController::class, 'store'])->name('store');
            Route::get('/{center}', [MedicalCenterController::class, 'show'])->name('show');
            Route::get('/{center}/edit', [MedicalCenterController::class, 'edit'])->name('edit');
            Route::put('/{center}', [MedicalCenterController::class, 'update'])->name('update');
            Route::delete('/{center}', [MedicalCenterController::class, 'destroy'])->name('destroy');
            Route::put('/{center}/update-status', [MedicalCenterController::class, 'updateStatus'])->name('update-status');
        });

        // Accident Management
        Route::prefix('accidents')->name('admin.accidents.')->group(function() {
            Route::get('/', [AccidentController::class, 'index'])->name('index');
            Route::get('/create', [AccidentController::class, 'create'])->name('create');
            Route::post('/', [AccidentController::class, 'store'])->name('store');
            Route::get('/{accident}', [AccidentController::class, 'show'])->name('show');
            Route::get('/{accident}/edit', [AccidentController::class, 'edit'])->name('edit');
            Route::put('/{accident}', [AccidentController::class, 'update'])->name('update');
            Route::delete('/{accident}', [AccidentController::class, 'destroy'])->name('destroy');
            Route::put('/{accident}/update-status', [AccidentController::class, 'updateStatus'])->name('update-status');
        });
    });
});

// Global logout route
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');