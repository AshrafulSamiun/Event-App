<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module as Module;
use App\Models\Menu as Menu;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct( Module $module,Menu $menu )
    {
        $this->middleware('auth');
        $this->module=$module->all();
        $this->menu=$menu->all();
        //session_start();
    }

    public function index()
    {
      
    }



    public function loadMenuByModule($moule_id)
    {
        
        $data['menuArr'] =DB::table('menus')
                        ->where('status','=',1)
                        ->where('moduleId','=',$moule_id)
                        ->select('id', 'menuName','slno','rootMenu','position')
                        //->union($main_menu)
                        ->orderby('position')
                        ->orderby('slno')
                        ->get();

        // $main_menu_arr=array();
        // $lavel_one_arr=array();
        // $lavel_two_arr=array();
        // foreach ($data['menu'] as $key => $value) {
        //     if($value->position==1)
        //     {
        //        // $lavel_one_arr[$value->rootMenu][$value->id]['id']=$value->id;
        //         $main_menu_arr[$value->id]=$value;
        //         $main_menu_arr[$value->id]=$value;
        //     }
        //     else if($value->position==2)
        //     {
        //        // $lavel_one_arr[$value->rootMenu][$value->id]['id']=$value->id;
        //         $lavel_one_arr[$value->rootMenu][$value->id]=$value;
        //         $lavel_one_arr[$value->rootMenu][$value->id]=$value;
        //     }
            
        //     else if($value->position==3)
        //     {
        //        // $lavel_two_arr[$value->rootMenu]['id']=$value->id;
        //         $lavel_two_arr[$value->rootMenu][$value->id]['menuName']=$value->menuName;
        //         $lavel_two_arr[$value->rootMenu][$value->id]['menuRoute']=$value->menuRoute;
        //     }
            
           
        // }
        // $data['lavel_one_arr']=$lavel_one_arr;
        // $data['lavel_two_arr']=$lavel_two_arr;
        


        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'moduleId' => 'required',
            'menuName' => 'required',
            'slno' => 'required',
           // 'menuRoute' => 'required',
            'status' => 'required',
        ]);
        $project_id = \Auth::user()->project_id;
        $request->merge(['project_id'      =>$project_id]);
        return Menu::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'moduleId' => 'required',
            'menuName' => 'required',
            'slno' => 'required',
            //'menuRoute' => 'required',
            'status' => 'required',
        ]);
        $project_id = \Auth::user()->project_id;
        $request->merge(['project_id'      =>$project_id]);
        Menu::find($id)->update($request->all());
        
        return ['message'=>'update successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Menu::find($id)->delete();
        return ['message'=>'Module deleted'];
    }
}
