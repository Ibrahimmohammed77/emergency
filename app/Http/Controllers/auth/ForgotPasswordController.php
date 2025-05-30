<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    protected $broker;

    public function showLinkRequestForm($type)
    {
        return view('auth.passwords.email', ['type' => $type]);
    }

    public function sendResetLinkEmail(Request $request, $type)
    {
        $request->validate(['email' => 'required|email']);

        $this->broker = $type === 'user' ? 'users' : 'medical_centers';

        $response = Password::broker($this->broker)->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', trans($response))
            : back()->withErrors(['email' => trans($response)]);
    }
}