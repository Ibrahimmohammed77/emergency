<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $type, $token = null)
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email,
            'type' => $type
        ]);
    }

    public function reset(Request $request, $type)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // التصحيح: استخدام الاسم الصحيح لل broker
        $broker = $type === 'medical_center' ? 'medical_centers' : 'users';

        $response = Password::broker($broker)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($type) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();

                $guard = $type === 'medical_center' ? 'medical_center' : 'user';
                Auth::guard($guard)->login($user);
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            $redirectRoute = $type === 'medical_center'
                ? route('medical_center.dashboard')  // تصحيح اسم الراوت
                : route('user.dashboard');

            return redirect($redirectRoute)->with('status', trans($response));
        }

        return back()->withErrors(['email' => trans($response)]);
    }
}
