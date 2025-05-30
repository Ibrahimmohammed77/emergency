<?php

use App\Http\Controllers\Admin\AccidentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\MedicalCenter\MedicalCenterController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\User\EmergencyRequestController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\VehicleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});











// SMS Routes
Route::prefix('sms')->group(function () {
    // Send emergency notification (typically called from AccidentController)
    Route::post('/notify/{accident}', [SMSController::class, 'sendEmergencyNotification'])
        ->middleware('auth:admin')
        ->name('sms.emergency');
    
    // Delivery report webhook (called by SMS provider)
    Route::post('/delivery-report', [SMSController::class, 'deliveryReport']);
    
    // Admin SMS management
    Route::middleware('auth:admin')->group(function () {
        Route::get('/notifications', [SMSController::class, 'index'])->name('sms.index');
        Route::get('/notifications/{smsNotification}', [SMSController::class, 'show'])->name('sms.show');
        Route::post('/notifications/{smsNotification}/retry', [SMSController::class, 'retry'])->name('sms.retry');
    });
});

require_once "admin.php";
require_once "user.php";
require_once "medical_center.php";
require_once "auth.php";




