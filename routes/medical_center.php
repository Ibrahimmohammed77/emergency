<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalCenter\MedicalCenterController;

Route::group([
    'prefix' => 'medical-center',
    'as' => 'medical-center.',
    'middleware' => ['web', 'auth:medical_center']
], function () {
    
    // Dashboard
    Route::get('/dashboard', [MedicalCenterController::class, 'dashboard'])
        ->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [MedicalCenterController::class, 'profile'])
        ->name('profile');
    Route::put('/profile', [MedicalCenterController::class, 'updateProfile'])
        ->name('profile.update');
    
    // Accident Routes
    Route::get('/accidents', [MedicalCenterController::class, 'accidents'])
        ->name('accidents.index');
        Route::get('/accidents', [MedicalCenterController::class, 'accidents'])
        ->name('accidents');
    Route::get('/accidents/{accident}', [MedicalCenterController::class, 'showAccident'])
        ->name('accidents.show');
    Route::put('/accidents/{accident}/status', [MedicalCenterController::class, 'updateAccidentStatus'])
        ->name('accidents.update-status');
    Route::get('/accidents/{accident}/response', [MedicalCenterController::class, 'showResponseForm'])
        ->name('accidents.response');
});
