<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Notifications\TwoFactorCode;
use App\Models\Country as Country;
use App\Models\SendCode as SendCode;
use App\Models\loginInfo;
use App\Classes\ArrayFunction as ArrayFunction;
use Stevebauman\Location\Facades\Location;
use Mail;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**া
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function showRegistrationForm()
    {
        $ArrayFunction              =new ArrayFunction();
        //echo \Request::ip();die;

        // dd($_SERVER['HTTP_USER_AGENT']) ;

        $country=Country::where('status_active',1)->get();

        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
            $country_code_arr[$value->id]['code']=$value->country_code;
            $country_code_arr[$value->id]['country_name']=$value->country_name;
            $country_code_arr[$value->id]['image']=$value->image;
        }
        $data['country_arr']        =$country_arr;
        $data['country_code_arr']   =$country_code_arr;
        $data['service_plan_arr']   =$ArrayFunction->service_plan_arr;
        return view('auth.register',$data);
    }



    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required_with:password|same:password|min:8',
            'captcha' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //echo 444;die;
        
        $user_project=Project::create([
            'project_name' => $data['company_name'],
            'project_status' => 105,
        ]);


        $userRaw=User::create([
            'name'          => $data['name'],
            'user_name'     => $data['user_name'],
            'email'         => $data['email'],
            'project_id'    => $user_project->id,
            'user_type'     => $data['user_type'],
            'project_type'  => 105,
            'status_active' => 0,
            'pin_code'      => rand(11111, 99999),
            'password'      => bcrypt($data['password']),
        ]);
       return $userRaw;
       //dd($userRaw);
        $user=$userRaw->toArray();
        $userRaw->saveLoginInfo();
        // Mail::send('emails.activation',$user, function ($message) use ($user){
        //     $message->to($user['email']);
        //     $message->subject('Activation Code');

        //  });

        $userRaw->generateTwoFactorCode();
        $userRaw->notify(new twoFactorCode());
        return redirect("/verify");
        //return redirect()->to('/')->with('success',"We send a activation code to your email, Please check");
       // Mail::to($data['email'])->send(new WelcomeMail());
        
    }


    protected function register_step_tow(Request $request)
    {
        
        request()->validate([
            'corporation_name'      => 'required',
            'country'               => 'required',
            'provience'             => 'required',
            'city'                  => 'required',
            'street'                => 'required',
            'zip_code'              => 'required',
            'office_phone'          => 'required',
            'mobile'                => 'required',

            'email'                 => 'required',
            'fax'                   => 'required',
            'website'               => 'required',
            
        ]);


        $userRaw=User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'project_id'    => $user_project->id,
            'user_type'     => $data['user_type'],
            'project_type'  => 105,
            'status_active' => 0,
            'pin_code'      => rand(11111, 99999),
            'password'      => bcrypt($data['password']),
        ]);

        return $userRaw;
    }

    public function userActivation($user_id)
    {
        $user=User::find($user_id);
        if($user->is_activated==1)
        {
            return redirect()->to('login')->with('success',"Email already varified.");
        }
        
        $user->update(['is_activated'=>1]);
        return redirect()->to('login')->with('success',"Email varified Successfully.Please Login For active your Account.");
    }

    public function refresh_captcha()
    {
        return response()->json(['captcha'=>captcha_img()]);
    }

}
