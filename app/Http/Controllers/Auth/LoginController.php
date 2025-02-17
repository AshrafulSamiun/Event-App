<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Notifications\TwoFactorCode;
use Auth;
use Illuminate\Http\Request;
use App\Models\UserCrediential;
use Browser;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/Dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //return "1"+2*"007";die;
        $this->middleware('guest')->except('logout');
    }

     public function logout(Request $request) {
      Auth::logout();
      $request->session()->invalidate();
      return redirect('/login');
    }


    protected function authenticated(Request $request,$user)
    {
      
        if($request->pin_code==$user->pin_code)
        { 
            // $brower=Browser::userAgent();

            // $UserCredientialSql=UserCrediential::where('user_id',$user->id)->get();
            // if(!empty($UserCredientialSql))
            // {
            //     foreach($UserCredientialSql as $value)
            //     {


            //         if($value->user_crediential==$brower)
            //         {
            //             return redirect('/Dashboard');die;
            //         }

            //     }
            // }
            
            $user->generateTwoFactorCode();
            $user->notify(new twoFactorCode());
            return redirect("/verify"); 
        }
        else
        {
             //dd($user->pin_code);die;
            Auth::logout();
            $request->session()->invalidate();
            return redirect('/login')->withErrors(['pin_code' => 'Pin Code which you enter does not match']);

        }
        
    }
}
