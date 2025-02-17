<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as User;
use App\Classes\ArrayFunction as ArrayFunction;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $ArrayFunction          =new ArrayFunction();
        $row_status             =$ArrayFunction->row_status;
        $user_type_arr          =$ArrayFunction->user_type_arr;
        $data['row_status']=$row_status;
        $data['user_type_arr']=$user_type_arr;
        $user_data=User::all();

        $sl=0;
        foreach($user_data as $key=>$val)
        {
    
            $data['user_data'][$sl]['id']=$val->id;
            $data['user_data'][$sl]['sl']=$sl+1;
            $data['user_data'][$sl]['name']=$val->name;
            $data['user_data'][$sl]['email']=$val->email;
           // $data['user_data'][$sl]['password']=$val->password;
            $data['user_data'][$sl]['user_type']=$val->user_type;
            $data['user_data'][$sl]['user_type_string']=$user_type_arr[$val->user_type];
            $data['user_data'][$sl]['status_active']=$val->status_active;
            $data['user_data'][$sl]['status']=$row_status[$val->status_active];
            $sl++;

        }

        if(empty($data['user_data'])) $data['user_data']=array();
        return $data;
    }

    public function project_user()
    {

        $project_id = \Auth::user()->project_id;
        $user_data=User::where('project_id','=',$project_id)->select('id','name')->get();

        $data['user_data']=$user_data;

        if(empty($data['user_data'])) $data['user_data']=array();
        return $data;
    }

    public function UserTypeData($user_type)
    {

        $project_id = \Auth::user()->project_id;
        $user_data=User::where('project_id','=',$project_id)
                         ->where('user_type','=',$user_type)
                         ->select('id','name')->get();

        $data['user_data']=$user_data;

        if(empty($data['user_data'])) $data['user_data']=array();
        return $data;
    }


    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'status_active' => 'required',
            'user_type' => 'required',
        ]);
        $user_id = \Auth::user()->id;
        $request->merge(['password'=>bcrypt($request->input('password'))]);
        $request->merge(['inserted_by'=>$user_id]);
        return User::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'status_active' => 'required',
            'user_type' => 'required',
        ]);
        $request->merge(['password'       =>bcrypt($request->input('password'))]);

        $user_id = \Auth::user()->id;
        $request->merge(['updated_by'=>$user_id]);

        User::find($id)->update($request->all());
        
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
        User::find($id)->delete();
        return ['message'=>'User deleted'];
    }
}
