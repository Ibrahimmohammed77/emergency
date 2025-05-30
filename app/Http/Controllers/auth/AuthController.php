<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MedicalCenter;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login', [
            'userTypes' => [
                'user' => 'مستخدم عادي',
                'medical_center' => 'مركز صحي'
            ]
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'user_type' => 'required|in:user,medical_center',
        ]);

        $credentials = $request->only('email', 'password');
        $guard = $request->user_type;

        if (Auth::guard($guard)->attempt($credentials, $request->filled('remember'))) {
            $user = Auth::guard($guard)->user();
            
            if (!$user->hasVerifiedEmail()) {
                Auth::guard($guard)->logout();
                return back()->withErrors([
                    'email' => 'يجب عليك التحقق من بريدك الإلكتروني أولاً.',
                ])->onlyInput('email');
            }

            if ($guard === 'medical_center' && $user->status !== 'active') {
                Auth::guard($guard)->logout();
                return back()->withErrors([
                    'email' => 'حسابك قيد المراجعة من قبل المسؤول.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return match($guard) {
                'medical_center' => redirect()->intended('/medical-center/dashboard'),
                default => redirect()->intended('/user/dashboard'),
            };
        }

        return back()->withErrors([
            'email' => 'بيانات الاعتماد المقدمة لا تتطابق مع سجلاتنا.',
        ])->onlyInput('email');
    }

    public function showRegistrationForm()
    {
        return view('auth.register', [
            'registerTypes' => [
                'user' => 'تسجيل كمستخدم',
                'medical_center' => 'تسجيل مركز صحي'
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|unique:medical_centers',
            'phone' => 'required|string|max:20|unique:users|unique:medical_centers',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'user_type' => 'required|in:user,medical_center',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ];

        switch ($request->user_type) {
            case 'user':
                $user = User::create($userData);
                event(new Registered($user));
                Auth::guard('user')->login($user);
                return redirect()->route('verification.notice')->with('status', 'تم إرسال رابط التحقق إلى بريدك الإلكتروني.');

            case 'medical_center':
                $request->validate([
                    'address' => 'required|string|max:500',
                    'latitude' => 'required|numeric',
                    'longitude' => 'required|numeric',
                    'specialization' => 'required|string|max:255',
                ]);

                $medicalCenter = MedicalCenter::create(array_merge($userData, [
                    'address' => $request->address,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'specialization' => $request->specialization,
                    'status' => 'inactive',
                ]));

                event(new Registered($medicalCenter));
                Auth::guard('medical_center')->login($medicalCenter);
                return redirect()->route('verification.notice')
                    ->with('status', 'تم إرسال رابط التحقق إلى بريدك الإلكتروني. يجب أيضًا انتظار موافقة المسؤول.');
        }

        return redirect('/');
    }

    public function logout(Request $request)
    {
        $guards = array_keys(config('auth.guards'));

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}