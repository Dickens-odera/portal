<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        /*
        if (Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
        */
        switch($guard)
        {
            case 'admin':
                if(Auth::guard($guard)->check())
                {
                    return redirect()->route('admin.dashboard');
                }
            break;
            case 'student':
                if(Auth::guard($guard)->check())
                {
                    return redirect()->route('student.dashboard');
                }
            break;
            case 'dean':
                if(Auth::guard($guard)->check())
                {
                    return redirect()->route('dean.dashboard');
                }
            break;
            case 'cod':
                if(Auth::guard($guard)->check())
                {
                    return redirect()->route('cod.dashboard');
                }
            break;
            case 'registrar':
                if(Auth::guard($guard)->check())
                {
                    return redirect()->route('registrar.dashboard');
                }
            break;
            default:
            if(Auth::guard($guard)->check())
            {
                return redirect()->route('home');
            }
            break;
        }
        return $next($request);
    }
}
