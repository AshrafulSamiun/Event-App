<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Stevebauman\Location\Facades\Location;
use App\Models\LoginInfo;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'image_id','email', 'user_name','password','pin_code','two_factor_code','two_factor_expire_at','project_type','user_type','status_active','authenticated_by_admin','company_id',
        'project_id','user_sequence','account_holder_id',
    ];


    protected $dates = ['two_factor_expire_at'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function image()
    {
        return $this->belongsTo('App\Models\FileUpload', 'image_id', 'id');
    }
    public function generateTwoFactorCode()
    {

        $this->timestamps=false;
        $this->two_factor_code=rand(100000,999999);
        $this->two_factor_expire_at= Carbon::now()->addMinutes(10)->toDateTimeString();
        //dd($this->two_factor_expire_at);die;
        $this->save();
    }
    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expire_at = null;
        $this->save();
    }

    public function saveLoginInfo()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

       if ($position = Location::get()) {
            // Successfully retrieved position.
            echo $position->countryName;
        } else {
            $position = Location::get($ipaddress);
        }
       // dd($position);die;
        if(!empty($position)){
            $ip=$position->ip;
            $country=$position->countryName;
            $countryCode=$position->countryCode;
            $regionCode=$position->regionCode;
            $regionName=$position->regionName;
            $cityName=$position->cityName;
            $zipCode=$position->zipCode;
            $timezone=$position->timezone;
           
           $userLoginInfo=loginInfo::create([
                'project_id'        => $this->project_id,
                'user_id'           => $this->id,
                'ip_address'        => $ip,
                'device_name'       => $_SERVER['HTTP_USER_AGENT'],
                'country_name'      => $country,
                'country_code'      => $countryCode,
                'city_name'         => $cityName,
                'zip_code'          => $zipCode,
                'region_code'       => $regionCode,
                'region_name'       => $regionName,
                'device_name'       => $_SERVER['HTTP_USER_AGENT'],
                'time_zone'         => $timezone,
                
            ]);
        }
    }
}
