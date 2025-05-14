<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $user = Auth::user();

        if ($user && $user->role !== 'owner' && $request->is('register')) {
            return redirect('/home');
        }

        return $next($request);
    }
}