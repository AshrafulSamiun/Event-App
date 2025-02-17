<?php

namespace App\Http\Controllers\OperatingModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\ArrayFunction as ArrayFunction;
use App\Classes\CommonFunction as CommonFunction;
use App\Models\Meeting;
use App\Models\UserInformationDetails;
use App\Models\MeetingParticipants;
use App\Models\User;
use App\Models\BlockUser;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
           // $company_type=$request->session()->get('company_type');
        }
        else {

            return 100; 
        }

        $user=\Auth::user();
        $project_id                         = $user->project_id;
        $user_id                            =$user->id;
        $user_name                          =$user->name;
        $ArrayFunction                      =new ArrayFunction();
        $announcement_status_arr            =$ArrayFunction->announcement_status_arr;
        $participant_arr                    =array();

        foreach($ArrayFunction->participant_arr as $index=>$value)
        {
            $array=array();
            $array['id']=$index;
            $array['name']=$value;
            array_push($participant_arr,$array);
        }
        
        $data['participant_arr']            =$participant_arr; 
        $data['issued_by']                  =$user_name;
        $data['issued_by_id']               =$user_id;
       

        $meeting_send_list=Meeting::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                       // ->where('inserted_by',"!=",$user_id)
                                       // ->whereIn('posting_status', [2, 4])
                                        ->get();


        $data['meeting_send_list']=array(); $sl=0;
        $total_announcement=0;
        foreach ($meeting_send_list as $key => $value) {

            $data['meeting_send_list'][$key]['sl']                     =$sl+1;
            $data['meeting_send_list'][$key]['id']                     =$value->id;
            $data['meeting_send_list'][$key]['system_no']              =$value->system_no;
            $data['meeting_send_list'][$key]['meeting_date']           =date("Y-m-d",strtotime($value->meeting_date));
            $data['meeting_send_list'][$key]['meeting_time']           =date("h:i A",strtotime($value->meeting_date));
            $data['meeting_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['meeting_send_list'][$key]['priority']               =$value->priority;
            $data['meeting_send_list'][$key]['notification_method']    =$value->notification_method;
            
            $data['meeting_send_list'][$key]['status']                 =$value->status;
            $data['meeting_send_list'][$key]['status_string']          =$announcement_status_arr[$value->status];
            $data['meeting_send_list'][$key]['rejection_cause']        =$value->rejection_cause;                      
            $data['meeting_send_list'][$key]['subject']                =$value->subject;
            $data['meeting_send_list'][$key]['comments']               =$value->comments;
            $data['meeting_send_list'][$key]['required_action']        =$value->required_action;
            $data['meeting_send_list'][$key]['instruction']            =$value->instruction;
            $data['meeting_send_list'][$key]['posting_status']         =$value->posting_status;
            $sl++;

        }

        return $data;

    }

    public function MeetingList( Request $request)
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_id=$user->id;
        $ArrayFunction              =new ArrayFunction();
        $announcement_status_arr    =$ArrayFunction->announcement_status_arr;
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return 100; 
        }

        $meeting_send_list=Meeting::where('is_deleted',0)
                                                ->where('project_id',$project_id)
                                                ->where('company_id',$company_id)
                                                ->where('inserted_by',$user_id)
                                                ->orderBy('system_no','desc')
                                                ->get();

        $data['meeting_send_list']=array(); $sl=0;
        foreach ($meeting_send_list as $key => $value) {

            $data['meeting_send_list'][$key]['sl']                     =$sl+1;
            $data['meeting_send_list'][$key]['id']                     =$value->id;
            $data['meeting_send_list'][$key]['system_no']              =$value->system_no;
            $data['meeting_send_list'][$key]['meeting_date']           =date("D M d, Y",strtotime($value->meeting_date));

            $data['meeting_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['meeting_send_list'][$key]['priority']               =$value->priority;
            $data['meeting_send_list'][$key]['notification_method']    =$value->notification_method;
            
            $data['meeting_send_list'][$key]['status']                 =$value->status;
            $data['meeting_send_list'][$key]['status_string']          =$announcement_status_arr[$value->status];
            $data['meeting_send_list'][$key]['title']                  =$value->title;            
            $data['meeting_send_list'][$key]['subject']                =$value->subject;
            $data['meeting_send_list'][$key]['required_action']        =$value->required_action;
            $data['meeting_send_list'][$key]['posting_status']         =$value->posting_status;

            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['meeting_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['meeting_send_list'][$key]['photo_path']     ="";
            }
            $sl++;

        }

        
        return $data;

    }

    public function list_by_posting_type( Request $request, $type)
    {

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else
        {
            return 100;
        }

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_id                    =$user->id;
        $ArrayFunction              =new ArrayFunction();
        $announcement_status_arr    =$ArrayFunction->announcement_status_arr;

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return 100; 
        }

        $meeting_list_sql=Meeting::where('is_deleted',0)
                                                ->where('project_id',$project_id)
                                                ->where('company_id',$company_id)
                                               // ->where('inserted_by',$user_id)
                                                ->orderBy('system_no','desc');
                                               // ->get();                                
        if($type==1)  
        {
            $meeting_list_sql->where('posting_status',0)->where('status_active',1);
        }
        else if($type==2)  
        {
            $meeting_list_sql->where('posting_status',0)->where('status_active',3);
        }
        else if($type==3)  
        {
            $meeting_list_sql->where('posting_status',1)->where('status_active',1);
        }
        else if($type==4)  
        {
            $meeting_list_sql->where('posting_status',1)->where('status_active',2);
        }
        else if($type==5)  
        {
            $meeting_list_sql->where('posting_status',2)->where('status_active',1);
        }
        else if($type==6)  
        {
            $meeting_list_sql->where('posting_status',3)->where('status_active',1);
        }
        else if($type==7)  
        {
            $meeting_list_sql->where('posting_status',4)->where('status_active',1);
        }

        $meeting_send_list=$meeting_list_sql->get();

        $data['meeting_send_list']=array(); $sl=0;
        foreach ($meeting_send_list as $key => $value) {

            $data['meeting_send_list'][$key]['sl']                     =$sl+1;
            $data['meeting_send_list'][$key]['id']                     =$value->id;
            $data['meeting_send_list'][$key]['system_no']              =$value->system_no;
            $data['meeting_send_list'][$key]['meeting_date']           =date("D M d, Y",strtotime($value->meeting_date));

            $data['meeting_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['meeting_send_list'][$key]['priority']               =$value->priority;
            $data['meeting_send_list'][$key]['notification_method']    =$value->notification_method;
            
            $data['meeting_send_list'][$key]['status']                 =$value->status;
            $data['meeting_send_list'][$key]['status_string']          =$announcement_status_arr[$value->status];
            $data['meeting_send_list'][$key]['rejection_cause']        =$value->rejection_cause;
            $data['meeting_send_list'][$key]['expire_date']            =$value->expire_date;
            $data['meeting_send_list'][$key]['job_site']               =$value->job_site;            
            $data['meeting_send_list'][$key]['subject']                =$value->subject;
            $data['meeting_send_list'][$key]['details']                =$value->details;
           // $data['meeting_send_list'][$key]['dedline_date']           =$value->dedline_date;
            $data['meeting_send_list'][$key]['required_action']        =$value->required_action;
            $data['meeting_send_list'][$key]['instruction']            =$value->instruction;
            $data['meeting_send_list'][$key]['posting_status']         =$value->posting_status;

            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['meeting_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['meeting_send_list'][$key]['photo_path']     ="";
            }
            $sl++;

        }
        
        return $data;
    }

    public function posting_status( Request $request)
    {

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else
        {
            return 100;
        }

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_id                    = $user->user_id;
       

        $sl=0;
        $meeting_send_list=Meeting::where('is_deleted',0)
                                                ->where('project_id',$project_id)
                                                ->where('company_id',$company_id)
                                                //->where('inserted_by',$user_id)
                                                ->orderBy('system_no','desc')
                                                ->get();


        $data['meeting_list']['saved']       =0;
        $data['meeting_list']['transmit_out']=0;
        $data['meeting_list']['rejected']    =0;
        $data['meeting_list']['voided']      =0;
        $data['meeting_list']['posted']      =0;
        $data['meeting_list']['adjusted']    =0;
        $data['meeting_list']['reposted']    =0;
        foreach ($meeting_send_list as $key => $value) {
            if($value->posting_status==0)
            {
                if ($value->status_active==1)
                    $data['meeting_list']['saved']++;
                else if ($value->status_active==3)
                    $data['meeting_list']['rejected']++;
            }
            if($value->posting_status==1)
            {
                if ($value->status_active==1)
                    $data['meeting_list']['transmit_out']++;
                else if ($value->status_active==2)
                    $data['meeting_list']['voided']++;
            }
            else if ($value->posting_status==2)
            {
                $data['meeting_list']['posted']++;
            }
            else if ($value->posting_status==3)
            {
                $data['meeting_list']['adjusted']++;
            }
            else if ($value->posting_status==4)
            {
                $data['meeting_list']['reposted']++;
            }
        }
        
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

        $company_id="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return 100; 
        }

        request()->validate([
            'title'                 => 'required',
            'subject'               => 'required',
            'issued_by'             => 'required',
            'location'              => 'required',
            'notification_method'   => 'required',
            'participants'          => 'required',
            'priority'              => 'required',
            'required_action'       => 'required',
            'meeting_date'          => 'required',
            
        ]);

        if($request->input('notification_method')==4)
        {
            request()->validate([
                'other_notification'   => 'required',                
            ]);
        }


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;

        $CommonFunction                      =new CommonFunction();  
        // =========================Meeting Date & Time =============================
        if($request->input('meeting_date'))
        {
            $meeting_date                           =date("Y-m-d",strtotime($request->input('meeting_date')));
            $request->merge(['meeting_date'         =>$meeting_date]);
        }

        if($request->input('meeting_time'))
        {

                  
            $meeting_time                           =$CommonFunction->convert_time_arr($request->input('meeting_time'));
            $request->merge(['meeting_time'         =>$meeting_time]);
        }
        else{
            $request->merge(['meeting_time'         =>""]);
        }
        // ======================first reminder=======================================
        if($request->input('first_reminder_date'))
        {
            $first_reminder_date                    =date("Y-m-d",strtotime($request->input('first_reminder_date')));
            $request->merge(['first_reminder_date'  =>$first_reminder_date]);
        }

        if($request->input('first_reminder_time'))
        {
            $first_reminder_time                    =$CommonFunction->convert_time_arr($request->input('first_reminder_time'));
            $request->merge(['first_reminder_time'  =>$first_reminder_time]);
        }
        else{
            $request->merge(['first_reminder_time'  =>""]);
        }

        // ===============Second Reminder Date & Time=======================================
        if($request->input('second_reminder_date'))
        {
            $second_reminder_date                    =date("Y-m-d",strtotime($request->input('second_reminder_date')));
            $request->merge(['second_reminder_date'  =>$second_reminder_date]);
        }

        if($request->input('second_reminder_time'))
        {
            $second_reminder_time                    =$CommonFunction->convert_time_arr($request->input('second_reminder_time'));
            $request->merge(['second_reminder_time'  =>$second_reminder_time]);
        }
        else{
            $request->merge(['second_reminder_time'  =>""]);
        }

        if($request->input('next_meeting_date'))
        {
            $next_meeting_date                       =date("Y-m-d",strtotime($request->input('next_meeting_date')));
            $request->merge(['next_meeting_date'     =>$next_meeting_date]);
        }

        if($request->input('next_meeting_time'))
        {
            $next_meeting_time                       =$CommonFunction->convert_time_arr($request->input('next_meeting_time'));
            $request->merge(['next_meeting_time'     =>$next_meeting_time]);
        }
        else{
            $request->merge(['next_meeting_time'     =>""]);
        }
       
        $request->merge(['user_id'                  =>$user_id]);
        $request->merge(['inserted_by'              =>$user_id]);
        $request->merge(['project_id'               =>$project_id]);
        $request->merge(['posting_status'           =>0]);      
        $request->merge(['company_id'               =>$company_id]);
        

        $year= date("y",strtotime($request->input('meeting_date')));
        $year_full= date("Y",strtotime($request->input('meeting_date')));
        $max_system_data =Meeting::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from meetings 
            where project_id=".$project_id." and Year(meeting_date)=".$year_full." and company_id=".$company_id.") 
             and company_id=".$company_id." and Year(meeting_date)=".$year_full."  and project_id=".$project_id)->get(['system_prefix']);
          
       
        if(count($max_system_data)>0)
        {
            $max_system_prefix      =$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix      =1; 
        }
        
        $system_no="METG-".$year."-".str_pad($max_system_prefix, 5, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $meeting_info= Meeting::create($request->all());


        foreach($request->participants as $key=>$details)
        {
           

                $data_particiapant[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$meeting_info->id,
                    'item_id'                   =>$details['id'],
                    'item_name'                 =>$details['name'],
                    'inserted_by'               =>$user_id,
                );
            
        }

        //dd($data_particiapant);
        $RId1=true;

       
        if(!empty($data_particiapant))
        {
            $RId1=MeetingParticipants::insert($data_particiapant);
        }
        if($meeting_info && $RId1)
        {
           DB::commit();
           return "1**$meeting_info->id**$system_no";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
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
    public function edit($id,Request $request)
    {

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return 100; 
        }

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_id                    =$user->id;
        $ArrayFunction              =new ArrayFunction();
        $user_type                  =$user->user_type;
        $data['user_type']          =$user_type;
        $CommonFunction             =new CommonFunction(); 

        $meeting_send_list          =Meeting::where('is_deleted',0)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('id',"=",$id)
                                        ->get();


        $data['meeting_send_list']=array(); $sl=0;
        $total_announcement=0;
        foreach ($meeting_send_list as $key => $value) {
                
            $data['meeting_send_list']['sl']                     =$sl+1;
            $data['meeting_send_list']['id']                     =$value->id;
            $data['meeting_send_list']['system_no']              =$value->system_no;
            $data['meeting_send_list']['meeting_date']           =date("Y m d",strtotime($value->meeting_date));
            //dd($value->meeting_time);
           // dd($CommonFunction->get_converted_time($value->meeting_time));
            $data['meeting_send_list']['meeting_time']           =$CommonFunction->get_converted_time($value->meeting_time);
           // $data['meeting_send_list']['meeting_time']           =$value->meeting_time;
            $data['meeting_send_list']['issued_by']              =$value->issued_by;
            $data['meeting_send_list']['issued_by_id']           =$value->issued_by_id;
            $data['meeting_send_list']['participants']           =$value->participants;
            $data['meeting_send_list']['priority']               =$value->priority;
            $data['meeting_send_list']['status']                 =$value->status;
            $data['meeting_send_list']['title']                  =$value->title;             
            $data['meeting_send_list']['subject']                =$value->subject;
            $data['meeting_send_list']['location']               =$value->location;
            $data['meeting_send_list']['location_link']          =$value->location_link;
            $data['meeting_send_list']['comments']               =$value->comments;
            $data['meeting_send_list']['required_action']        =$value->required_action;
            $data['meeting_send_list']['first_reminder_date']    =date("Y m d",strtotime($value->first_reminder_date));
            $data['meeting_send_list']['second_reminder_date']   =date("Y m d",strtotime($value->second_reminder_date));
            $data['meeting_send_list']['next_meeting_date']      =date("Y m d",strtotime($value->next_meeting_date));
            $data['meeting_send_list']['next_meeting_time']      =$value->next_meeting_time;
            $data['meeting_send_list']['first_reminder_time']    =$value->first_reminder_time;
            $data['meeting_send_list']['second_reminder_time']   =$value->second_reminder_time;
            $data['meeting_send_list']['posting_status']         =$value->posting_status;
            $data['meeting_send_list']['file_id']                =$value->file_id;

            

            if($value->file_id)
            {
                $data['meeting_send_list']['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['meeting_send_list']['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['meeting_send_list']['file_path']        ="";
                $data['meeting_send_list']['file_name']        ="";
            }


            $data['meeting_send_list']['posting_time']         =date("h:i:s A",strtotime($value->updated_at));
            $data['meeting_send_list']['posting_date']         =date("D M d, Y",strtotime($value->updated_at));


            if($value->posting_status==0)
            {
                if ($value->status_active==1)
                    $data['meeting_send_list']['posting_status_string']="Saved";
                else if ($value->status_active==3)
                    $data['meeting_send_list']['posting_status_string']='Rejected';
            }
            if($value->posting_status==1)
            {
                if ($value->status_active==1)
                    $data['meeting_send_list']['posting_status_string']='Transmit Out';
                else if ($value->status_active==2)
                    $data['meeting_send_list']['posting_status_string']='Voided';
            }
            else if ($value->posting_status==2)
            {
                $data['meeting_send_list']['posting_status_string']='Posted';
            }
            else if ($value->posting_status==3)
            {
                $data['meeting_send_list']['posting_status_string']='Adjusted';
            }
            else if ($value->posting_status==4)
            {
                $data['meeting_send_list']['posting_status_string']='Reposted';
            }
            $sl++;

        }

        return $data;

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
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return 100; 
        }

        request()->validate([
            'title'                 => 'required',
            'subject'               => 'required',
            'issued_by'             => 'required',
            'location'              => 'required',
            'notification_method'   => 'required',
            'participants'          => 'required',
            'priority'              => 'required',
            'required_action'       => 'required',
            'meeting_data'          => 'required',
            
        ]);
       
        //dd($request->all());
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        
        // =========================Meeting Date & Time =============================
        if($request->input('meeting_date'))
        {
            $meeting_date                           =date("Y-m-d",strtotime($request->input('meeting_date')));
            $request->merge(['meeting_date'         =>$meeting_date]);
        }

        if($request->input('meeting_time'))
        {
            $meeting_time                           =date("H:i:s",strtotime($request->input('meeting_time')));
            $request->merge(['meeting_time'         =>$meeting_time]);
        }
        else{
            $request->merge(['meeting_time'         =>""]);
        }
        // ======================first reminder=======================================
        if($request->input('first_reminder_date'))
        {
            $first_reminder_date                    =date("Y-m-d",strtotime($request->input('first_reminder_date')));
            $request->merge(['first_reminder_date'  =>$first_reminder_date]);
        }

        if($request->input('first_reminder_time'))
        {
            $first_reminder_time                    =date("H:i:s",strtotime($request->input('first_reminder_time')));
            $request->merge(['first_reminder_time'  =>$first_reminder_time]);
        }
        else{
            $request->merge(['first_reminder_time'  =>""]);
        }

        // ===============Second Reminder Date & Time=======================================
        if($request->input('second_reminder_date'))
        {
            $second_reminder_date                    =date("Y-m-d",strtotime($request->input('second_reminder_date')));
            $request->merge(['second_reminder_date'  =>$second_reminder_date]);
        }

        if($request->input('second_reminder_time'))
        {
            $second_reminder_time                    =date("H:i:s",strtotime($request->input('second_reminder_time')));
            $request->merge(['second_reminder_time'  =>$second_reminder_time]);
        }
        else{
            $request->merge(['second_reminder_time'  =>""]);
        }

        if($request->input('next_meeting_date'))
        {
            $next_meeting_date                       =date("Y-m-d",strtotime($request->input('next_meeting_date')));
            $request->merge(['next_meeting_date'     =>$next_meeting_date]);
        }

        if($request->input('next_meeting_time'))
        {
            $next_meeting_time                       =date("H:i:s",strtotime($request->input('next_meeting_time')));
            $request->merge(['next_meeting_time'     =>$next_meeting_time]);
        }
        else{
            $request->merge(['next_meeting_time'     =>""]);
        }
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['updated_by'           =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);



       // $request->merge(['company_id' =>$company_id]);

        DB::beginTransaction();
        $meeting_info= Meeting::find($id)->update($request->all());
        $update_data= array(
                        
            'status_active'             =>0,
            'is_deleted'                =>1,
            'updated_by'                =>$user_id,
        );

        $participant_delete=MeetingParticipants::where('master_id',"=",$id)->update($update_data);  

        foreach($request->participants as $key=>$details)
        {
            $data_particiapant[]= array(
                'project_id'                =>$project_id,
                'master_id'                 =>$id,
                'item_id'                   =>$details['id'],
                'item_name'                 =>$details['name'],
                'inserted_by'               =>$user_id,
            );
            
        }

        //dd($data_particiapant);
        $RId1=true;

       
        if(!empty($data_particiapant))
        {
            $RId1=MeetingParticipants::insert($data_particiapant);
        }
       

        if($meeting_info && $participant_delete && $RId1)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        DB::beginTransaction();
        $meeting_info= Meeting::find($id)->update(['updated_by'=>$user_id,'status_active'=>0,'is_deleted'=>1]);       

        $update_data= array(
                        
                            'status_active'             =>0,
                            'is_deleted'                =>1,
                            'updated_by'                =>$user_id,
                        );

        $participant_delete=MeetingParticipants::where('master_id',"=",$id)->update($update_data);
                       
        if($meeting_info && $participant_delete)
        {           
            DB::commit();
            return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }


    
    public function reject(Request $request,$id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        DB::beginTransaction();
        $update_data= array(
                            'status_active'             =>3,
                            'posting_status'            =>0,
                            'updated_by'                =>$user_id,
                        );
      
        $meetingInfo=Meeting::where('id',"=",$id)->update($update_data);

        if($meetingInfo)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }

    public function post(Request $request,$id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 
        $all_user_data=User::where("status_active",1)->get();

        DB::beginTransaction();

        $update_data= array(
                            'posting_status'            =>$request->input("posting_status"),
                            'updated_by'                =>$user_id,
                            'status_active'             =>1
                        );
      
        $meetingInfo=Meeting::where('id',"=",$id)->update($update_data);

        foreach($all_user_data as $key=>$details)
        {
            $data_user_ann[]= array(
                'project_id'                =>$project_id,
                'master_id'                 =>$id,
                'mail_type'                 =>1,
                'send_by'                   =>$user_id,
                'user_id'                   =>$details['id'],
                'page_name'                 =>"Meeting",
                'inserted_by'               =>$user_id,
            );

            $data_user_ann[]= array(
                'project_id'                =>$project_id,
                'master_id'                 =>$id,
                'mail_type'                 =>2,
                'send_by'                   =>$user_id,
                'user_id'                   =>$details['id'],
                'page_name'                 =>"Meeting",
                'inserted_by'               =>$user_id,
            );
            
        }


        $RID1=true;

        if(!empty($data_user_ann))
        {
            $RID1=UserInformationDetails::insert($data_user_ann);
        }
        
        if($meetingInfo && $RID1)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }
    public function void(Request $request,$id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        DB::beginTransaction();
        $update_data= array(
                            'status_active'             =>2,
                            'updated_by'                =>$user_id,
                        );
      
        $meetingInfo=Meeting::where('id',"=",$id)->update($update_data);

        if($meetingInfo)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }
    public function adjust(Request $request, $id)
    {
        $company_id="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return 100; 
        }

        request()->validate([
            'title'                 => 'required',
            'subject'               => 'required',
            'issued_by'             => 'required',
            'location'              => 'required',
            'notification_method'   => 'required',
            'participants'          => 'required',
            'priority'              => 'required',
            'required_action'       => 'required',
            'meeting_data'          => 'required',
            
        ]);


        $user_data                          = \Auth::user();
        $user_id                            =$user_data->id;
        $project_id                         =$user_data->project_id;
        $request->merge(['user_id'          =>$user_id]);
        $request->merge(['updated_by'       =>$user_id]);
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['posting_status'   =>3]);
        $request->merge(['status_active'    =>1]);

        // =========================Meeting Date & Time =============================
        if($request->input('meeting_date'))
        {
            $meeting_date                           =date("Y-m-d",strtotime($request->input('meeting_date')));
            $request->merge(['meeting_date'         =>$meeting_date]);
        }

        if($request->input('meeting_time'))
        {
            $meeting_time                           =date("H:i:s",strtotime($request->input('meeting_time')));
            $request->merge(['meeting_time'         =>$meeting_time]);
        }
        else{
            $request->merge(['meeting_time'         =>""]);
        }
        // ======================first reminder=======================================
        if($request->input('first_reminder_date'))
        {
            $first_reminder_date                    =date("Y-m-d",strtotime($request->input('first_reminder_date')));
            $request->merge(['first_reminder_date'  =>$first_reminder_date]);
        }

        if($request->input('first_reminder_time'))
        {
            $first_reminder_time                    =date("H:i:s",strtotime($request->input('first_reminder_time')));
            $request->merge(['first_reminder_time'  =>$first_reminder_time]);
        }
        else{
            $request->merge(['first_reminder_time'  =>""]);
        }

        // ===============Second Reminder Date & Time=======================================
        if($request->input('second_reminder_date'))
        {
            $second_reminder_date                    =date("Y-m-d",strtotime($request->input('second_reminder_date')));
            $request->merge(['second_reminder_date'  =>$second_reminder_date]);
        }

        if($request->input('second_reminder_time'))
        {
            $second_reminder_time                    =date("H:i:s",strtotime($request->input('second_reminder_time')));
            $request->merge(['second_reminder_time'  =>$second_reminder_time]);
        }
        else{
            $request->merge(['second_reminder_time'  =>""]);
        }

        if($request->input('next_meeting_date'))
        {
            $next_meeting_date                       =date("Y-m-d",strtotime($request->input('next_meeting_date')));
            $request->merge(['next_meeting_date'     =>$next_meeting_date]);
        }

        if($request->input('next_meeting_time'))
        {
            $next_meeting_time                       =date("H:i:s",strtotime($request->input('next_meeting_time')));
            $request->merge(['next_meeting_time'     =>$next_meeting_time]);
        }
        else{
            $request->merge(['next_meeting_time'     =>""]);
        }

        DB::beginTransaction();
        $meeting_info= Meeting::find($id)->update($request->all());
        $update_data= array(
                        
            'status_active'             =>0,
            'is_deleted'                =>1,
            'updated_by'                =>$user_id,
        );

        $participant_delete=MeetingParticipants::where('master_id',"=",$id)->update($update_data);

        foreach($request->participants as $key=>$details)
        {
            $data_particiapant[]= array(
                'project_id'                =>$project_id,
                'master_id'                 =>$id,
                'item_id'                   =>$details['id'],
                'item_name'                 =>$details['name'],
                'inserted_by'               =>$user_id,
            );
            
        }

        $RId1=true;
              
        if(!empty($data_particiapant))
        {
            $RId1=MeetingParticipants::insert($data_particiapant);
        }
       
        if($meeting_info &&  $participant_delete && $RId1)
        {
            DB::commit();
           
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }


    public function repost(Request $request,$id)
    {
        $company_id="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return 100; 
        }

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;       

        DB::beginTransaction();

        $update_data= array(
            'posting_status'            =>4,
            'updated_by'                =>$user_id,
        );

        $meetingInfo=Meeting::where('id',"=",$id)->update($update_data);

        if($meetingInfo)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }
    public function MeetingInbox(Request $request)
    {
 
        $company_id="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return 100; 
        }

        $user=\Auth::user(); 
        $user_id                        = $user->id; 
        $project_id                     = $user->project_id; 
        $ArrayFunction                  =new ArrayFunction();
        $user_type_arr                  =$ArrayFunction->user_type_arr; 
        $priority_level_arr             =$ArrayFunction->form_priority_level_arr;  

        $row_status                     =$ArrayFunction->row_status;
        $user_type_arr                  =$ArrayFunction->user_type_arr;
        $data['row_status']             =$row_status;
        $data['user_type_arr']          =$user_type_arr;
          
        $meeting_send_list              =Meeting::join('user_information_details', 'meetings.id', '=', 'user_information_details.master_id')
                                            ->where('meetings.project_id', '=', $project_id)
                                            ->where('meetings.company_id', '=', $company_id)
                                            ->whereIn('meetings.posting_status', [2,4])
                                            ->where('meetings.is_deleted', '=', 0)
                                            ->where('meetings.status_active', '=',1)
                                            ->where('user_information_details.is_deleted', '=', 0)
                                            ->where('user_information_details.status_active', '=',1)
                                            ->where('user_information_details.project_id', '=', $project_id)
                                            ->where('user_information_details.page_name', '=', "Meeting")
                                            ->where('user_information_details.user_id', '=', $user_id)
                                            ->where('user_information_details.mail_type', '=', 1)
                                            ->whereIn('user_information_details.status', [1,2])
                                            ->orderBy('meetings.updated_at','DESC')
                                            ->get();
                                            
       
        $data['meeting_send_list']=array(); $sl=0;
        foreach ($meeting_send_list as $key => $value) {

            // Extract only the 'name' values
            $data_participants_names = array_column($value->participants, 'name');

            // Convert the array to a comma-separated string
            $participants_names = implode(', ', $data_participants_names);

            $data['meeting_send_list'][$key]['sl']                     =$sl+1;
            $data['meeting_send_list'][$key]['key']                    =$key;
            $data['meeting_send_list'][$key]['id']                     =$value->id;
            $data['meeting_send_list'][$key]['master_id']              =$value->master_id;
            $data['meeting_send_list'][$key]['system_no']              =$value->system_no;
            $data['meeting_send_list'][$key]['meeting_time']           =date("h:i:s A",strtotime($value->meeting_time));
            $data['meeting_send_list'][$key]['meeting_date']           =date("D M d, Y",strtotime($value->meeting_date));
            $data['meeting_send_list'][$key]['posting_time']           =date("h:i:s A",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['posting_date']           =date("D M d, Y",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['meeting_send_list'][$key]['issued_by_id']           =$value->inserted_by;
            $data['meeting_send_list'][$key]['participants']           =$participants_names;
            $data['meeting_send_list'][$key]['priority']               =$value->priority;
            $data['meeting_send_list'][$key]['meeting_type_string']    =$value->meeting_type;
            $data['meeting_send_list'][$key]['notification_method']    =$value->notification_method;
            $data['meeting_send_list'][$key]['priority_string']        =$priority_level_arr[$value->priority];


            $data['meeting_send_list'][$key]['first_reminder_time']    =date("h:i:s A",strtotime($value->first_reminder_time));
            $data['meeting_send_list'][$key]['first_reminder_date']    =date("D M d, Y",strtotime($value->first_reminder_date));
            $data['meeting_send_list'][$key]['second_reminder_time']   =date("h:i:s A",strtotime($value->second_reminder_time));
            $data['meeting_send_list'][$key]['second_reminder_date']   =date("D M d, Y",strtotime($value->second_reminder_date));
            $data['meeting_send_list'][$key]['next_meeting_time']      =date("h:i:s A",strtotime($value->next_meeting_time));
            $data['meeting_send_list'][$key]['next_meeting_date']      =date("D M d, Y",strtotime($value->next_meeting_date));
            
            $data['meeting_send_list'][$key]['participant_comments']   =$value->participant_comments;
            $data['meeting_send_list'][$key]['is_confirm']             =$value->is_confirm;
            $data['meeting_send_list'][$key]['status']                 =$value->status;
            $data['meeting_send_list'][$key]['subject']                =$value->subject;
            $data['meeting_send_list'][$key]['title']                  =$value->title;
            $data['meeting_send_list'][$key]['comments']               =$value->comments;
            $data['meeting_send_list'][$key]['required_action']        =$value->required_action;
            $data['meeting_send_list'][$key]['location']               =$value->location;
            $data['meeting_send_list'][$key]['location_link']          =$value->location_link;
            $data['meeting_send_list'][$key]['read']                   =$value->read;
            $data['meeting_send_list'][$key]['checked']                =false;

            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['meeting_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['meeting_send_list'][$key]['photo_path']     ="";
            }

            if($value->file_id)
            {
                $data['meeting_send_list'][$key]['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['meeting_send_list'][$key]['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['meeting_send_list'][$key]['file_path']        ="";
                $data['meeting_send_list'][$key]['file_name']        ="";
            }

            $sl++;
        }
              

         return $data; 
    }

    public function meetingSent(Request $request)
    {
 
        $company_id="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return; 
        }

        $user=\Auth::user(); 
        $user_id                        = $user->id; 
        $project_id                     = $user->project_id; 
        $ArrayFunction                  =new ArrayFunction();
        $user_type_arr                  =$ArrayFunction->user_type_arr; 
        $priority_level_arr             =$ArrayFunction->form_priority_level_arr;  

        $row_status                     =$ArrayFunction->row_status;
        $user_type_arr                  =$ArrayFunction->user_type_arr;
        $data['row_status']             =$row_status;
        $data['user_type_arr']          =$user_type_arr;
        //$data['priority_level_arr']     =$priority_level_arr;
          
        $meeting_send_list              =Meeting::join('user_information_details', 'meetings.id', '=', 'user_information_details.master_id')
                                            ->where('meetings.project_id', '=', $project_id)
                                            ->where('meetings.company_id', '=', $company_id)
                                            ->whereIn('meetings.posting_status', [2,4])
                                            ->where('meetings.is_deleted', '=', 0)
                                            ->where('meetings.status_active', '=',1)
                                            ->where('user_information_details.is_deleted', '=', 0)
                                            ->where('user_information_details.status_active', '=',1)
                                            ->where('user_information_details.project_id', '=', $project_id)
                                            ->where('user_information_details.page_name', '=', "Meeting")
                                            ->where('user_information_details.mail_type', '=', 2)
                                            ->where('user_information_details.send_by', '=', $user_id)
                                            ->whereIn('user_information_details.status', [1,2])
                                            ->orderBy('meetings.updated_at','DESC')
                                            ->get();
              

        $data['meeting_send_list']=array(); $sl=0;
        foreach ($meeting_send_list as $key => $value) {

            // Extract only the 'name' values
            $data_participants_names = array_column($value->participants, 'name');

            // Convert the array to a comma-separated string
            $participants_names = implode(', ', $data_participants_names);

            $data['meeting_send_list'][$key]['sl']                     =$sl+1;
            $data['meeting_send_list'][$key]['key']                    =$key;
            $data['meeting_send_list'][$key]['id']                     =$value->id;
            $data['meeting_send_list'][$key]['master_id']              =$value->master_id;
            $data['meeting_send_list'][$key]['system_no']              =$value->system_no;
            $data['meeting_send_list'][$key]['meeting_time']           =date("h:i:s A",strtotime($value->meeting_time));
            $data['meeting_send_list'][$key]['meeting_date']           =date("D M d, Y",strtotime($value->meeting_date));
            $data['meeting_send_list'][$key]['posting_time']           =date("h:i:s A",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['posting_date']           =date("D M d, Y",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['meeting_send_list'][$key]['issued_by_id']           =$value->inserted_by;
            $data['meeting_send_list'][$key]['participants']           =$participants_names;
            $data['meeting_send_list'][$key]['priority']               =$value->priority;
            $data['meeting_send_list'][$key]['meeting_type_string']    =$value->meeting_type;
            $data['meeting_send_list'][$key]['notification_method']    =$value->notification_method;
            $data['meeting_send_list'][$key]['priority_string']        =$priority_level_arr[$value->priority];


            $data['meeting_send_list'][$key]['first_reminder_time']    =date("h:i:s A",strtotime($value->first_reminder_time));
            $data['meeting_send_list'][$key]['first_reminder_date']    =date("D M d, Y",strtotime($value->first_reminder_date));
            $data['meeting_send_list'][$key]['second_reminder_time']   =date("h:i:s A",strtotime($value->second_reminder_time));
            $data['meeting_send_list'][$key]['second_reminder_date']   =date("D M d, Y",strtotime($value->second_reminder_date));
            $data['meeting_send_list'][$key]['next_meeting_time']      =date("h:i:s A",strtotime($value->next_meeting_time));
            $data['meeting_send_list'][$key]['next_meeting_date']      =date("D M d, Y",strtotime($value->next_meeting_date));
            
            $data['meeting_send_list'][$key]['participant_comments']   =$value->participant_comments;
            $data['meeting_send_list'][$key]['is_confirm']             =$value->is_confirm;
            $data['meeting_send_list'][$key]['status']                 =$value->status;
            $data['meeting_send_list'][$key]['subject']                =$value->subject;
            $data['meeting_send_list'][$key]['title']                  =$value->title;
            $data['meeting_send_list'][$key]['comments']               =$value->comments;
            $data['meeting_send_list'][$key]['required_action']        =$value->required_action;
            $data['meeting_send_list'][$key]['location']               =$value->location;
            $data['meeting_send_list'][$key]['location_link']          =$value->location_link;
            $data['meeting_send_list'][$key]['read']                   =$value->read;
            $data['meeting_send_list'][$key]['checked']                =false;

            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['meeting_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['meeting_send_list'][$key]['photo_path']     ="";
            }

            if($value->file_id)
            {
                $data['meeting_send_list'][$key]['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['meeting_send_list'][$key]['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['meeting_send_list'][$key]['file_path']        ="";
                $data['meeting_send_list'][$key]['file_name']        ="";
            }

            $sl++;
        }
        return $data; 
    }

    public function meetingTrash(Request $request)
    {
 
        $company_id="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return 100; 
        }

        $user=\Auth::user(); 
        $user_id                        = $user->id; 
        $project_id                     = $user->project_id; 
        $ArrayFunction                  =new ArrayFunction();
        $user_type_arr                  =$ArrayFunction->user_type_arr; 
        $priority_level_arr             =$ArrayFunction->form_priority_level_arr;  

        $row_status                     =$ArrayFunction->row_status;
        $user_type_arr                  =$ArrayFunction->user_type_arr;
        $data['row_status']             =$row_status;
        $data['user_type_arr']          =$user_type_arr;
        //$data['priority_level_arr']     =$priority_level_arr;
          
        $meeting_send_list         =Meeting::join('user_information_details', 'meetings.id', '=', 'user_information_details.master_id')
                                            ->where('meetings.project_id', '=', $project_id)
                                            ->where('meetings.company_id', '=', $company_id)
                                            ->whereIn('meetings.posting_status', [2,4])
                                            ->where('meetings.is_deleted', '=', 0)
                                            ->where('meetings.status_active', '=',1)
                                            ->where('user_information_details.is_deleted', '=', 0)
                                            ->where('user_information_details.status_active', '=',1)
                                            ->where('user_information_details.project_id', '=', $project_id)
                                            ->where('user_information_details.page_name', '=', "Meeting")
                                            ->where('user_information_details.user_id', '=', $user_id)
                                            ->where('user_information_details.status',3 )
                                            ->where('user_information_details.trashed',1 )
                                            ->orderBy('meetings.updated_at','DESC')
                                            ->get();
              

        $data['meeting_send_list']=array(); $sl=0;
        foreach ($meeting_send_list as $key => $value) {

            // Extract only the 'name' values
            $data_participants_names = array_column($value->participants, 'name');

            // Convert the array to a comma-separated string
            $participants_names = implode(', ', $data_participants_names);

            $data['meeting_send_list'][$key]['sl']                     =$sl+1;
            $data['meeting_send_list'][$key]['key']                    =$key;
            $data['meeting_send_list'][$key]['id']                     =$value->id;
            $data['meeting_send_list'][$key]['master_id']              =$value->master_id;
            $data['meeting_send_list'][$key]['system_no']              =$value->system_no;
            $data['meeting_send_list'][$key]['meeting_time']           =date("h:i:s A",strtotime($value->meeting_time));
            $data['meeting_send_list'][$key]['meeting_date']           =date("D M d, Y",strtotime($value->meeting_date));
            $data['meeting_send_list'][$key]['posting_time']           =date("h:i:s A",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['posting_date']           =date("D M d, Y",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['meeting_send_list'][$key]['issued_by_id']           =$value->inserted_by;
            $data['meeting_send_list'][$key]['participants']           =$participants_names;
            $data['meeting_send_list'][$key]['priority']               =$value->priority;
            $data['meeting_send_list'][$key]['meeting_type_string']    =$value->meeting_type;
            $data['meeting_send_list'][$key]['notification_method']    =$value->notification_method;
            $data['meeting_send_list'][$key]['priority_string']        =$priority_level_arr[$value->priority];


            $data['meeting_send_list'][$key]['first_reminder_time']    =date("h:i:s A",strtotime($value->first_reminder_time));
            $data['meeting_send_list'][$key]['first_reminder_date']    =date("D M d, Y",strtotime($value->first_reminder_date));
            $data['meeting_send_list'][$key]['second_reminder_time']   =date("h:i:s A",strtotime($value->second_reminder_time));
            $data['meeting_send_list'][$key]['second_reminder_date']   =date("D M d, Y",strtotime($value->second_reminder_date));
            $data['meeting_send_list'][$key]['next_meeting_time']      =date("h:i:s A",strtotime($value->next_meeting_time));
            $data['meeting_send_list'][$key]['next_meeting_date']      =date("D M d, Y",strtotime($value->next_meeting_date));
            
            $data['meeting_send_list'][$key]['participant_comments']   =$value->participant_comments;
            $data['meeting_send_list'][$key]['is_confirm']             =$value->is_confirm;
            $data['meeting_send_list'][$key]['status']                 =$value->status;
            $data['meeting_send_list'][$key]['subject']                =$value->subject;
            $data['meeting_send_list'][$key]['title']                  =$value->title;
            $data['meeting_send_list'][$key]['comments']               =$value->comments;
            $data['meeting_send_list'][$key]['required_action']        =$value->required_action;
            $data['meeting_send_list'][$key]['location']               =$value->location;
            $data['meeting_send_list'][$key]['location_link']          =$value->location_link;
            $data['meeting_send_list'][$key]['read']                   =$value->read;
            $data['meeting_send_list'][$key]['checked']                =false;

            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['meeting_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['meeting_send_list'][$key]['photo_path']     ="";
            }

            if($value->file_id)
            {
                $data['meeting_send_list'][$key]['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['meeting_send_list'][$key]['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['meeting_send_list'][$key]['file_path']        ="";
                $data['meeting_send_list'][$key]['file_name']        ="";
            }

            $sl++;
        }
              

         return $data; 
    }


    public function MeetingFlag(Request $request)
    {
 
        $company_id="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return; 
        }

        $user=\Auth::user(); 
        $user_id                        = $user->id; 
        $project_id                     = $user->project_id; 
        $ArrayFunction                  =new ArrayFunction();
        $user_type_arr                  =$ArrayFunction->user_type_arr; 
        $priority_level_arr             =$ArrayFunction->form_priority_level_arr;  

        $row_status                     =$ArrayFunction->row_status;
        $user_type_arr                  =$ArrayFunction->user_type_arr;
        $data['row_status']             =$row_status;
        $data['user_type_arr']          =$user_type_arr;
        //$data['priority_level_arr']     =$priority_level_arr;
          
        $meeting_send_list         =Meeting::join('user_information_details', 'meetings.id', '=', 'user_information_details.master_id')
                                            ->where('meetings.project_id', '=', $project_id)
                                            ->where('meetings.company_id', '=', $company_id)
                                            ->whereIn('meetings.posting_status', [2,4])
                                            ->where('meetings.is_deleted', '=', 0)
                                            ->where('meetings.status_active', '=',1)
                                            ->where('user_information_details.is_deleted', '=', 0)
                                            ->where('user_information_details.status_active', '=',1)
                                            ->where('user_information_details.project_id', '=', $project_id)
                                            ->where('user_information_details.page_name', '=', "Meeting")
                                            ->where('user_information_details.user_id', '=', $user_id)
                                            ->where('user_information_details.status',4 )
                                            ->where('user_information_details.flagged',1 )
                                            ->orderBy('meetings.updated_at','DESC')
                                            ->get();
                                                
        $data['meeting_send_list']=array(); $sl=0;
        foreach ($meeting_send_list as $key => $value) {

            // Extract only the 'name' values
            $data_participants_names = array_column($value->participants, 'name');

            // Convert the array to a comma-separated string
            $participants_names = implode(', ', $data_participants_names);

            $data['meeting_send_list'][$key]['sl']                     =$sl+1;
            $data['meeting_send_list'][$key]['key']                    =$key;
            $data['meeting_send_list'][$key]['id']                     =$value->id;
            $data['meeting_send_list'][$key]['master_id']              =$value->master_id;
            $data['meeting_send_list'][$key]['system_no']              =$value->system_no;
            $data['meeting_send_list'][$key]['meeting_time']           =date("h:i:s A",strtotime($value->meeting_time));
            $data['meeting_send_list'][$key]['meeting_date']           =date("D M d, Y",strtotime($value->meeting_date));
            $data['meeting_send_list'][$key]['posting_time']           =date("h:i:s A",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['posting_date']           =date("D M d, Y",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['meeting_send_list'][$key]['issued_by_id']           =$value->inserted_by;
            $data['meeting_send_list'][$key]['participants']           =$participants_names;
            $data['meeting_send_list'][$key]['priority']               =$value->priority;
            $data['meeting_send_list'][$key]['meeting_type_string']    =$value->meeting_type;
            $data['meeting_send_list'][$key]['notification_method']    =$value->notification_method;
            $data['meeting_send_list'][$key]['priority_string']        =$priority_level_arr[$value->priority];


            $data['meeting_send_list'][$key]['first_reminder_time']    =date("h:i:s A",strtotime($value->first_reminder_time));
            $data['meeting_send_list'][$key]['first_reminder_date']    =date("D M d, Y",strtotime($value->first_reminder_date));
            $data['meeting_send_list'][$key]['second_reminder_time']   =date("h:i:s A",strtotime($value->second_reminder_time));
            $data['meeting_send_list'][$key]['second_reminder_date']   =date("D M d, Y",strtotime($value->second_reminder_date));
            $data['meeting_send_list'][$key]['next_meeting_time']      =date("h:i:s A",strtotime($value->next_meeting_time));
            $data['meeting_send_list'][$key]['next_meeting_date']      =date("D M d, Y",strtotime($value->next_meeting_date));
            
            $data['meeting_send_list'][$key]['participant_comments']   =$value->participant_comments;
            $data['meeting_send_list'][$key]['is_confirm']             =$value->is_confirm;
            $data['meeting_send_list'][$key]['status']                 =$value->status;
            $data['meeting_send_list'][$key]['subject']                =$value->subject;
            $data['meeting_send_list'][$key]['title']                  =$value->title;
            $data['meeting_send_list'][$key]['comments']               =$value->comments;
            $data['meeting_send_list'][$key]['required_action']        =$value->required_action;
            $data['meeting_send_list'][$key]['location']               =$value->location;
            $data['meeting_send_list'][$key]['location_link']          =$value->location_link;
            $data['meeting_send_list'][$key]['read']                   =$value->read;
            $data['meeting_send_list'][$key]['checked']                =false;

            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['meeting_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['meeting_send_list'][$key]['photo_path']     ="";
            }

            if($value->file_id)
            {
                $data['meeting_send_list'][$key]['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['meeting_send_list'][$key]['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['meeting_send_list'][$key]['file_path']        ="";
                $data['meeting_send_list'][$key]['file_name']        ="";
            }

            $sl++;
        }
              

         return $data; 
    }

    public function meetingRejected(Request $request)
    {
 
        $company_id="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return 100; 
        }

        $user=\Auth::user(); 
        $user_id                        = $user->id; 
        $project_id                     = $user->project_id; 
        $ArrayFunction                  =new ArrayFunction();
        $user_type_arr                  =$ArrayFunction->user_type_arr; 
        $priority_level_arr             =$ArrayFunction->form_priority_level_arr;  

        $row_status                     =$ArrayFunction->row_status;
        $user_type_arr                  =$ArrayFunction->user_type_arr;
        $data['row_status']             =$row_status;
        $data['user_type_arr']          =$user_type_arr;

        $meeting_send_list1             =Meeting::join('user_information_details', 'meetings.id', '=', 'user_information_details.master_id')
                                            ->where('meetings.project_id', '=', $project_id)
                                            ->where('meetings.company_id', '=', $company_id)
                                            ->whereIn('meetings.posting_status', [2,4])
                                            ->where('meetings.is_deleted', '=', 0)
                                            ->where('meetings.status_active', '=',1)
                                            ->where('user_information_details.is_deleted', '=', 0)
                                            ->where('user_information_details.status_active', '=',1)
                                            ->where('user_information_details.project_id', '=', $project_id)
                                            ->where('user_information_details.page_name', '=', "Meeting")
                                            ->where('user_information_details.send_by', '=', $user_id)
                                            ->where('user_information_details.mail_type', '=', 2)
                                            ->where('user_information_details.status',6 )
                                            ->where('user_information_details.reject',1 )
                                            ->orderBy('meetings.updated_at','DESC')
                                            ->get();
          
        $meeting_send_list              =Meeting::join('user_information_details', 'meetings.id', '=', 'user_information_details.master_id')
                                            ->where('meetings.project_id', '=', $project_id)
                                            ->where('meetings.company_id', '=', $company_id)
                                            ->whereIn('meetings.posting_status', [2,4])
                                            ->where('meetings.is_deleted', '=', 0)
                                            ->where('meetings.status_active', '=',1)
                                            ->where('user_information_details.is_deleted', '=', 0)
                                            ->where('user_information_details.status_active', '=',1)
                                            ->where('user_information_details.project_id', '=', $project_id)
                                            ->where('user_information_details.page_name', '=', "Meeting")
                                            ->where('user_information_details.user_id', '=', $user_id)
                                            ->where('user_information_details.mail_type', '=', 1)
                                            ->where('user_information_details.status',6 )
                                            ->where('user_information_details.reject',1 )
                                           // ->union($meeting_send_list1)
                                            ->orderBy('meetings.updated_at','DESC')
                                            ->get();

        
        $data['meeting_send_list']=array(); $sl=0;
        foreach ($meeting_send_list1 as $key => $value) {

            // Extract only the 'name' values
            $data_participants_names = array_column($value->participants, 'name');

            // Convert the array to a comma-separated string
            $participants_names = implode(', ', $data_participants_names);

            $data['meeting_send_list'][$key]['sl']                     =$sl+1;
            $data['meeting_send_list'][$key]['key']                    =$key;
            $data['meeting_send_list'][$key]['id']                     =$value->id;
            $data['meeting_send_list'][$key]['master_id']              =$value->master_id;
            $data['meeting_send_list'][$key]['system_no']              =$value->system_no;
            $data['meeting_send_list'][$key]['meeting_time']           =date("h:i:s A",strtotime($value->meeting_time));
            $data['meeting_send_list'][$key]['meeting_date']           =date("D M d, Y",strtotime($value->meeting_date));
            $data['meeting_send_list'][$key]['posting_time']           =date("h:i:s A",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['posting_date']           =date("D M d, Y",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['meeting_send_list'][$key]['issued_by_id']           =$value->inserted_by;
            $data['meeting_send_list'][$key]['participants']           =$participants_names;
            $data['meeting_send_list'][$key]['priority']               =$value->priority;
            $data['meeting_send_list'][$key]['meeting_type_string']    =$value->meeting_type;
            $data['meeting_send_list'][$key]['notification_method']    =$value->notification_method;
            $data['meeting_send_list'][$key]['priority_string']        =$priority_level_arr[$value->priority];


            $data['meeting_send_list'][$key]['first_reminder_time']    =date("h:i:s A",strtotime($value->first_reminder_time));
            $data['meeting_send_list'][$key]['first_reminder_date']    =date("D M d, Y",strtotime($value->first_reminder_date));
            $data['meeting_send_list'][$key]['second_reminder_time']   =date("h:i:s A",strtotime($value->second_reminder_time));
            $data['meeting_send_list'][$key]['second_reminder_date']   =date("D M d, Y",strtotime($value->second_reminder_date));
            $data['meeting_send_list'][$key]['next_meeting_time']      =date("h:i:s A",strtotime($value->next_meeting_time));
            $data['meeting_send_list'][$key]['next_meeting_date']      =date("D M d, Y",strtotime($value->next_meeting_date));
            
            $data['meeting_send_list'][$key]['participant_comments']   =$value->participant_comments;
            $data['meeting_send_list'][$key]['is_confirm']             =$value->is_confirm;
            $data['meeting_send_list'][$key]['status']                 =$value->status;
            $data['meeting_send_list'][$key]['subject']                =$value->subject;
            $data['meeting_send_list'][$key]['title']                  =$value->title;
            $data['meeting_send_list'][$key]['comments']               =$value->comments;
            $data['meeting_send_list'][$key]['required_action']        =$value->required_action;
            $data['meeting_send_list'][$key]['location']               =$value->location;
            $data['meeting_send_list'][$key]['location_link']          =$value->location_link;
            $data['meeting_send_list'][$key]['read']                   =$value->read;
            $data['meeting_send_list'][$key]['checked']                =false;

            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['meeting_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['meeting_send_list'][$key]['photo_path']     ="";
            }

            if($value->file_id)
            {
                $data['meeting_send_list'][$key]['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['meeting_send_list'][$key]['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['meeting_send_list'][$key]['file_path']        ="";
                $data['meeting_send_list'][$key]['file_name']        ="";
            }

            $sl++;
        }

        foreach ($meeting_send_list as $key => $value) {

            // Extract only the 'name' values
            $data_participants_names = array_column($value->participants, 'name');

            // Convert the array to a comma-separated string
            $participants_names = implode(', ', $data_participants_names);

            $data['meeting_send_list'][$key]['sl']                     =$sl+1;
            $data['meeting_send_list'][$key]['key']                    =$key;
            $data['meeting_send_list'][$key]['id']                     =$value->id;
            $data['meeting_send_list'][$key]['master_id']              =$value->master_id;
            $data['meeting_send_list'][$key]['system_no']              =$value->system_no;
            $data['meeting_send_list'][$key]['meeting_time']           =date("h:i:s A",strtotime($value->meeting_time));
            $data['meeting_send_list'][$key]['meeting_date']           =date("D M d, Y",strtotime($value->meeting_date));
            $data['meeting_send_list'][$key]['posting_time']           =date("h:i:s A",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['posting_date']           =date("D M d, Y",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['meeting_send_list'][$key]['issued_by_id']           =$value->inserted_by;
            $data['meeting_send_list'][$key]['participants']           =$participants_names;
            $data['meeting_send_list'][$key]['priority']               =$value->priority;
            $data['meeting_send_list'][$key]['meeting_type_string']    =$value->meeting_type;
            $data['meeting_send_list'][$key]['notification_method']    =$value->notification_method;
            $data['meeting_send_list'][$key]['priority_string']        =$priority_level_arr[$value->priority];


            $data['meeting_send_list'][$key]['first_reminder_time']    =date("h:i:s A",strtotime($value->first_reminder_time));
            $data['meeting_send_list'][$key]['first_reminder_date']    =date("D M d, Y",strtotime($value->first_reminder_date));
            $data['meeting_send_list'][$key]['second_reminder_time']   =date("h:i:s A",strtotime($value->second_reminder_time));
            $data['meeting_send_list'][$key]['second_reminder_date']   =date("D M d, Y",strtotime($value->second_reminder_date));
            $data['meeting_send_list'][$key]['next_meeting_time']      =date("h:i:s A",strtotime($value->next_meeting_time));
            $data['meeting_send_list'][$key]['next_meeting_date']      =date("D M d, Y",strtotime($value->next_meeting_date));
            
            $data['meeting_send_list'][$key]['participant_comments']   =$value->participant_comments;
            $data['meeting_send_list'][$key]['is_confirm']             =$value->is_confirm;
            $data['meeting_send_list'][$key]['status']                 =$value->status;
            $data['meeting_send_list'][$key]['subject']                =$value->subject;
            $data['meeting_send_list'][$key]['title']                  =$value->title;
            $data['meeting_send_list'][$key]['comments']               =$value->comments;
            $data['meeting_send_list'][$key]['required_action']        =$value->required_action;
            $data['meeting_send_list'][$key]['location']               =$value->location;
            $data['meeting_send_list'][$key]['location_link']          =$value->location_link;
            $data['meeting_send_list'][$key]['read']                   =$value->read;
            $data['meeting_send_list'][$key]['checked']                =false;

            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['meeting_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['meeting_send_list'][$key]['photo_path']     ="";
            }

            if($value->file_id)
            {
                $data['meeting_send_list'][$key]['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['meeting_send_list'][$key]['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['meeting_send_list'][$key]['file_path']        ="";
                $data['meeting_send_list'][$key]['file_name']        ="";
            }

            $sl++;
        }
              

         return $data; 
    }


    public function meetingBlock(Request $request)
    {
 
        $company_id="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return 100; 
        }
       
        $user=\Auth::user(); 
        $user_id                        = $user->id; 
        $project_id                     = $user->project_id; 
        $ArrayFunction                  =new ArrayFunction();
        $user_type_arr                  =$ArrayFunction->user_type_arr; 
        $priority_level_arr             =$ArrayFunction->form_priority_level_arr;  

        $row_status                     =$ArrayFunction->row_status;
        $user_type_arr                  =$ArrayFunction->user_type_arr;
        $data['row_status']             =$row_status;
        $data['user_type_arr']          =$user_type_arr;
          
        $meeting_block_list             =BlockUser::where('project_id', '=', $project_id)
                                            ->where('company_id', '=', $company_id)
                                            ->where('page_name','Meeting')
                                            ->where('is_deleted', '=', 0)
                                            ->where('status_active', '=',1)
                                            ->where('user_id', '=', $user_id)
                                            ->get();
                                         
       
        $data['meeting_block_list']=array(); $sl=0;
        foreach ($meeting_block_list as $key => $value) {    

            $data['meeting_block_list'][$key]['sl']                     =$sl+1;
            $data['meeting_block_list'][$key]['key']                    =$key;
            $data['meeting_block_list'][$key]['id']                     =$value->id;
            $data['meeting_block_list'][$key]['block_user_name']        =$value->userDetails->name;
            $data['meeting_block_list'][$key]['blocked_user_id']        =$value->userDetails->user_name;
            $data['meeting_block_list'][$key]['block_time']             =date("h:i:s A",strtotime($value->created_at));
            $data['meeting_block_list'][$key]['block_date']             =date("D M d, Y",strtotime($value->block_date));
            $data['meeting_block_list'][$key]['blocked_user']           =$value->blocked_user;  
            $data['meeting_block_list'][$key]['user_type']              =$user_type_arr[$value->userDetails->user_type];        
                   
            $data['meeting_block_list'][$key]['checked']                =false;
            if ($value->userDetails && $value->userDetails->image) {
                $userImagePath = $value->userDetails->image->image_name;
                $data['meeting_block_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['meeting_block_list'][$key]['photo_path']     ="";
            } 
                      
            
            $sl++;
        }
              

         return $data; 
    }

    public function meetingArchive(Request $request)
    {
 
        $company_id="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return; 
        }

        $user=\Auth::user(); 
        $user_id                        = $user->id; 
        $project_id                     = $user->project_id; 
        $ArrayFunction                  =new ArrayFunction();
        $user_type_arr                  =$ArrayFunction->user_type_arr; 
        $priority_level_arr             =$ArrayFunction->form_priority_level_arr;  

        $row_status                     =$ArrayFunction->row_status;
        $user_type_arr                  =$ArrayFunction->user_type_arr;
        $data['row_status']             =$row_status;
        $data['user_type_arr']          =$user_type_arr;
        //$data['priority_level_arr']     =$priority_level_arr;
          
        $meeting_send_list1              =Meeting::join('user_information_details', 'meetings.id', '=', 'user_information_details.master_id')
                                            ->where('meetings.project_id', '=', $project_id)
                                            ->where('meetings.company_id', '=', $company_id)
                                            ->whereIn('meetings.posting_status', [2,4])
                                            ->where('meetings.is_deleted', '=', 0)
                                            ->where('meetings.status_active', '=',1)
                                            ->where('user_information_details.is_deleted', '=', 0)
                                            ->where('user_information_details.status_active', '=',1)
                                            ->where('user_information_details.project_id', '=', $project_id)
                                            ->where('user_information_details.page_name', '=', "Meeting")
                                            ->where('user_information_details.send_by', '=', $user_id)
                                            ->where('user_information_details.mail_type', '=', 2)
                                            ->where('user_information_details.status',7 )
                                            ->where('user_information_details.archived',1 )
                                            ->orderBy('meetings.updated_at','DESC')
                                            ->get();

    $meeting_send_list                  =Meeting::join('user_information_details', 'meetings.id', '=', 'user_information_details.master_id')
                                            ->where('meetings.project_id', '=', $project_id)
                                            ->where('meetings.company_id', '=', $company_id)
                                            ->whereIn('meetings.posting_status', [2,4])
                                            ->where('meetings.is_deleted', '=', 0)
                                            ->where('meetings.status_active', '=',1)
                                            ->where('user_information_details.is_deleted', '=', 0)
                                            ->where('user_information_details.status_active', '=',1)
                                            ->where('user_information_details.project_id', '=', $project_id)
                                            ->where('user_information_details.page_name', '=', "Meeting")
                                            ->where('user_information_details.user_id', '=', $user_id)
                                            ->where('user_information_details.mail_type', '=', 1)
                                            ->where('user_information_details.status',7 )
                                            ->where('user_information_details.archived',1 )
                                            ->orderBy('meetings.updated_at','DESC')
                                            ->get();
              

        $data['meeting_send_list']=array(); $sl=0;
        foreach ($meeting_send_list1 as $key => $value) {

            // Extract only the 'name' values
            $data_participants_names = array_column($value->participants, 'name');

            // Convert the array to a comma-separated string
            $participants_names = implode(', ', $data_participants_names);

            $data['meeting_send_list'][$key]['sl']                     =$sl+1;
            $data['meeting_send_list'][$key]['key']                    =$key;
            $data['meeting_send_list'][$key]['id']                     =$value->id;
            $data['meeting_send_list'][$key]['master_id']              =$value->master_id;
            $data['meeting_send_list'][$key]['system_no']              =$value->system_no;
            $data['meeting_send_list'][$key]['meeting_time']           =date("h:i:s A",strtotime($value->meeting_time));
            $data['meeting_send_list'][$key]['meeting_date']           =date("D M d, Y",strtotime($value->meeting_date));
            $data['meeting_send_list'][$key]['posting_time']           =date("h:i:s A",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['posting_date']           =date("D M d, Y",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['meeting_send_list'][$key]['issued_by_id']           =$value->inserted_by;
            $data['meeting_send_list'][$key]['participants']           =$participants_names;
            $data['meeting_send_list'][$key]['priority']               =$value->priority;
            $data['meeting_send_list'][$key]['meeting_type_string']    =$value->meeting_type;
            $data['meeting_send_list'][$key]['notification_method']    =$value->notification_method;
            $data['meeting_send_list'][$key]['priority_string']        =$priority_level_arr[$value->priority];


            $data['meeting_send_list'][$key]['first_reminder_time']    =date("h:i:s A",strtotime($value->first_reminder_time));
            $data['meeting_send_list'][$key]['first_reminder_date']    =date("D M d, Y",strtotime($value->first_reminder_date));
            $data['meeting_send_list'][$key]['second_reminder_time']   =date("h:i:s A",strtotime($value->second_reminder_time));
            $data['meeting_send_list'][$key]['second_reminder_date']   =date("D M d, Y",strtotime($value->second_reminder_date));
            $data['meeting_send_list'][$key]['next_meeting_time']      =date("h:i:s A",strtotime($value->next_meeting_time));
            $data['meeting_send_list'][$key]['next_meeting_date']      =date("D M d, Y",strtotime($value->next_meeting_date));
            
            $data['meeting_send_list'][$key]['participant_comments']   =$value->participant_comments;
            $data['meeting_send_list'][$key]['is_confirm']             =$value->is_confirm;
            $data['meeting_send_list'][$key]['status']                 =$value->status;
            $data['meeting_send_list'][$key]['subject']                =$value->subject;
            $data['meeting_send_list'][$key]['title']                  =$value->title;
            $data['meeting_send_list'][$key]['comments']               =$value->comments;
            $data['meeting_send_list'][$key]['required_action']        =$value->required_action;
            $data['meeting_send_list'][$key]['location']               =$value->location;
            $data['meeting_send_list'][$key]['location_link']          =$value->location_link;
            $data['meeting_send_list'][$key]['read']                   =$value->read;
            $data['meeting_send_list'][$key]['checked']                =false;

            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['meeting_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['meeting_send_list'][$key]['photo_path']     ="";
            }

            if($value->file_id)
            {
                $data['meeting_send_list'][$key]['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['meeting_send_list'][$key]['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['meeting_send_list'][$key]['file_path']        ="";
                $data['meeting_send_list'][$key]['file_name']        ="";
            }

            $sl++;
        }
        foreach ($meeting_send_list as $key => $value) {

            // Extract only the 'name' values
            $data_participants_names = array_column($value->participants, 'name');

            // Convert the array to a comma-separated string
            $participants_names = implode(', ', $data_participants_names);

            $data['meeting_send_list'][$key]['sl']                     =$sl+1;
            $data['meeting_send_list'][$key]['key']                    =$key;
            $data['meeting_send_list'][$key]['id']                     =$value->id;
            $data['meeting_send_list'][$key]['master_id']              =$value->master_id;
            $data['meeting_send_list'][$key]['system_no']              =$value->system_no;
            $data['meeting_send_list'][$key]['meeting_time']           =date("h:i:s A",strtotime($value->meeting_time));
            $data['meeting_send_list'][$key]['meeting_date']           =date("D M d, Y",strtotime($value->meeting_date));
            $data['meeting_send_list'][$key]['posting_time']           =date("h:i:s A",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['posting_date']           =date("D M d, Y",strtotime($value->created_at));
            $data['meeting_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['meeting_send_list'][$key]['issued_by_id']           =$value->inserted_by;
            $data['meeting_send_list'][$key]['participants']           =$participants_names;
            $data['meeting_send_list'][$key]['priority']               =$value->priority;
            $data['meeting_send_list'][$key]['meeting_type_string']    =$value->meeting_type;
            $data['meeting_send_list'][$key]['notification_method']    =$value->notification_method;
            $data['meeting_send_list'][$key]['priority_string']        =$priority_level_arr[$value->priority];


            $data['meeting_send_list'][$key]['first_reminder_time']    =date("h:i:s A",strtotime($value->first_reminder_time));
            $data['meeting_send_list'][$key]['first_reminder_date']    =date("D M d, Y",strtotime($value->first_reminder_date));
            $data['meeting_send_list'][$key]['second_reminder_time']   =date("h:i:s A",strtotime($value->second_reminder_time));
            $data['meeting_send_list'][$key]['second_reminder_date']   =date("D M d, Y",strtotime($value->second_reminder_date));
            $data['meeting_send_list'][$key]['next_meeting_time']      =date("h:i:s A",strtotime($value->next_meeting_time));
            $data['meeting_send_list'][$key]['next_meeting_date']      =date("D M d, Y",strtotime($value->next_meeting_date));
            
            $data['meeting_send_list'][$key]['participant_comments']   =$value->participant_comments;
            $data['meeting_send_list'][$key]['is_confirm']             =$value->is_confirm;
            $data['meeting_send_list'][$key]['status']                 =$value->status;
            $data['meeting_send_list'][$key]['subject']                =$value->subject;
            $data['meeting_send_list'][$key]['title']                  =$value->title;
            $data['meeting_send_list'][$key]['comments']               =$value->comments;
            $data['meeting_send_list'][$key]['required_action']        =$value->required_action;
            $data['meeting_send_list'][$key]['location']               =$value->location;
            $data['meeting_send_list'][$key]['location_link']          =$value->location_link;
            $data['meeting_send_list'][$key]['read']                   =$value->read;
            $data['meeting_send_list'][$key]['checked']                =false;

            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['meeting_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['meeting_send_list'][$key]['photo_path']     ="";
            }

            if($value->file_id)
            {
                $data['meeting_send_list'][$key]['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['meeting_send_list'][$key]['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['meeting_send_list'][$key]['file_path']        ="";
                $data['meeting_send_list'][$key]['file_name']        ="";
            }

            $sl++;
        }
              

         return $data; 
    }

    public function statusChange(Request $request)
    {
        
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return 100; 
        }
       
        $block_date                =date("Y-m-d");
        
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;       

        DB::beginTransaction();
        $RId=true;
       
        
        if($request->type==8)
        {

            $update_data_block_user= array(
                        
                'status_active'             =>0,
                'is_deleted'                =>1,
                'updated_by'                =>$user_id,
            );


            $meetingInfo=BlockUser::where('user_id',"=",$user_id)
                                            ->where('blocked_user',"=",$request->blocked_user)
                                            ->where('page_name','Meeting')
                                            ->update($update_data_block_user);
                                           // dd($meetingInfo);
            //$meetingInfo=UserInformationDetails::where('id',"=",$request->id)->update($update_data);

            if($meetingInfo)
            {
                DB::commit();
                return "1**$request->id**";
            }
            else
            {
                DB::rollBack();
                return back()->withInput();
            }

        }
        else
        {
            if($request->type==2)
            {
                $update_data= array(
                    'read'                      =>1,
                    'updated_by'                =>$user_id,
                );

            }
            else if($request->type==3){
                $update_data= array(
                    'status'                    =>$request->type,
                    'trashed'                   =>1,
                    'flagged'                   =>0,
                    'reject'                    =>0,
                    'blocked'                   =>0,
                    'archived'                  =>0,
                    'updated_by'                =>$user_id,
                );
            }
            else if($request->type==4){
                $update_data= array(
                    'status'                    =>$request->type,
                    'trashed'                   =>0,
                    'flagged'                   =>1,
                    'blocked'                   =>0,
                    'reject'                    =>0,
                    'archived'                  =>0,
                    'updated_by'                =>$user_id,
                );
            }
            else if($request->type==5){
                $update_data= array(
                    'status'                    =>$request->type,
                    'trashed'                   =>0,
                    'flagged'                   =>0,  
                    'blocked'                   =>1,
                    'reject'                    =>0,
                    'archived'                  =>0,
                    'blocked_user'              =>$request->issued_by_id,
                    'updated_by'                =>$user_id,
                );

                $block_data= array(
                    'project_id'                =>$project_id,
                    'company_id'                =>$company_id,
                    'user_id'                   =>$user_id,  
                    'block_date'                =>$block_date,
                    'page_name'                 =>"Meeting",
                    'blocked_user'              =>$request->issued_by_id,
                    'inserted_by'               =>$user_id,
                );

                if(!empty($block_data))
                {
                    $RId=BlockUser::insert($block_data);
                }

            
            }
            else if($request->type==6){
                $update_data= array(
                    'status'                    =>$request->type,
                    'trashed'                   =>0,
                    'flagged'                   =>0,
                    'blocked'                   =>0,
                    'reject'                    =>1,
                    'archived'                  =>0,
                    'updated_by'                =>$user_id,
                );
            }
            else if($request->type==7){
                $update_data= array(
                    'status'                    =>$request->type,
                    'trashed'                   =>0,
                    'flagged'                   =>0,
                    'blocked'                   =>0,
                    'reject'                    =>0,
                    'archived'                  =>1,
                    'updated_by'                =>$user_id,
                );
            }
            
                            
            $meetingInfo=UserInformationDetails::where('id',"=",$request->id)->update($update_data);

            if($meetingInfo && $RId)
            {
                DB::commit();
                return "1**$request->id**";
            }
            else
            {
                DB::rollBack();
                return back()->withInput();
            }
            
        }
        
    }

    public function confirmation(Request $request)
    {
        //dd($request->all());
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return 100; 
        }
       
        $block_date                =date("Y-m-d");
        
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;  
        $send_user=UserInformationDetails::where('id',$request->id)->first();   

        DB::beginTransaction();       
            
        $update_data= array(
            'is_confirm'                =>$request->is_confirm,
            'participant_comments'      =>$request->participant_comments,
            'updated_by'                =>$user_id,
        );
                            
        $meetingInfo=UserInformationDetails::where('id',"=",$request->id)->update($update_data);
        $RID=UserInformationDetails::where('project_id',"=",$send_user->project_id)
                                    ->where('user_id',"=",$send_user->user_id)
                                    ->where('send_by',"=",$send_user->send_by)
                                    ->where('mail_type',"=",2)
                                    ->update($update_data);

        if($meetingInfo && $RID)
        {
            DB::commit();
            return "1**$request->id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
            
        
        
    }
}
