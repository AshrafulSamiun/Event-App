<?php

namespace App\Http\Middleware;
use Carbon\Carbon;
use Closure;

class TwoFactor
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
        $user = auth()->user();

        $now = Carbon::now();       
        $endDate = Carbon::parse($user->two_factor_expire_at);

        //dd($endDate);die;
        if(auth()->check() && $user->two_factor_code)
        {
            if($endDate->lt($now))
            {
                $user->resetTwoFactorCode();
                auth()->logout();

                return redirect()->route('login')->withMessage('The two factor code has expired. Please login again.');
            }

            if(!$request->is('verify*'))
            {
                return redirect()->route('verify.index');
            }
        }

        return $next($request);
    }
}
