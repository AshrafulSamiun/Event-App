<?php

///namespace Illuminate\Foundation\Auth;

use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Password;

class SendsUserNameResetEmailsggg extends Controller
{
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        echo 44444444;die;
        return view('auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    // public function sendResetLinkEmail(Request $request)
    // {
    //     $this->validateEmail($request);

    //     // We will send the password reset link to this user. Once we have attempted
    //     // to send the link, we will examine the response then see the message we
    //     // need to show to the user. Finally, we'll send out a proper response.
    //     $response = $this->broker()->sendResetLink(
    //         $request->only('email')
    //     );

    //     return $response == Password::RESET_LINK_SENT
    //                 ? $this->sendResetLinkResponse($response)
    //                 : $this->sendResetLinkFailedResponse($request, $response);
    // }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    // protected function validateEmail(Request $request)
    // {
    //     $this->validate($request, ['email' => 'required|email']);
    // }


}
