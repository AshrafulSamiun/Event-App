<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Country as Country;
use App\Models\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

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
    protected $redirectTo = '/Dashboard';

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

        //echo \Request::ip();die;

            // $ipaddress = '';
            // if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            //     $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            // } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //     $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            // } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            //     $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            // } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            //     $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            // } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            //     $ipaddress = $_SERVER['HTTP_FORWARDED'];
            // } else if (isset($_SERVER['REMOTE_ADDR'])) {
            //     $ipaddress = $_SERVER['REMOTE_ADDR'];
            // } else {
            //     $ipaddress = 'UNKNOWN';
            // }

            // return $ipaddress;



        $country=Country::where('status_active',1)->get();

        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
            $country_code_arr[$value->id]['code']=$value->country_code;
            $country_code_arr[$value->id]['country_name']=$value->country_name;
            $country_code_arr[$value->id]['image']=$value->image;
        }
        $data['country_arr']        =$country_arr;
        $data['country_code_arr']   =$country_code_arr;
        return view('auth.register',$data);
    }



    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required_with:password|same:password|min:8'
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
       
       $user_project=Project::create([
            'project_name' => 'Temporary Project',
            'project_status' => 100,
        ]);


         User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'project_id'    => $user_project->id,
            'user_type'     => $data['user_type'],
            'project_type'  => 100,
            'status_active' => 1,
            'pin_code'      => rand(11111, 99999),
            'country'       => $data['country'],
            'mobile'        => $data['mobile'],
            'password'      => bcrypt($data['password']),
            'status_active' =>0,
        ]);

        Mail::to($data['email'])->send(new WelcomeMail());
        return redirect('/');
    }
}
