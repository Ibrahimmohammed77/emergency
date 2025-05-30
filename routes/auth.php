<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::middleware('guest.all')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Registration
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Password Reset
    Route::get('password/reset/{type}', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('password/email/{type}', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');
    
Route::get('password/reset/{type}/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
    
Route::post('password/reset/{type}', [ResetPasswordController::class, 'reset'])
    ->name('password.update');
});

// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware(['auth:user,medical_center'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    $guards = ['user', 'medical_center'];
    
    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            if (!hash_equals((string) $request->route('id'), (string) Auth::guard($guard)->user()->getKey())) {
                abort(403);
            }

            if (!hash_equals((string) $request->route('hash'), sha1(Auth::guard($guard)->user()->getEmailForVerification()))) {
                abort(403);
            }

            if (Auth::guard($guard)->user()->hasVerifiedEmail()) {
                return redirect()->route($guard=="medical_center"?'medical-center.dashboard':$guard.'.dashboard');
            }

            Auth::guard($guard)->user()->markEmailAsVerified();
            $request->session()->regenerate();

            return redirect()->route($guard==="medical_center"?'medical-center.dashboard':$guard.'.dashboard')->with('verified', true);
        }
    }

    abort(403);
})->middleware(['auth:user,medical_center', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $guards = ['user', 'medical_center'];
    
    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            if (Auth::guard($guard)->user()->hasVerifiedEmail()) {
                return redirect()->route($guard.'.dashboard');
            }

            Auth::guard($guard)->user()->sendEmailVerificationNotification();

            return back()->with('status', 'تم إرسال رابط التحقق!');
        }
    }

    abort(403);
})->middleware(['auth:user,medical_center', 'throttle:6,1'])->name('verification.send');

// Logout (general)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
