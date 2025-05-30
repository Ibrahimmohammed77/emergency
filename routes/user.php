<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\VehicleController;
use App\Http\Controllers\User\EmergencyRequestController;

Route::prefix('user')->middleware(['auth:user'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    
    // Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    
    // Vehicles
    Route::get('/vehicles', [UserController::class, 'vehicles'])->name('user.vehicles.index');
    Route::get('/vehicles/create', [UserController::class, 'createVehicle'])->name('user.vehicles.create');
    Route::post('/vehicles', [UserController::class, 'storeVehicle'])->name('user.vehicles.store');
    Route::get('/vehicles/{vehicle}/edit', [UserController::class, 'editVehicle'])->name('user.vehicles.edit');
    Route::put('/vehicles/{vehicle}', [UserController::class, 'updateVehicle'])->name('user.vehicles.update');
    
    // Accidents
    Route::get('/accidents', [UserController::class, 'accidents'])->name('user.accidents.index');
    Route::get('/accidents/{accident}', [UserController::class, 'showAccident'])->name('user.accidents.show');
    
    // Emergency Requests
    Route::get('/emergency-request', [UserController::class, 'showEmergencyRequestForm'])->name('user.emergency-request.create');
    Route::post('/emergency-request', [UserController::class, 'submitEmergencyRequest'])->name('user.emergency-request.store');
    Route::get('/emergency-requests', [UserController::class, 'emergencyRequests'])->name('user.emergency-requests.index');

    // Vehicle Routes
    Route::get('/vehicles', [VehicleController::class, 'index'])->name('user.vehicles.index');
    Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('user.vehicles.create');
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('user.vehicles.store');
    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('user.vehicles.show');
    Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('user.vehicles.edit');
    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('user.vehicles.update');
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('user.vehicles.destroy');
    
    // API Route for device linking
    Route::post('/vehicles/link-device', [VehicleController::class, 'linkDevice'])->name('user.vehicles.link-device');

    // Emergency Requests
    Route::get('/emergency-request', [EmergencyRequestController::class, 'create'])
        ->name('user.emergency-request.create');
    Route::post('/emergency-request', [EmergencyRequestController::class, 'store'])
        ->name('user.emergency-request.store');
    Route::get('/emergency-requests', [EmergencyRequestController::class, 'index'])
        ->name('user.emergency-requests.index');
    Route::get('/emergency-requests/{emergencyRequest}', [EmergencyRequestController::class, 'show'])
        ->name('user.emergency-requests.show');
    Route::post('/emergency-requests/{emergencyRequest}/cancel', [EmergencyRequestController::class, 'cancel'])
        ->name('user.emergency-requests.cancel');
});
