<?php

namespace App\Http\Controllers\Information;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\AnnouncementIssueTo;
use App\Models\Announcement;
use App\Models\UserInformationDetails;
use App\Models\AnnouncementParticipant;
use App\Models\User;
use App\Models\BlockUser;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user=\Auth::user();
        $project_id                         = $user->project_id;
        $user_id                            =$user->id;
        $user_name                          =$user->name;
        $ArrayFunction                      =new ArrayFunction();
        $announcement_status_arr            =$ArrayFunction->announcement_status_arr;
        $announcement_issue_to_arr          =array();

        foreach($ArrayFunction->announcement_issue_to_arr as $index=>$value)
        {
            $array=array();
            $array['id']=$index;
            $array['name']=$value;
            array_push($announcement_issue_to_arr,$array);
        }

       
        $participant_arr                    =array();

        foreach($ArrayFunction->participant_arr as $index=>$value)
        {
            $array=array();
            $array['id']=$index;
            $array['name']=$value;
            array_push($participant_arr,$array);
        }
        
        $data['announcement_status_arr']    =$announcement_status_arr; 
        $data['participant_arr']            =$participant_arr; 
        $data['announcement_issue_to_arr']  =$announcement_issue_to_arr;
        $data['issued_by']                  =$user_name;
        $data['issued_by_id']               =$user_id;
       // dd($data['announcement_issue_to_arr']);
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
           // $company_type=$request->session()->get('company_type');
        }
        else {

            return; 
        }

        $announcement_send_list=Announcement::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                       // ->where('inserted_by',"!=",$user_id)
                                       // ->whereIn('posting_status', [2, 4])
                                        ->get();


        $data['announcement_send_list']=array(); $sl=0;
        $total_announcement=0;
        foreach ($announcement_send_list as $key => $value) {

            $data['announcement_send_list'][$key]['sl']                     =$sl+1;
            $data['announcement_send_list'][$key]['id']                     =$value->id;
            $data['announcement_send_list'][$key]['system_no']              =$value->system_no;
            $data['announcement_send_list'][$key]['issue_date']             =date("Y-m-d",strtotime($value->issue_date));
            $data['announcement_send_list'][$key]['issue_time']             =date("h:i A",strtotime($value->issue_date));
            $data['announcement_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['announcement_send_list'][$key]['priority']               =$value->priority;
            $data['announcement_send_list'][$key]['status']                 =$value->status;
            $data['announcement_send_list'][$key]['status_string']          =$announcement_status_arr[$value->status];
            $data['announcement_send_list'][$key]['rejection_cause']        =$value->rejection_cause;                      
            $data['announcement_send_list'][$key]['subject']                =$value->subject;
            $data['announcement_send_list'][$key]['comments']               =$value->comments;
            $data['announcement_send_list'][$key]['required_action']        =$value->required_action;
            $data['announcement_send_list'][$key]['instruction']            =$value->instruction;
            $data['announcement_send_list'][$key]['posting_status']         =$value->posting_status;
            $sl++;

        }

        return $data;

    }

    public function AnnouncementList( Request $request)
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_id=$user->id;
        $ArrayFunction              =new ArrayFunction();
        $announcement_status_arr    =$ArrayFunction->announcement_status_arr;
        $data['announcement_status_arr']=$announcement_status_arr; 

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }

        $announcement_send_list=Announcement::where('is_deleted',0)
                                                ->where('project_id',$project_id)
                                                ->where('company_id',$company_id)
                                                ->where('inserted_by',$user_id)
                                                ->orderBy('system_no','desc')
                                                ->get();

        $data['announcement_send_list']=array(); $sl=0;
        foreach ($announcement_send_list as $key => $value) {

            $data['announcement_send_list'][$key]['sl']                     =$sl+1;
            $data['announcement_send_list'][$key]['id']                     =$value->id;
            $data['announcement_send_list'][$key]['system_no']              =$value->system_no;
            $data['announcement_send_list'][$key]['issue_date']             =date("D M d, Y",strtotime($value->issue_date));

            $data['announcement_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['announcement_send_list'][$key]['priority']               =$value->priority;
            $data['announcement_send_list'][$key]['status']                 =$value->status;
            $data['announcement_send_list'][$key]['status_string']          =$announcement_status_arr[$value->status];
            $data['announcement_send_list'][$key]['rejection_cause']        =$value->rejection_cause;
            $data['announcement_send_list'][$key]['expire_date']            =$value->expire_date;
            $data['announcement_send_list'][$key]['job_site']               =$value->job_site;            
            $data['announcement_send_list'][$key]['subject']                =$value->subject;
            $data['announcement_send_list'][$key]['details']                =$value->details;
           // $data['announcement_send_list'][$key]['dedline_date']           =$value->dedline_date;
            $data['announcement_send_list'][$key]['required_action']        =$value->required_action;
            $data['announcement_send_list'][$key]['instruction']            =$value->instruction;
            $data['announcement_send_list'][$key]['posting_status']         =$value->posting_status;

            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['announcement_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['announcement_send_list'][$key]['photo_path']     ="";
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
        $user_id=$user->id;
        $ArrayFunction              =new ArrayFunction();
        $announcement_status_arr    =$ArrayFunction->announcement_status_arr;
        $data['announcement_status_arr']=$announcement_status_arr; 

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }

        $announcement_list_sql=Announcement::where('is_deleted',0)
                                                ->where('project_id',$project_id)
                                                ->where('company_id',$company_id)
                                               // ->where('inserted_by',$user_id)
                                                ->orderBy('system_no','desc');
                                               // ->get();                                
        if($type==1)  
        {
            $announcement_list_sql->where('posting_status',0)->where('status_active',1);
        }
        else if($type==2)  
        {
            $announcement_list_sql->where('posting_status',0)->where('status_active',3);
        }
        else if($type==3)  
        {
            $announcement_list_sql->where('posting_status',1)->where('status_active',1);
        }
        else if($type==4)  
        {
            $announcement_list_sql->where('posting_status',1)->where('status_active',2);
        }
        else if($type==5)  
        {
            $announcement_list_sql->where('posting_status',2)->where('status_active',1);
        }
        else if($type==6)  
        {
            $announcement_list_sql->where('posting_status',3)->where('status_active',1);
        }
        else if($type==7)  
        {
            $announcement_list_sql->where('posting_status',4)->where('status_active',1);
        }

        $announcement_send_list=$announcement_list_sql->get();

        $data['announcement_send_list']=array(); $sl=0;
        foreach ($announcement_send_list as $key => $value) {

            $data['announcement_send_list'][$key]['sl']                     =$sl+1;
            $data['announcement_send_list'][$key]['id']                     =$value->id;
            $data['announcement_send_list'][$key]['system_no']              =$value->system_no;
            $data['announcement_send_list'][$key]['issue_date']             =date("D M d, Y",strtotime($value->issue_date));

            $data['announcement_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['announcement_send_list'][$key]['priority']               =$value->priority;
            $data['announcement_send_list'][$key]['status']                 =$value->status;
            $data['announcement_send_list'][$key]['status_string']          =$announcement_status_arr[$value->status];
            $data['announcement_send_list'][$key]['rejection_cause']        =$value->rejection_cause;
            $data['announcement_send_list'][$key]['expire_date']            =$value->expire_date;
            $data['announcement_send_list'][$key]['job_site']               =$value->job_site;            
            $data['announcement_send_list'][$key]['subject']                =$value->subject;
            $data['announcement_send_list'][$key]['details']                =$value->details;
           // $data['announcement_send_list'][$key]['dedline_date']           =$value->dedline_date;
            $data['announcement_send_list'][$key]['required_action']        =$value->required_action;
            $data['announcement_send_list'][$key]['instruction']            =$value->instruction;
            $data['announcement_send_list'][$key]['posting_status']         =$value->posting_status;

            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['announcement_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['announcement_send_list'][$key]['photo_path']     ="";
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
        $announcement_send_list=Announcement::where('is_deleted',0)
                                                ->where('project_id',$project_id)
                                                ->where('company_id',$company_id)
                                                //->where('inserted_by',$user_id)
                                                ->orderBy('system_no','desc')
                                                ->get();


        $data['announcement_list']['saved']       =0;
        $data['announcement_list']['transmit_out']=0;
        $data['announcement_list']['rejected']    =0;
        $data['announcement_list']['voided']      =0;
        $data['announcement_list']['posted']      =0;
        $data['announcement_list']['adjusted']    =0;
        $data['announcement_list']['reposted']    =0;
        foreach ($announcement_send_list as $key => $value) {
            if($value->posting_status==0)
            {
                if ($value->status_active==1)
                    $data['announcement_list']['saved']++;
                else if ($value->status_active==3)
                    $data['announcement_list']['rejected']++;
            }
            if($value->posting_status==1)
            {
                if ($value->status_active==1)
                    $data['announcement_list']['transmit_out']++;
                else if ($value->status_active==2)
                    $data['announcement_list']['voided']++;
            }
            else if ($value->posting_status==2)
            {
                $data['announcement_list']['posted']++;
            }
            else if ($value->posting_status==3)
            {
                $data['announcement_list']['adjusted']++;
            }
            else if ($value->posting_status==4)
            {
                $data['announcement_list']['reposted']++;
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
        request()->validate([
            'subject'               => 'required',
            'issued_by'               => 'required',
            'issue_date'                => 'required',
            'issue_time'                => 'required',
            'location'                 => 'required',
            'issue_to'                 => 'required',
            'participants'                 => 'required',
            'priority'                  => 'required',
            'required_action'           => 'required',
            'instruction'               => 'required',
            
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;

       

        if($request->input('issue_date'))
        {

            $issue_date_time                 =date("Y-m-d",strtotime($request->input('issue_date')));
        
            $request->merge(['issue_date'    =>$issue_date_time]);
        }

        if($request->input('issue_time'))
        {
            $issue_time                           =date("H:i:s",strtotime($request->input('issue_time')));
            $request->merge(['issue_time'         =>$issue_time]);
        }
        else{
            $request->merge(['issue_time'         =>""]);
        }
       // dd($request->input('issue_time'));
        
        //        $issueDate = Carbon::createFromFormat('h:i:s A', $request->issue_date)->format('H:i:s');
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['posting_status' =>0]);


        $company_id="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return; 
        }
        
        $request->merge(['company_id' =>$company_id]);
       // $request->merge(['issue_to' =>json_encode(array_keys($request->input('issue_to')))]);
       // $request->merge(['participants' =>json_encode(array_keys($request->input('participants')))]);
        

        $year= date("y",strtotime($request->input('issue_date')));
        $year_full= date("Y",strtotime($request->input('issue_date')));
        $max_system_data = Announcement::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from announcements 
            where project_id=".$project_id." and Year(issue_date)=".$year_full." and company_id=".$company_id.") 
             and company_id=".$company_id." and Year(issue_date)=".$year_full."  and project_id=".$project_id)->get(['system_prefix']);
          
       
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }
        
        $system_no="ANN-".$year."-".str_pad($max_system_prefix, 5, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $announcement_info= Announcement::create($request->all());

        foreach($request->issue_to as $key=>$details)
        {
           

                $data_issue_to[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$announcement_info->id,
                    'item_id'                   =>$details['id'],
                    'item_name'                 =>$details['name'],
                    'inserted_by'               =>$user_id,
                );
            
        }

        foreach($request->participants as $key=>$details)
        {
           

                $data_particiapant[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$announcement_info->id,
                    'item_id'                   =>$details['id'],
                    'item_name'                 =>$details['name'],
                    'inserted_by'               =>$user_id,
                );
            
        }

        //dd($data_particiapant);
        $RId1=true;
        $RId2=true;

        if(!empty($data_issue_to))
        {
            $RId1=AnnouncementIssueTo::insert($data_issue_to);
        }
        if(!empty($data_particiapant))
        {
            $RId2=AnnouncementParticipant::insert($data_particiapant);
        }
        if($announcement_info && $RId1 && $RId2)
        {
           DB::commit();
           return "1**$announcement_info->id**$system_no";
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
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_id                    =$user->id;
        $ArrayFunction              =new ArrayFunction();
        $announcement_status_arr    =$ArrayFunction->announcement_status_arr;
        $data['announcement_status_arr']=$announcement_status_arr; 
        $user_type                  = $user->user_type;
        $data['user_type']          =$user_type;

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }

        $announcement_send_list=Announcement::where('is_deleted',0)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('id',"=",$id)
                                        ->get();


        $data['announcement_send_list']=array(); $sl=0;
        $total_announcement=0;
        foreach ($announcement_send_list as $key => $value) {
                
            $data['announcement_send_list']['sl']                     =$sl+1;
            $data['announcement_send_list']['id']                     =$value->id;
            $data['announcement_send_list']['system_no']              =$value->system_no;
            $data['announcement_send_list']['issue_date']             =date("Y m d",strtotime($value->issue_date));
            $data['announcement_send_list']['issue_time']             =$value->issue_time;
            $data['announcement_send_list']['issued_by']              =$value->issued_by;
            $data['announcement_send_list']['issued_by_id']           =$value->issued_by_id;
            $data['announcement_send_list']['issue_to']               =$value->issue_to;
            $data['announcement_send_list']['participants']           =$value->participants;
            $data['announcement_send_list']['priority']               =$value->priority;
            $data['announcement_send_list']['status']                 =$value->status;
            $data['announcement_send_list']['rejection_cause']        =$value->rejection_cause;             
            $data['announcement_send_list']['subject']                =$value->subject;
            $data['announcement_send_list']['location']               =$value->location;
            $data['announcement_send_list']['comments']               =$value->comments;
            $data['announcement_send_list']['required_action']        =$value->required_action;
            $data['announcement_send_list']['instruction']            =$value->instruction;
            $data['announcement_send_list']['financial']              =$value->financial;
            $data['announcement_send_list']['safety_tips']            =$value->safety_tips;
            $data['announcement_send_list']['posting_status']         =$value->posting_status;
            $data['announcement_send_list']['file_id']                =$value->file_id;

            

            if($value->file_id)
            {
                $data['announcement_send_list']['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['announcement_send_list']['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['announcement_send_list']['file_path']        ="";
                $data['announcement_send_list']['file_name']        ="";
            }


            $data['announcement_send_list']['posting_time']         =date("h:i:s A",strtotime($value->updated_at));
            $data['announcement_send_list']['posting_date']         =date("D M d, Y",strtotime($value->updated_at));


            if($value->posting_status==0)
            {
                if ($value->status_active==1)
                    $data['announcement_send_list']['posting_status_string']="Saved";
                else if ($value->status_active==3)
                    $data['announcement_send_list']['posting_status_string']='Rejected';
            }
            if($value->posting_status==1)
            {
                if ($value->status_active==1)
                    $data['announcement_send_list']['posting_status_string']='Transmit Out';
                else if ($value->status_active==2)
                    $data['announcement_send_list']['posting_status_string']='Voided';
            }
            else if ($value->posting_status==2)
            {
                $data['announcement_send_list']['posting_status_string']='Posted';
            }
            else if ($value->posting_status==3)
            {
                $data['announcement_send_list']['posting_status_string']='Adjusted';
            }
            else if ($value->posting_status==4)
            {
                $data['announcement_send_list']['posting_status_string']='Reposted';
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
        request()->validate([
            'subject'               => 'required',
            'issued_by'               => 'required',
            'issue_date'                => 'required',
            'issue_time'                => 'required',
            'location'                 => 'required',
            'issue_to'                 => 'required',
            'participants'                 => 'required',
            'priority'                  => 'required',
            'required_action'           => 'required',
            'instruction'               => 'required',    
            
        ]);
       
        //dd($request->all());
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        

        if($request->input('issue_date'))
        {           
            $issue_date_time                 =date("Y-m-d ",(strtotime($request->input('issue_date'))));       
            $request->merge(['issue_date'    =>$issue_date_time]);
        }

        if($request->input('issue_time'))
        {
            $issue_time                           =date("H:i:s",strtotime($request->input('issue_time')));
            $request->merge(['issue_time'         =>$issue_time]);
        }
        else{
            $request->merge(['issue_time'         =>""]);
        }

        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['updated_by'           =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);


        $company_id="";
        $company_type="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return; 
        }


       // $request->merge(['company_id' =>$company_id]);

        DB::beginTransaction();
        $announcement_info= Announcement::find($id)->update($request->all());
        $update_data= array(
                        
            'status_active'             =>0,
            'is_deleted'                =>1,
            'updated_by'                =>$user_id,
        );

        $assign_to_delete=AnnouncementIssueTo::where('master_id',"=",$id)->update($update_data);
        $participant_delete=AnnouncementParticipant::where('master_id',"=",$id)->update($update_data);
        foreach($request->issue_to as $key=>$details)
        {
           
                $data_issue_to[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$id,
                    'item_id'                   =>$details['id'],
                    'item_name'                 =>$details['name'],
                    'inserted_by'               =>$user_id,
                );
            
        }

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
        $RId2=true;

        if(!empty($data_issue_to))
        {
            $RId1=AnnouncementIssueTo::insert($data_issue_to);
        }
        if(!empty($data_particiapant))
        {
            $RId2=AnnouncementParticipant::insert($data_particiapant);
        }
       

        if($announcement_info && $assign_to_delete && $participant_delete && $RId1 && $RId2)
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
        $announcement_info= Announcement::find($id)->update(['updated_by'=>$user_id,'status_active'=>0,'is_deleted'=>1]);       

        $update_data= array(
                        
                            'status_active'             =>0,
                            'is_deleted'                =>1,
                            'updated_by'                =>$user_id,
                        );

        $assign_to_delete=AnnouncementIssueTo::where('master_id',"=",$id)->update($update_data);
        $participant_delete=AnnouncementParticipant::where('master_id',"=",$id)->update($update_data);
                       
        if($announcement_info && $assign_to_delete && $participant_delete)
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
      
        $announcementInfo=Announcement::where('id',"=",$id)->update($update_data);

        if($announcementInfo)
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
      
        $announcementInfo=Announcement::where('id',"=",$id)->update($update_data);

        

        foreach($all_user_data as $key=>$details)
        {
                $data_user_ann[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$id,
                    'mail_type'                 =>1,
                    'send_by'                   =>$user_id,
                    'user_id'                   =>$details['id'],
                    'page_name'                 =>"Announcement",
                    'inserted_by'               =>$user_id,
                );
            
        }

        $data_user_ann[]= array(
            'project_id'                =>$project_id,
            'master_id'                 =>$id,
            'mail_type'                 =>2,
            'send_by'                   =>$user_id,
            'user_id'                   =>$user_id,
            'page_name'                 =>"Announcement",
            'inserted_by'               =>$user_id,
        );


        $RId1=true;

        if(!empty($data_user_ann))
        {
            $RId1=UserInformationDetails::insert($data_user_ann);
        }
        
        if($announcementInfo)
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
      
        $announcementInfo=Announcement::where('id',"=",$id)->update($update_data);

        if($announcementInfo)
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
            return; 
        }

        request()->validate([
            'subject'               => 'required',
            'issued_by'               => 'required',
            'issue_date'                => 'required',
            'issue_time'                => 'required',
            'location'                 => 'required',
            'issue_to'                 => 'required',
            'participants'                 => 'required',
            'priority'                  => 'required',
            'required_action'           => 'required',
            'instruction'               => 'required',          
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id'      =>$user_id]);
        $request->merge(['updated_by'   =>$user_id]);
        $request->merge(['project_id'   =>$project_id]);
        $request->merge(['posting_status'=>3]);
        $request->merge(['status_active'=>1]);
        if($request->input('issue_date'))
        {           
            $issue_date_time                 =date("Y-m-d ",(strtotime($request->input('issue_date'))));       
            $request->merge(['issue_date'    =>$issue_date_time]);
        }

        if($request->input('issue_time'))
        {
            $issue_time                           =date("H:i:s",strtotime($request->input('issue_time')));
            $request->merge(['issue_time'         =>$issue_time]);
        }
        else{
            $request->merge(['issue_time'         =>""]);
        }
     
        DB::beginTransaction();
        $announcement_info= Announcement::find($id)->update($request->all());
        $update_data= array(
                        
            'status_active'             =>0,
            'is_deleted'                =>1,
            'updated_by'                =>$user_id,
        );

        $assign_to_delete=AnnouncementIssueTo::where('master_id',"=",$id)->update($update_data);
        $participant_delete=AnnouncementParticipant::where('master_id',"=",$id)->update($update_data);
        foreach($request->issue_to as $key=>$details)
        {
           
            $data_issue_to[]= array(
                'project_id'                =>$project_id,
                'master_id'                 =>$id,
                'item_id'                   =>$details['id'],
                'item_name'                 =>$details['name'],
                'inserted_by'               =>$user_id,
            );
            
        }

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
        $RId2=true;

        if(!empty($data_issue_to))
        {
            $RId1=AnnouncementIssueTo::insert($data_issue_to);
        }
        if(!empty($data_particiapant))
        {
            $RId2=AnnouncementParticipant::insert($data_particiapant);
        }
       
        if($announcement_info && $assign_to_delete && $participant_delete && $RId1 && $RId2)
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
        

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;       

        DB::beginTransaction();

        $update_data= array(
                            'posting_status'            =>4,
                            'updated_by'                =>$user_id,
                        );
      
        $announcementInfo=Announcement::where('id',"=",$id)->update($update_data);

        if($announcementInfo)
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
    public function AnnouncementInbox(Request $request)
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
          
        $announcement_send_list         =Announcement::join('user_information_details', 'announcements.id', '=', 'user_information_details.master_id')
                                            ->where('announcements.project_id', '=', $project_id)
                                            ->where('announcements.company_id', '=', $company_id)
                                            ->whereIn('announcements.posting_status', [2,4])
                                            ->where('announcements.is_deleted', '=', 0)
                                            ->where('announcements.status_active', '=',1)
                                            ->where('user_information_details.is_deleted', '=', 0)
                                            ->where('user_information_details.status_active', '=',1)
                                            ->where('user_information_details.project_id', '=', $project_id)
                                            ->where('user_information_details.page_name', '=', "Announcement")
                                            ->where('user_information_details.user_id', '=', $user_id)
                                            ->where('user_information_details.mail_type', '=', 1)
                                            ->whereIn('user_information_details.status', [1,2])
                                            ->orderBy('announcements.updated_at','DESC')
                                            ->get();
                                            //  ->get([
                                            //         'user_information_details.*',
                                            //         'announcements.system_no',
                                            //         'announcements.issue_date',
                                            //         'announcements.issue_time',
                                            //         'announcements.issued_by',
                                            //         'announcements.priority',
                                            //         'announcements.issue_to',
                                            //         'announcements.participants',
                                            //         'announcements.location',
                                            //         'announcements.subject',
                                            //         'announcements.financial',
                                            //         'announcements.safety_tips',
                                            //         'announcements.required_action',
                                            //         'announcements.instruction',
                                            //         'announcements.posting_status',
                                            //         'announcements.archived',
                                            //         'announcements.comments'
                                            //     ]);
              
                                              // dd($announcement_send_list);
       
        $data['announcement_send_list']=array(); $sl=0;
        foreach ($announcement_send_list as $key => $value) {
            
           // $data_issue_to = json_decode($value->issue_to, true);
          
            // Extract only the 'name' values
            $data_issue_to_names = array_column($value->issue_to, 'name');

            // Convert the array to a comma-separated string
            $data_issue_to = implode(', ', $data_issue_to_names);
           
           // $data_participants= json_decode($value->participants, true);

            // Extract only the 'name' values
            $data_participants_names = array_column($value->participants, 'name');

            // Convert the array to a comma-separated string
            $participants_names = implode(', ', $data_participants_names);

            $data['announcement_send_list'][$key]['sl']                     =$sl+1;
            $data['announcement_send_list'][$key]['key']                    =$key;
            $data['announcement_send_list'][$key]['id']                     =$value->id;
            $data['announcement_send_list'][$key]['master_id']              =$value->master_id;
            $data['announcement_send_list'][$key]['system_no']              =$value->system_no;
            $data['announcement_send_list'][$key]['issue_time']             =date("h:i:s A",strtotime($value->issue_time));
            $data['announcement_send_list'][$key]['issue_date']             =date("D M d, Y",strtotime($value->issue_date));
            $data['announcement_send_list'][$key]['posting_time']           =date("h:i:s A",strtotime($value->created_at));
            $data['announcement_send_list'][$key]['posting_date']           =date("D M d, Y",strtotime($value->created_at));
            $data['announcement_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['announcement_send_list'][$key]['issued_by_id']           =$value->inserted_by;
            $data['announcement_send_list'][$key]['issue_to']               =$data_issue_to;
            $data['announcement_send_list'][$key]['participants']           =$participants_names;
            $data['announcement_send_list'][$key]['priority']               =$value->priority;
            $data['announcement_send_list'][$key]['priority_string']        =$priority_level_arr[$value->priority];
            
            $data['announcement_send_list'][$key]['status']                 =$value->status;
            $data['announcement_send_list'][$key]['subject']                =$value->subject;
            $data['announcement_send_list'][$key]['comments']               =$value->comments;
            $data['announcement_send_list'][$key]['required_action']        =$value->required_action;
            $data['announcement_send_list'][$key]['instruction']            =$value->instruction;
            $data['announcement_send_list'][$key]['financial']              =$value->financial;
            $data['announcement_send_list'][$key]['safety_tips']            =$value->instruction;
            $data['announcement_send_list'][$key]['posting_status']         =$value->posting_status;
            $data['announcement_send_list'][$key]['read']                   =$value->read;
            $data['announcement_send_list'][$key]['checked']                =false;

            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['announcement_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['announcement_send_list'][$key]['photo_path']     ="";
            }

            if($value->file_id)
            {
                $data['announcement_send_list'][$key]['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['announcement_send_list'][$key]['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['announcement_send_list'][$key]['file_path']        ="";
                $data['announcement_send_list'][$key]['file_name']        ="";
            }
            $data['announcement_send_list'][$key]['announcement']           =array(

                                    "issue_time"        =>date("h:i:s A",strtotime($value->issue_time)),
                                    'issue_date'        =>date("D M d, Y",strtotime($value->issue_date)),
                                    'posting_time'      =>date("h:i:s A",strtotime($value->created_at)),
                                    'posting_date'      =>date("D M d, Y",strtotime($value->created_at)),
                                    "subject"           =>$value->subject,
                                    'required_action'   => substr($value->required_action, 0, 150),
                                    'financial'         =>$value->financial,
                                    'instruction'       =>$value->instruction,
                                    'safety_tips'       =>$value->safety_tips,
                                    'issued_by'         =>$value->issued_by,
                                    'comments'          =>$value->comments );

            $sl++;
        }
              

         return $data; 
    }

    public function AnnouncementSent(Request $request)
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
          
        $announcement_send_list         =Announcement::join('user_information_details', 'announcements.id', '=', 'user_information_details.master_id')
                                            ->where('announcements.project_id', '=', $project_id)
                                            ->where('announcements.company_id', '=', $company_id)
                                            ->whereIn('announcements.posting_status', [2,4])
                                            ->where('announcements.is_deleted', '=', 0)
                                            ->where('announcements.status_active', '=',1)
                                            ->where('user_information_details.is_deleted', '=', 0)
                                            ->where('user_information_details.status_active', '=',1)
                                            ->where('user_information_details.project_id', '=', $project_id)
                                            ->where('user_information_details.page_name', '=', "Announcement")
                                            ->where('user_information_details.mail_type', '=', 2)
                                            ->where('user_information_details.send_by', '=', $user_id)
                                            ->whereIn('user_information_details.status', [1,2])
                                            ->orderBy('announcements.updated_at','DESC')
                                            ->get();
              

        $data['announcement_send_list']=array(); $sl=0;
        foreach ($announcement_send_list as $key => $value) {

            // $data_issue_to = json_decode($value->issue_to, true);
          
            // Extract only the 'name' values
            $data_issue_to_names = array_column($value->issue_to, 'name');

            // Convert the array to a comma-separated string
            $data_issue_to = implode(', ', $data_issue_to_names);
           
           // $data_participants= json_decode($value->participants, true);

            // Extract only the 'name' values
            $data_participants_names = array_column($value->participants, 'name');

            // Convert the array to a comma-separated string
            $participants_names = implode(', ', $data_participants_names);

            $data['announcement_send_list'][$key]['sl']                     =$sl+1;
            $data['announcement_send_list'][$key]['key']                    =$key;
            $data['announcement_send_list'][$key]['id']                     =$value->id;
            $data['announcement_send_list'][$key]['master_id']              =$value->master_id;
            $data['announcement_send_list'][$key]['system_no']              =$value->system_no;
            $data['announcement_send_list'][$key]['issue_time']             =date("h:i:s A",strtotime($value->issue_time));
            $data['announcement_send_list'][$key]['issue_date']             =date("D M d, Y",strtotime($value->issue_date));
            $data['announcement_send_list'][$key]['posting_time']           =date("h:i:s A",strtotime($value->created_at));
            $data['announcement_send_list'][$key]['posting_date']           =date("D M d, Y",strtotime($value->created_at));
            $data['announcement_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['announcement_send_list'][$key]['issued_by_id']           =$value->inserted_by;
            $data['announcement_send_list'][$key]['issue_to']               =$data_issue_to;
            $data['announcement_send_list'][$key]['participants']           =$participants_names;
            $data['announcement_send_list'][$key]['priority']               =$value->priority;
            $data['announcement_send_list'][$key]['priority_string']        =$priority_level_arr[$value->priority];
            
            $data['announcement_send_list'][$key]['status']                 =$value->status;
            $data['announcement_send_list'][$key]['subject']                =$value->subject;
            $data['announcement_send_list'][$key]['comments']               =$value->comments;
            $data['announcement_send_list'][$key]['required_action']        =$value->required_action;
            $data['announcement_send_list'][$key]['instruction']            =$value->instruction;
            $data['announcement_send_list'][$key]['financial']              =$value->financial;
            $data['announcement_send_list'][$key]['safety_tips']            =$value->instruction;
            $data['announcement_send_list'][$key]['posting_status']         =$value->posting_status;
            $data['announcement_send_list'][$key]['read']                   =$value->read;
            $data['announcement_send_list'][$key]['checked']                =false;
            
            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['announcement_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['announcement_send_list'][$key]['photo_path']     ="";
            }


            if($value->file_id)
            {
                $data['announcement_send_list'][$key]['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['announcement_send_list'][$key]['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['announcement_send_list'][$key]['file_path']        ="";
                $data['announcement_send_list'][$key]['file_name']        ="";
            }

            $data['announcement_send_list'][$key]['announcement']           =array(

                                    "issue_time"        =>date("h:i:s A",strtotime($value->issue_time)),
                                    'issue_date'        =>date("D M d, Y",strtotime($value->issue_date)),
                                    'posting_time'      =>date("h:i:s A",strtotime($value->created_at)),
                                    'posting_date'      =>date("D M d, Y",strtotime($value->created_at)),
                                    "subject"           =>$value->subject,
                                    'required_action'   => substr($value->required_action, 0, 150),
                                    'financial'         =>$value->financial,
                                    'instruction'       =>$value->instruction,
                                    'safety_tips'       =>$value->safety_tips,
                                    'issued_by'         =>$value->issued_by,
                                    'comments'          =>$value->comments );

            $sl++;
        }
              

         return $data; 
    }

    public function AnnouncementTrash(Request $request)
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
          
        $announcement_send_list         =Announcement::join('user_information_details', 'announcements.id', '=', 'user_information_details.master_id')
                                            ->where('announcements.project_id', '=', $project_id)
                                            ->where('announcements.company_id', '=', $company_id)
                                            ->whereIn('announcements.posting_status', [2,4])
                                            ->where('announcements.is_deleted', '=', 0)
                                            ->where('announcements.status_active', '=',1)
                                            ->where('user_information_details.is_deleted', '=', 0)
                                            ->where('user_information_details.status_active', '=',1)
                                            ->where('user_information_details.project_id', '=', $project_id)
                                            ->where('user_information_details.page_name', '=', "Announcement")
                                            ->where('user_information_details.user_id', '=', $user_id)
                                            ->where('user_information_details.status',3 )
                                            ->where('user_information_details.trashed',1 )
                                            ->orderBy('announcements.updated_at','DESC')
                                            ->get();
              

        $data['announcement_send_list']=array(); $sl=0;
        foreach ($announcement_send_list as $key => $value) {

            // $data_issue_to = json_decode($value->issue_to, true);
          
            // Extract only the 'name' values
            $data_issue_to_names = array_column($value->issue_to, 'name');

            // Convert the array to a comma-separated string
            $data_issue_to = implode(', ', $data_issue_to_names);
           
           // $data_participants= json_decode($value->participants, true);

            // Extract only the 'name' values
            $data_participants_names = array_column($value->participants, 'name');

            // Convert the array to a comma-separated string
            $participants_names = implode(', ', $data_participants_names);

            $data['announcement_send_list'][$key]['sl']                     =$sl+1;
            $data['announcement_send_list'][$key]['key']                    =$key;
            $data['announcement_send_list'][$key]['id']                     =$value->id;
            $data['announcement_send_list'][$key]['master_id']              =$value->master_id;
            $data['announcement_send_list'][$key]['system_no']              =$value->system_no;
            $data['announcement_send_list'][$key]['issue_time']             =date("h:i:s A",strtotime($value->issue_time));
            $data['announcement_send_list'][$key]['issue_date']             =date("D M d, Y",strtotime($value->issue_date));
            $data['announcement_send_list'][$key]['posting_time']           =date("h:i:s A",strtotime($value->created_at));
            $data['announcement_send_list'][$key]['posting_date']           =date("D M d, Y",strtotime($value->created_at));
            $data['announcement_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['announcement_send_list'][$key]['issued_by_id']           =$value->inserted_by;
            $data['announcement_send_list'][$key]['issue_to']               =$data_issue_to;
            $data['announcement_send_list'][$key]['participants']           =$participants_names;
            $data['announcement_send_list'][$key]['priority']               =$value->priority;
            $data['announcement_send_list'][$key]['priority_string']        =$priority_level_arr[$value->priority];
            
            $data['announcement_send_list'][$key]['status']                 =$value->status;
            $data['announcement_send_list'][$key]['subject']                =$value->subject;
            $data['announcement_send_list'][$key]['comments']               =$value->comments;
            $data['announcement_send_list'][$key]['required_action']        =$value->required_action;
            $data['announcement_send_list'][$key]['instruction']            =$value->instruction;
            $data['announcement_send_list'][$key]['financial']              =$value->financial;
            $data['announcement_send_list'][$key]['safety_tips']            =$value->instruction;
            $data['announcement_send_list'][$key]['posting_status']         =$value->posting_status;
            $data['announcement_send_list'][$key]['read']                   =$value->read;
            $data['announcement_send_list'][$key]['checked']                =false;
            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['announcement_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['announcement_send_list'][$key]['photo_path']     ="";
            }

            if($value->file_id)
            {
                $data['announcement_send_list'][$key]['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['announcement_send_list'][$key]['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['announcement_send_list'][$key]['file_path']        ="";
                $data['announcement_send_list'][$key]['file_name']        ="";
            }


            $data['announcement_send_list'][$key]['announcement']           =array(

                                    "issue_time"        =>date("h:i:s A",strtotime($value->issue_time)),
                                    'issue_date'        =>date("D M d, Y",strtotime($value->issue_date)),
                                    'posting_time'      =>date("h:i:s A",strtotime($value->created_at)),
                                    'posting_date'      =>date("D M d, Y",strtotime($value->created_at)),
                                    "subject"           =>$value->subject,
                                    'required_action'   => substr($value->required_action, 0, 150),
                                    'financial'         =>$value->financial,
                                    'instruction'       =>$value->instruction,
                                    'safety_tips'       =>$value->safety_tips,
                                    'issued_by'         =>$value->issued_by,
                                    'comments'          =>$value->comments );

            $sl++;
        }
              

         return $data; 
    }


    public function AnnouncementFlag(Request $request)
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
          
        $announcement_send_list         =Announcement::join('user_information_details', 'announcements.id', '=', 'user_information_details.master_id')
                                            ->where('announcements.project_id', '=', $project_id)
                                            ->where('announcements.company_id', '=', $company_id)
                                            ->whereIn('announcements.posting_status', [2,4])
                                            ->where('announcements.is_deleted', '=', 0)
                                            ->where('announcements.status_active', '=',1)
                                            ->where('user_information_details.is_deleted', '=', 0)
                                            ->where('user_information_details.status_active', '=',1)
                                            ->where('user_information_details.project_id', '=', $project_id)
                                            ->where('user_information_details.page_name', '=', "Announcement")
                                            ->where('user_information_details.user_id', '=', $user_id)
                                            ->where('user_information_details.status',4 )
                                            ->where('user_information_details.flagged',1 )
                                            ->orderBy('announcements.updated_at','DESC')
                                            ->get();
                                                
        $data['announcement_send_list']=array(); $sl=0;
        foreach ($announcement_send_list as $key => $value) {

            // $data_issue_to = json_decode($value->issue_to, true);
          
            // Extract only the 'name' values
            $data_issue_to_names = array_column($value->issue_to, 'name');

            // Convert the array to a comma-separated string
            $data_issue_to = implode(', ', $data_issue_to_names);
           
           // $data_participants= json_decode($value->participants, true);

            // Extract only the 'name' values
            $data_participants_names = array_column($value->participants, 'name');

            // Convert the array to a comma-separated string
            $participants_names = implode(', ', $data_participants_names);

            $data['announcement_send_list'][$key]['sl']                     =$sl+1;
            $data['announcement_send_list'][$key]['key']                    =$key;
            $data['announcement_send_list'][$key]['id']                     =$value->id;
            $data['announcement_send_list'][$key]['master_id']              =$value->master_id;
            $data['announcement_send_list'][$key]['system_no']              =$value->system_no;
            $data['announcement_send_list'][$key]['issue_time']             =date("h:i:s A",strtotime($value->issue_time));
            $data['announcement_send_list'][$key]['issue_date']             =date("D M d, Y",strtotime($value->issue_date));
            $data['announcement_send_list'][$key]['posting_time']           =date("h:i:s A",strtotime($value->created_at));
            $data['announcement_send_list'][$key]['posting_date']           =date("D M d, Y",strtotime($value->created_at));
            $data['announcement_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['announcement_send_list'][$key]['issued_by_id']           =$value->inserted_by;
            $data['announcement_send_list'][$key]['issue_to']               =$data_issue_to;
            $data['announcement_send_list'][$key]['participants']           =$participants_names;
            $data['announcement_send_list'][$key]['priority']               =$value->priority;
            $data['announcement_send_list'][$key]['priority_string']        =$priority_level_arr[$value->priority];
            
            $data['announcement_send_list'][$key]['status']                 =$value->status;
            $data['announcement_send_list'][$key]['subject']                =$value->subject;
            $data['announcement_send_list'][$key]['comments']               =$value->comments;
            $data['announcement_send_list'][$key]['required_action']        =$value->required_action;
            $data['announcement_send_list'][$key]['instruction']            =$value->instruction;
            $data['announcement_send_list'][$key]['financial']              =$value->financial;
            $data['announcement_send_list'][$key]['safety_tips']            =$value->instruction;
            $data['announcement_send_list'][$key]['posting_status']         =$value->posting_status;
            $data['announcement_send_list'][$key]['read']                   =$value->read;
            $data['announcement_send_list'][$key]['checked']                =false;
            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['announcement_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['announcement_send_list'][$key]['photo_path']     ="";
            }

            if($value->file_id)
            {
                $data['announcement_send_list'][$key]['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['announcement_send_list'][$key]['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['announcement_send_list'][$key]['file_path']        ="";
                $data['announcement_send_list'][$key]['file_name']        ="";
            }

            $data['announcement_send_list'][$key]['announcement']           =array(

                                    "issue_time"        =>date("h:i:s A",strtotime($value->issue_time)),
                                    'issue_date'        =>date("D M d, Y",strtotime($value->issue_date)),
                                    'posting_time'      =>date("h:i:s A",strtotime($value->created_at)),
                                    'posting_date'      =>date("D M d, Y",strtotime($value->created_at)),
                                    "subject"           =>$value->subject,
                                    'required_action'   => substr($value->required_action, 0, 150),
                                    'financial'         =>$value->financial,
                                    'instruction'       =>$value->instruction,
                                    'safety_tips'       =>$value->safety_tips,
                                    'issued_by'         =>$value->issued_by,
                                    'comments'          =>$value->comments );

            $sl++;
        }
              

         return $data; 
    }

    public function AnnouncementRejected(Request $request)
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
          
        $announcement_send_list         =Announcement::join('user_information_details', 'announcements.id', '=', 'user_information_details.master_id')
                                            ->where('announcements.project_id', '=', $project_id)
                                            ->where('announcements.company_id', '=', $company_id)
                                            ->whereIn('announcements.posting_status', [2,4])
                                            ->where('announcements.is_deleted', '=', 0)
                                            ->where('announcements.status_active', '=',1)
                                            ->where('user_information_details.is_deleted', '=', 0)
                                            ->where('user_information_details.status_active', '=',1)
                                            ->where('user_information_details.project_id', '=', $project_id)
                                            ->where('user_information_details.page_name', '=', "Announcement")
                                            ->where('user_information_details.user_id', '=', $user_id)
                                            ->where('user_information_details.status',6 )
                                            ->where('user_information_details.reject',1 )
                                            ->orderBy('announcements.updated_at','DESC')
                                            ->get();

        
        $data['announcement_send_list']=array(); $sl=0;
        foreach ($announcement_send_list as $key => $value) {

            // $data_issue_to = json_decode($value->issue_to, true);
          
            // Extract only the 'name' values
            $data_issue_to_names = array_column($value->issue_to, 'name');

            // Convert the array to a comma-separated string
            $data_issue_to = implode(', ', $data_issue_to_names);
           
           // $data_participants= json_decode($value->participants, true);

            // Extract only the 'name' values
            $data_participants_names = array_column($value->participants, 'name');

            // Convert the array to a comma-separated string
            $participants_names = implode(', ', $data_participants_names);

            $data['announcement_send_list'][$key]['sl']                     =$sl+1;
            $data['announcement_send_list'][$key]['key']                    =$key;
            $data['announcement_send_list'][$key]['id']                     =$value->id;
            $data['announcement_send_list'][$key]['master_id']              =$value->master_id;
            $data['announcement_send_list'][$key]['system_no']              =$value->system_no;
            $data['announcement_send_list'][$key]['issue_time']             =date("h:i:s A",strtotime($value->issue_time));
            $data['announcement_send_list'][$key]['issue_date']             =date("D M d, Y",strtotime($value->issue_date));
            $data['announcement_send_list'][$key]['posting_time']           =date("h:i:s A",strtotime($value->created_at));
            $data['announcement_send_list'][$key]['posting_date']           =date("D M d, Y",strtotime($value->created_at));
            $data['announcement_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['announcement_send_list'][$key]['issued_by_id']           =$value->inserted_by;
            $data['announcement_send_list'][$key]['issue_to']               =$data_issue_to;
            $data['announcement_send_list'][$key]['participants']           =$participants_names;
            $data['announcement_send_list'][$key]['priority']               =$value->priority;
            $data['announcement_send_list'][$key]['priority_string']        =$priority_level_arr[$value->priority];
            
            $data['announcement_send_list'][$key]['status']                 =$value->status;
            $data['announcement_send_list'][$key]['subject']                =$value->subject;
            $data['announcement_send_list'][$key]['comments']               =$value->comments;
            $data['announcement_send_list'][$key]['required_action']        =$value->required_action;
            $data['announcement_send_list'][$key]['instruction']            =$value->instruction;
            $data['announcement_send_list'][$key]['financial']              =$value->financial;
            $data['announcement_send_list'][$key]['safety_tips']            =$value->instruction;
            $data['announcement_send_list'][$key]['posting_status']         =$value->posting_status;
            $data['announcement_send_list'][$key]['read']                   =$value->read;
            $data['announcement_send_list'][$key]['checked']                =false;
            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['announcement_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['announcement_send_list'][$key]['photo_path']     ="";
            }

            if($value->file_id)
            {
                $data['announcement_send_list'][$key]['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['announcement_send_list'][$key]['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['announcement_send_list'][$key]['file_path']        ="";
                $data['announcement_send_list'][$key]['file_name']        ="";
            }


            $data['announcement_send_list'][$key]['announcement']           =array(

                                    "issue_time"        =>date("h:i:s A",strtotime($value->issue_time)),
                                    'issue_date'        =>date("D M d, Y",strtotime($value->issue_date)),
                                    'posting_time'      =>date("h:i:s A",strtotime($value->created_at)),
                                    'posting_date'      =>date("D M d, Y",strtotime($value->created_at)),
                                    "subject"           =>$value->subject,
                                    'required_action'   => substr($value->required_action, 0, 150),
                                    'financial'         =>$value->financial,
                                    'instruction'       =>$value->instruction,
                                    'safety_tips'       =>$value->safety_tips,
                                    'issued_by'         =>$value->issued_by,
                                    'comments'          =>$value->comments );

            $sl++;
        }
              

         return $data; 
    }


    public function AnnouncementBlock(Request $request)
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
          
        $announcement_block_list         =BlockUser::where('project_id', '=', $project_id)
                                            ->where('company_id', '=', $company_id)
                                            ->where('page_name','Announcement')
                                            ->where('is_deleted', '=', 0)
                                            ->where('status_active', '=',1)
                                            ->where('user_id', '=', $user_id)
                                            ->get();
                                          //  dd($company_id);
        //dd($announcement_block_list);
        $data['announcement_block_list']=array(); $sl=0;
        foreach ($announcement_block_list as $key => $value) {    

            $data['announcement_block_list'][$key]['sl']                     =$sl+1;
            $data['announcement_block_list'][$key]['key']                    =$key;
            $data['announcement_block_list'][$key]['id']                     =$value->id;
            $data['announcement_block_list'][$key]['block_user_name']        =$value->userDetails->name;
            $data['announcement_block_list'][$key]['blocked_user_id']        =$value->userDetails->user_name;
            $data['announcement_block_list'][$key]['block_time']             =date("h:i:s A",strtotime($value->created_at));
            $data['announcement_block_list'][$key]['block_date']             =date("D M d, Y",strtotime($value->block_date));
            $data['announcement_block_list'][$key]['blocked_user']           =$value->blocked_user;  
            $data['announcement_block_list'][$key]['user_type']              =$user_type_arr[$value->userDetails->user_type];        
                   
            $data['announcement_block_list'][$key]['checked']                =false;
            if ($value->userDetails && $value->userDetails->image) {
                $userImagePath = $value->userDetails->image->image_name;
                $data['announcement_block_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['announcement_block_list'][$key]['photo_path']     ="";
            } 
                      
            
            $sl++;
        }
              

         return $data; 
    }

    public function AnnouncementArchive(Request $request)
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
          
        $announcement_send_list         =Announcement::join('user_information_details', 'announcements.id', '=', 'user_information_details.master_id')
                                            ->where('announcements.project_id', '=', $project_id)
                                            ->where('announcements.company_id', '=', $company_id)
                                            ->whereIn('announcements.posting_status', [2,4])
                                            ->where('announcements.is_deleted', '=', 0)
                                            ->where('announcements.status_active', '=',1)
                                            ->where('user_information_details.is_deleted', '=', 0)
                                            ->where('user_information_details.status_active', '=',1)
                                            ->where('user_information_details.project_id', '=', $project_id)
                                            ->where('user_information_details.page_name', '=', "Announcement")
                                            ->where('user_information_details.user_id', '=', $user_id)
                                            ->where('user_information_details.status',7 )
                                            ->where('user_information_details.archived',1 )
                                            ->orderBy('announcements.updated_at','DESC')
                                            ->get();
              

        $data['announcement_send_list']=array(); $sl=0;
        foreach ($announcement_send_list as $key => $value) {

            // $data_issue_to = json_decode($value->issue_to, true);
          
            // Extract only the 'name' values
            $data_issue_to_names = array_column($value->issue_to, 'name');

            // Convert the array to a comma-separated string
            $data_issue_to = implode(', ', $data_issue_to_names);
           
           // $data_participants= json_decode($value->participants, true);

            // Extract only the 'name' values
            $data_participants_names = array_column($value->participants, 'name');

            // Convert the array to a comma-separated string
            $participants_names = implode(', ', $data_participants_names);

            $data['announcement_send_list'][$key]['sl']                     =$sl+1;
            $data['announcement_send_list'][$key]['key']                    =$key;
            $data['announcement_send_list'][$key]['id']                     =$value->id;
            $data['announcement_send_list'][$key]['master_id']              =$value->master_id;
            $data['announcement_send_list'][$key]['system_no']              =$value->system_no;
            $data['announcement_send_list'][$key]['issue_time']             =date("h:i:s A",strtotime($value->issue_time));
            $data['announcement_send_list'][$key]['issue_date']             =date("D M d, Y",strtotime($value->issue_date));
            $data['announcement_send_list'][$key]['posting_time']           =date("h:i:s A",strtotime($value->created_at));
            $data['announcement_send_list'][$key]['posting_date']           =date("D M d, Y",strtotime($value->created_at));
            $data['announcement_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['announcement_send_list'][$key]['issued_by_id']           =$value->inserted_by;
            $data['announcement_send_list'][$key]['issue_to']               =$data_issue_to;
            $data['announcement_send_list'][$key]['participants']           =$participants_names;
            $data['announcement_send_list'][$key]['priority']               =$value->priority;
            $data['announcement_send_list'][$key]['priority_string']        =$priority_level_arr[$value->priority];
            
            $data['announcement_send_list'][$key]['status']                 =$value->status;
            $data['announcement_send_list'][$key]['subject']                =$value->subject;
            $data['announcement_send_list'][$key]['comments']               =$value->comments;
            $data['announcement_send_list'][$key]['required_action']        =$value->required_action;
            $data['announcement_send_list'][$key]['instruction']            =$value->instruction;
            $data['announcement_send_list'][$key]['financial']              =$value->financial;
            $data['announcement_send_list'][$key]['safety_tips']            =$value->instruction;
            $data['announcement_send_list'][$key]['posting_status']         =$value->posting_status;
            $data['announcement_send_list'][$key]['read']                   =$value->read;
            $data['announcement_send_list'][$key]['checked']                =false;
            if ($value->user && $value->user->image) {
                $userImagePath = $value->user->image->image_name;
                $data['announcement_send_list'][$key]['photo_path']   =url('/storage/uploads/'.$userImagePath);
            }    
            else
            {
                $data['announcement_send_list'][$key]['photo_path']     ="";
            }

            if($value->file_id)
            {
                $data['announcement_send_list'][$key]['file_path']        =url('/storage/uploads/'.$value->directoryfile->image_name);
                $data['announcement_send_list'][$key]['file_name']        =$value->directoryfile->image_name;
            }
            else
            {
                $data['announcement_send_list'][$key]['file_path']        ="";
                $data['announcement_send_list'][$key]['file_name']        ="";
            }


            $data['announcement_send_list'][$key]['announcement']           =array(

                                    "issue_time"        =>date("h:i:s A",strtotime($value->issue_time)),
                                    'issue_date'        =>date("D M d, Y",strtotime($value->issue_date)),
                                    'posting_time'      =>date("h:i:s A",strtotime($value->created_at)),
                                    'posting_date'      =>date("D M d, Y",strtotime($value->created_at)),
                                    "subject"           =>$value->subject,
                                    'required_action'   => substr($value->required_action, 0, 150),
                                    'financial'         =>$value->financial,
                                    'instruction'       =>$value->instruction,
                                    'safety_tips'       =>$value->safety_tips,
                                    'issued_by'         =>$value->issued_by,
                                    'comments'          =>$value->comments );

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


            $announcementInfo=BlockUser::where('user_id',"=",$user_id)
                                            ->where('blocked_user',"=",$request->blocked_user)
                                            ->where('page_name','Announcement')
                                            ->update($update_data_block_user);
                                           // dd($announcementInfo);
            //$announcementInfo=UserInformationDetails::where('id',"=",$request->id)->update($update_data);

            if($announcementInfo)
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
                    'page_name'                 =>"Announcement",
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
            
                            
            $announcementInfo=UserInformationDetails::where('id',"=",$request->id)->update($update_data);

            if($announcementInfo && $RId)
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
}
