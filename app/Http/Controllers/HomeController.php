<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module as Module;
use App\Models\Menu as Menu;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( Module $module,Menu $menu)
    {
        $this->middleware('auth');
        $this->module=$module->orderBy('modSlNo')->get();
        $this->menu=$menu->all();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */  
    public function index()
    {
        $data['module']=$this->module->all();
        $data['menu']=$this->menu->all();
        
        $data['smenu_id']=0;
        $data['smodule_id']=0 ;
       // dd($data);
        return view('dashboard2',$data);
        //return view('dashboard');
    }

    public function user_dashboard()
    {
        $data['module']=$this->module->all();
        $data['menu']=$this->menu->all();
        
        // echo config('app.name', 'Strata Optimizer') ;die;

        $main_menu_arr=array();
        foreach($this->menu->where('status', '=', 1)->all() as $m=>$mvalue)
        {
            $main_menu_arr[$mvalue->moduleId][$mvalue->id]['menuName']=$mvalue->menuName;
            $main_menu_arr[$mvalue->moduleId][$mvalue->id]['menuRoute']=$mvalue->menuRoute;
        }

        $data['main_menu_arr']=$main_menu_arr;
        $data['smenu_id']=0;
        $data['smodule_id']=0 ;
        $data['sroot_menu_id']=0; 
        return view('dashboard',$data);
       // return view('dashboard_datatable',$data);
        //return view('dashboard'); 
    }

    public function user_module($module_id)
    {
       
        $data['module']=$this->module->all();
        $menu_data=$this->menu->where('moduleId', '=', $module_id)->all();

        $data['menu']=$menu_data;
        $root_menu_arr=array();
        foreach($menu_data as $m=>$mvalue)
        {

            $root_menu_arr[$mvalue->rootMenu][$mvalue->id]['id']=$mvalue->id;
            $root_menu_arr[$mvalue->rootMenu][$mvalue->id]['name']=$mvalue->menuName;
        }

        $data['rootMenu']=$this->menu->where('moduleId', '=', $module_id)->where('rootMenu', '=', 0)->all();
        $data['root_menu_arr']=$root_menu_arr;


        $data['smenu_id']=0;
        $data['smodule_id']=$module_id ; 
        $data['sroot_menu_id']=0;
        return view('dashboard2',$data);
        //return view('dashboard'); 
    }
}
