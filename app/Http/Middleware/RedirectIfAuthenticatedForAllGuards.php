<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedForAllGuards
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // تحقق من جميع الحراس التي تستخدمها
        $guards = ['user', 'medical_center'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // أعد التوجيه حسب نوع المستخدم
                return redirect()->route($guard === 'medical_center' ? 'medical-center.dashboard' : 'user.dashboard');
            }
        }

        return $next($request);
    }
}
