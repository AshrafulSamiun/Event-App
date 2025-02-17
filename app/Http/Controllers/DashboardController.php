<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module as Module;
use App\Models\Menu as Menu;
use App\Models\servicePlan as servicePlan;
use Illuminate\Support\Facades\DB;
use App\Models\Country as Country;
use App\Models\Project as Project;
use App\Models\userCompany as userCompany;
use App\Models\provience as Provience;
use App\Models\PropertyManagementType as PropertyManagementType;
use App\Models\UserServicePlanDetails as UserServicePlanDetails;
use App\Models\UserServicePlan as UserServicePlan;
use App\Models\buildingInfo as BuildingInfo;
use App\Models\FileUpload as FileUpload;
use App\Models\AccountContactPerson as AccountContactPerson;
use App\Classes\ArrayFunction as ArrayFunction;

//use Browser;


class DashboardController extends Controller
{
    public function __construct( Module $module,Menu $menu)
    {
        //$this->middleware('auth');
        $this->module=$module->orderBy('modSlNo')->get();
        $this->menu=$menu->all();
        $this->middleware('auth');
    }

    public function index()
    {
        $user=auth()->user();
        
        $project_id                 = $user->project_id;
        $project_info               = Project::find($project_id);

        $project_type               = $project_info->project_status;
        $property_code              = $project_info->property_code;
        $data['project_name']       =$project_info->project_name;
        $ArrayFunction              =new ArrayFunction();
        $user_type_arr              =$ArrayFunction->user_type_arr;
        $user_image_info=FileUpload::where('id',$user->image_id)->get();
       // dd($user_image_info);die;
        $user_image="";
        if($user_image_info)
           // $user_image=$user_image_info[0]->image_name;
        $country_code_details_arr=array();
        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
            $country_code_arr[$value->id]=$value->country_code;
            $country_code_details_arr[$value->id]['short_name']=$value->short_name;
            $country_code_details_arr[$value->id]['code']=$value->country_code;
        }

        $data['country_code_arr']   =$country_code_details_arr;
        $data['country_arr']        =$country_arr;
        $data['user']               =$user;
        $data['user_image']         =$user_image;
        $data['user_type_arr']      =$user_type_arr;
        $data['property_code']      =$property_code;
       

        // if($project_type==105)
        // {

        //     return view('auth.register_layer_one',$data);
        //     //return redirect('/Dashboard#/Temp-CompanyProfile');
        // }
        // else
        if($project_type>93)
        {

            $data['menu']=Menu::where('status', '=', 10)->orderBy('slno','DESC')->get();
            $main_menu_arr=array();
            foreach ($data['menu'] as $key => $value) {
                $main_menu_arr[$value->id]['menuName']  =$value->menuName;
                $main_menu_arr[$value->id]['menuRoute'] =$value->menuRoute;
                $main_menu_arr[$value->id]['slno']      =$value->slno;
            }
            $data['main_menu_arr']=$main_menu_arr;
            $data['project_type']=$project_type;
            return view('temp_dashboard.account_no2',$data);
            //return redirect('/Dashboard#/Temp-CompanyProfile');
        }
        
        else {

            // $PublicIP = $_SERVER['REMOTE_ADDR'];
           // $PublicIP="45.125.220.162";
            // //Uses ipinfo.io to get the location of the IP Address, you can use another site but it will probably have a different implementation
           //  $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
            // //Breaks down the JSON object into an array
            // $json     = json_decode($json, true);

            // dd($json);
            //This variable is the visitor's county
           // $country  = $json['country'];
            //This variable is the visitor's region
           // $region   = $json['region'];
            //This variable is the visitor's city
            $city     = "Canada";

            //$city=$_POST['city'];
            $url="http://api.openweathermap.org/data/2.5/weather?q=$city&appid=49c0bad2c7458f1c76bec9654081a661";
            $ch=curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            $result=curl_exec($ch);
            curl_close($ch);
            $result=json_decode($result,true);
            $data['weather']=$result;
            //dd($result);die;
            //echo $city;
            // die;


            $data['module']=Module::where('status', '=', 1)->orderBy('modSlNo')->get();
            $data['menu']=DB::table('menus as menu')
                            // ->join('user_privileges as user_priv', function($join)
                            //  {
                            //      $join->on('menu.id','=','user_priv.main_menu_id');
                            //     // $join->on('menu.moduleId','=','user_priv.module_id');
                                
                            //  })
                            // ->where('user_priv.user_id', '=', $user->id)
                            // ->where('user_priv.status_active', '=', 1)
                            // ->where('user_priv.is_deleted', '=', 0)
                            ->where('menu.status', '=', 1)
                            //->where('menu.position', '=', 1)
                            ->select('menu.*')
                            ->orderBy('slno','ASC')
                            ->get();
                             //->toSql();

                             //dd($data['menu']);
            //$data['menu']=Menu::where('status', '=', 1)->orderBy('slno')->get();
            $main_menu_arr=array();
            $lavel_one_arr=array();
            $lavel_two_arr=array();
            $lavel_three_arr=array();
            foreach ($data['menu'] as $key => $value) {
                if($value->position==2)
                {
                    $lavel_one_arr[$value->rootMenu][$value->id]['menuName']    =$value->menuName;
                    $lavel_one_arr[$value->rootMenu][$value->id]['menuRoute']   =$value->menuRoute;
                    $lavel_one_arr[$value->rootMenu][$value->id]['class']       =$value->class;
                }
                else if($value->position==3)
                {
                    $lavel_two_arr[$value->rootMenu][$value->id]['menuName']    =$value->menuName;
                    $lavel_two_arr[$value->rootMenu][$value->id]['menuRoute']   =$value->menuRoute;
                    $lavel_two_arr[$value->rootMenu][$value->id]['class']       =$value->class;
                }
                else if($value->position==4)
                {
                    $lavel_three_arr[$value->rootMenu][$value->id]['menuName']  =$value->menuName;
                    $lavel_three_arr[$value->rootMenu][$value->id]['menuRoute'] =$value->menuRoute;
                    $lavel_three_arr[$value->rootMenu][$value->id]['class']     =$value->class;
                }
                
               
            }
            $data['lavel_one_arr']      =$lavel_one_arr;
            $data['lavel_two_arr']      =$lavel_two_arr;
            $data['lavel_three_arr']    =$lavel_three_arr;
            //return $data;
            return view('dashboard',$data);
        } 
        
        //return view('dashboard');
    }

   


    public function user_module($module_id)
    {
        $data['module']=Module::where('status', '=', 1)->get();
        $selected_module=Module::where('id', '=', $module_id)->get(['moduleName']);
        $data['title']=$selected_module[0]->moduleName;
       // dd($data['title']);
        $user_id = \Auth::user()->id;
        $menu_data=Menu::where('status', '=', 1)->where('moduleId', '=', $module_id)->get();

        $data['menu']=$menu_data;
        $root_menu_arr=array();
        $main_menu_arr=array();
        foreach($menu_data as $m=>$mvalue)
        {

        	if($mvalue->rootMenu>0 || $mvalue->position>1)
        	{
        		 $root_menu_arr[$mvalue->rootMenu][$mvalue->id]['id']=$mvalue->id;
           		 $root_menu_arr[$mvalue->rootMenu][$mvalue->id]['name']=$mvalue->menuName;
           		 $root_menu_arr[$mvalue->rootMenu][$mvalue->id]['menuRoute']=$mvalue->menuRoute;

           		 
        	}
        	else if($mvalue->rootMenu==0 || $mvalue->position==1)
        	{
        		 $main_menu_arr[$mvalue->id]['id']=$mvalue->id;
           		 $main_menu_arr[$mvalue->id]['name']=$mvalue->menuName;
                 $main_menu_arr[$mvalue->id]['menuRoute']=$mvalue->menuRoute;
        	}
           
        }

        $data['rootMenu']=$this->menu->where('moduleId', '=', $module_id)->where('rootMenu', '=', 0)->all();
        $data['root_menu_arr']=$root_menu_arr;
        $data['main_menu_arr']=$main_menu_arr;

    //return $data;
        return view('dashboard_module',$data);
    }
}
