<?php

namespace App\Http\Middleware;

use Closure;

class IsEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(auth()->user()->user_type==8 && auth()->user()->authenticated_by_admin==0)
        {

            return redirect('/userIncubate');
        }
        else {
            return
             $next($request);
        } 
        
    }
}
