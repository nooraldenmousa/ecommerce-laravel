<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }

        $userRole = session('user.role');

        if ($role === 'manager' && $userRole !== 'manager') {
            abort(403, 'غير مصرح لك بالدخول ❌');
        }

        return $next($request);
    }
}
