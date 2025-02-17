<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendUserName;
use App\Notifications\SendPinCode;



class SendsUserNameController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.username.email');
    }

    public function showPinRequestForm()
    {
        return view('auth.pincode.email');
    }


    public function sendUsernameEmail(Request $request)
    {
    	request()->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email',$request->input('email'))->first();
        $user->notify(new SendUserName());
        return redirect()->to('login')->withMessage('User Name has been sent to Your Email.');
       
    }

    public function sendPinCodeEmail(Request $request)
    {
    	request()->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email',$request->input('email'))->first();
        $user->notify(new SendPinCode());
        return redirect()->to('login')->withMessage('User Name has been sent to Your Email.');
       
    }
}
