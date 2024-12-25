<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // Redirect based on user role
                if ($user->hasRole('admin')) {
                    return redirect('/admin/dashboard');
                } elseif ($user->hasRole('foto')) {
                    return redirect('/fotografer/dashboard');
                } elseif ($user->hasRole('user')) {
                    return redirect('/pelanggan/foto');
                }

                // Default redirect if no role matches
                return redirect('/pelanggan/foto');
            }
        }

        return $next($request);
    }
}
