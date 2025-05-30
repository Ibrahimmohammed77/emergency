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
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    // Accident Routes
    Route::get('/accidents', [AccidentController::class, 'index'])->name('admin.accidents.index');
    Route::get('/accidents/create', [AccidentController::class, 'create'])->name('admin.accidents.create');
    Route::post('/accidents', [AccidentController::class, 'store'])->name('admin.accidents.store');
    Route::get('/accidents/{accident}', [AccidentController::class, 'show'])->name('admin.accidents.show');
    Route::patch('/accidents/{accident}/status', [AccidentController::class, 'updateStatus'])->name('admin.accidents.update-status');
    Route::get('/accidents/{accident}/status', [AccidentController::class, 'updateStatus'])->name('admin.accidents.edit');
});
// Authentication Routes
// Route::controller(AuthController::class)->group(function () {
//     Route::get('/login', 'showLoginForm')->name('login');
//     Route::post('/login', 'login');
//     Route::get('/register', 'showRegistrationForm')->name('register');
//     Route::post('/register', 'register');
//     Route::post('/logout', 'logout')->name('logout');
// });


// Authentication Routes
Route::middleware('guest')->group(function () {
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
// Route::get('/email/verify', function () {
//     return view('auth.verify');
// })->middleware(['auth:user,medical_center'])->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (Request $request) {
//     $guards = ['user', 'medical_center'];
    
//     foreach ($guards as $guard) {
//         if (Auth::guard($guard)->check()) {
//             if (!hash_equals((string) $request->route('id'), (string) Auth::guard($guard)->user()->getKey())) {
//                 abort(403);
//             }

//             if (!hash_equals((string) $request->route('hash'), sha1(Auth::guard($guard)->user()->getEmailForVerification()))) {
//                 abort(403);
//             }

//             if (Auth::guard($guard)->user()->hasVerifiedEmail()) {
//                 return redirect()->route($guard.'.dashboard');
//             }

//             Auth::guard($guard)->user()->markEmailAsVerified();
//             $request->session()->regenerate();

//             return redirect()->route($guard.'.dashboard')->with('verified', true);
//         }
//     }

//     abort(403);
// })->middleware(['auth:user,medical_center', 'signed'])->name('verification.verify');

// Route::post('/email/verification-notification', function (Request $request) {
//     $guards = ['user', 'medical_center'];
    
//     foreach ($guards as $guard) {
//         if (Auth::guard($guard)->check()) {
//             if (Auth::guard($guard)->user()->hasVerifiedEmail()) {
//                 return redirect()->route($guard.'.dashboard');
//             }

//             Auth::guard($guard)->user()->sendEmailVerificationNotification();

//             return back()->with('status', 'تم إرسال رابط التحقق!');
//         }
//     }

//     abort(403);
// })->middleware(['auth:user,medical_center', 'throttle:6,1'])->name('verification.send');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Admin Management
    Route::get('/admins', [AdminController::class, 'index'])->name('admin.admins.index');
    Route::get('/admins/create', [AdminController::class, 'create'])->name('admin.admins.create');
    Route::post('/admins', [AdminController::class, 'store'])->name('admin.admins.store');
    
    // Medical Center Management
    Route::get('/medical-centers', [AdminController::class, 'manageMedicalCenters'])->name('admin.medical-centers.index');
    Route::put('/medical-centers/{center}/status', [AdminController::class, 'updateMedicalCenterStatus'])->name('admin.medical-centers.update-status');
    
    // User Management
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users.index');
    Route::put('/users/{user}/status', [AdminController::class, 'updateUserStatus'])->name('admin.users.update-status');
    
    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
});

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
});


Route::prefix('user')->middleware(['auth:user'])->group(function () {
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

Route::prefix('user')->middleware(['auth:user'])->group(function () {
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

Route::prefix('admin')->group(function() {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
       Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});
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



