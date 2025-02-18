<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ArrayFunction as ArrayFunction;
use Illuminate\Support\Facades\DB;
use App\Models\CalendarEvent;
use App\Models\CalendarRemindar;
use App\Imports\EventsImport;
use Maatwebsite\Excel\Facades\Excel;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $ArrayFunction              =new ArrayFunction();
        $month_arr                  =$ArrayFunction->month_arr;
        $recurring_cycle_arr        =$ArrayFunction->recurring_cycle_arr;
        $reminder_arr               =$ArrayFunction->reminder_arr;
        $data['month_arr']          =$month_arr;
        $data['recurring_cycle_arr']=$recurring_cycle_arr;
        $data['reminder_arr']       =$reminder_arr;


        $reminder_arr=array();
        for($i=0;$i<5; $i++)
        {
            $reminder_arr[$i]['reminder_no']=$i+1;
            $reminder_arr[$i]['date']       ="";
            $reminder_arr[$i]['time']       ="";
            $reminder_arr[$i]['email']      ="";
            $reminder_arr[$i]['description']="";
        }

        $data['reminder_arr']          =$reminder_arr;
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

    public function importFromCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        Excel::import(new EventsImport, $request->file('csv_file'));

        return response()->json(['message' => 'Events imported successfully'], 200);
    }

    public function CalendarLists(Request $request,$year)
    {
        
       
       
        $ArrayFunction              =new ArrayFunction();
        
        $recurring_cycle_arr        =$ArrayFunction->recurring_cycle_arr;
        $reminder_arr               =$ArrayFunction->reminder_arr;
        $data['recurring_cycle_arr']=$recurring_cycle_arr;
        $data['reminder_arr']       =$reminder_arr;


        $reminder_details_arr=array();
        for($i=0;$i<5; $i++)
        {
            $reminder_details_arr[$i]['reminder_no']    =$i+1;
            $reminder_details_arr[$i]['reminder_period']="";
            $reminder_details_arr[$i]['deminder_date']  ="";
            $reminder_details_arr[$i]['time']           ="";
            $reminder_details_arr[$i]['email']          ="";
            $reminder_details_arr[$i]['description']    ="";
            $reminder_details_arr[$i]['id']             ="";
        }

        $data['reminder_details_arr']       =$reminder_details_arr;
       
        $calender_event_sql                 =CalendarEvent::where('current_year',$year)
                                                ->where('status_active',1);


        $calender_data                      =$calender_event_sql->get();
                                            
        //dd($calender_data);
        $sl=0;$data['calendar_list']=array();
        foreach ($calender_data as $key => $value) {
            $month=date("n",strtotime($value->event_date))-1;
            $day=date("j",strtotime($value->event_date));
            $words = preg_split('/\s+/', $value->message); // Split by whitespace
            $message = implode(' ', array_slice($words, 0, 20));
            $data['calendar_list'][$month][$day]['sl']                    =$sl+1;
            $data['calendar_list'][$month][$day]['id']                    =$value->id;
            $data['calendar_list'][$month][$day]['system_no']             =$value->system_no;
            $data['calendar_list'][$month][$day]['company_id']            =$value->company_id;
            $data['calendar_list'][$month][$day]['company_type']          =$value->company_type;
            $data['calendar_list'][$month][$day]['calendar_date']         =date("j-n-Y",strtotime($value->event_date));
            $data['calendar_list'][$month][$day]['subject']               =$value->subject;
            $data['calendar_list'][$month][$day]['message']               =$message;
        }

        return $data;

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
            
            'event_date'        => 'required',
            'priority_level'    => 'required',
            'subject'           => 'required',
            'message'           => 'required',
            'required_action'   => 'required',
            
        ]);

        $event_date                             =date("Y-m-d",strtotime($request->input('event_date')));
     
        if($request->input('start_date'))
        {
            $start_date                         =date("Y-m-d",strtotime($request->input('start_date')));
            $request->merge(['start_date'       =>$start_date]);
        }

        if($request->input('end_date'))
        {
            $end_date                           =date("Y-m-d",strtotime($request->input('end_date')));
            $request->merge(['end_date'         =>$end_date]);
        }

        if($request->input('start_time'))
        {
            $start_time                         =date("H:i:s",strtotime($request->input('start_time')));
            $request->merge(['start_time'       =>$start_time]);
        }

        if($request->input('end_time'))
        {
            $end_time                           =date("H:i:s",strtotime($request->input('end_time')));
            $request->merge(['end_time'         =>$end_time]);
        }

        $user_id=100;
        $request->merge(['inserted_by'          =>$user_id]);
        $request->merge(['event_date'           =>$event_date]);

        $max_system_data = CalendarEvent::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from calendar_events 
            where  YEAR(created_at)=".date('Y')." )  and  YEAR(created_at)=".date('Y'))->get(['system_prefix']);
               // ->toSql(); and floor_no=".$request->input('floor_no')."

               
       // dd($max_system_data);die;
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="EVNT-".date('Y')."-".str_pad($max_system_prefix, 4, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);
       // dd( $request->all());
        DB::beginTransaction();
        $calendar_info= CalendarEvent::create($request->all()); 

        foreach($request->reminder_details_arr as $key=>$details)
        {
                      
            if($details['reminder_period'])
            {  
                if($details['time'])
                {
                    $remidnar_time                      =date("H:i:s",strtotime($details['time']));
                    $details['time']                    =$remidnar_time;
                } 
                
                if($details['reminder_date'])
                {
                    $reminder_date                      =date("Y-m-d",strtotime($details['reminder_date']));
                    $details['reminder_date']           =$reminder_date;
                }

                $data_deminder_details[]= array(
                    'mst_id'                    =>$calendar_info->id,
                    'reminder_no'               =>$details['reminder_no'],
                    'email'                     =>$details['email'],
                    'time'                      =>$details['time'],
                    'reminder_date'             =>$details['reminder_date'],
                    'description'               =>$details['description'],
                    'reminder_period'           =>$details['reminder_period'],
                    'inserted_by'               =>$user_id,
                );
            }
        } 

        $RId1=true;
        if(!empty($data_deminder_details))
        {
            $RId1=CalendarRemindar::insert($data_deminder_details);
        }       
    
        if($calendar_info)
        {
           DB::commit();
           return "1**$calendar_info->id**$system_no";
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
    public function edit($id, Request $request)
    {
        
        $ArrayFunction              =new ArrayFunction();
        $month_arr                  =$ArrayFunction->month_arr;
        $recurring_cycle_arr        =$ArrayFunction->recurring_cycle_arr;
        $reminder_arr               =$ArrayFunction->reminder_arr;
        $data['month_arr']          =$month_arr;
        $data['recurring_cycle_arr']=$recurring_cycle_arr;
        $data['reminder_arr']       =$reminder_arr;

       
        
        $calender_event_sql             =CalendarEvent::where('id',$id)
                                        ->where('status_active',1)->get();
        $year="";
        foreach ($calender_event_sql as $key => $value) {
            
            $year                                               =$value->current_year;
            $data['calender_data_arr']['id']                    =$value->id;
            $data['calender_data_arr']['system_no']             =$value->system_no;
            $data['calender_data_arr']['system_prefix']         =$value->system_prefix;
            $data['calender_data_arr']['event_date']            =$value->event_date;
            $data['calender_data_arr']['subject']               =$value->subject;
            $data['calender_data_arr']['current_year']          =$value->current_year;
            $data['calender_data_arr']['start_time']            =date("H:i:s",strtotime($value->start_time));
            $data['calender_data_arr']['end_time']              =date("H:i:s",strtotime($value->end_time));
            $data['calender_data_arr']['priority_level']        =$value->priority_level;
            $data['calender_data_arr']['message']               =$value->message;
            $data['calender_data_arr']['required_action']       =$value->required_action;
            $data['calender_data_arr']['recurring_cycle']       =$value->recurring_cycle;
            $data['calender_data_arr']['repeat_every']          =$value->repeat_every;
            $data['calender_data_arr']['start_date']            =$value->start_date;
            $data['calender_data_arr']['repeat_no_date_id']     =$value->repeat_no_date_id;
            $data['calender_data_arr']['never_end']             =$value->never_end;
            $data['calender_data_arr']['comments']             =$value->comments;
            $data['calender_data_arr']['repeat_end_after']     =$value->repeat_end_after;
            $data['calender_data_arr']['occerance_number']     =$value->occerance_number;
            $data['calender_data_arr']['end_on']               =$value->end_on;
            $data['calender_data_arr']['end_date']             =$value->end_date;
            $data['calender_data_arr']['posting_status']       =$value->posting_status;
        }

        $reminder_details_arr=array();
        for($i=0;$i<5; $i++)
        {
            $reminder_details_arr[$i]['reminder_no']    =$i+1;
            $reminder_details_arr[$i]['reminder_period']="";
            $reminder_details_arr[$i]['time']           ="";
            $reminder_details_arr[$i]['email']          ="";
            $reminder_details_arr[$i]['description']    ="";
            $reminder_details_arr[$i]['id']             ="";
            $reminder_details_arr[$i]['deminder_date']  ="";
        }

        $reminder_data                                  =CalendarRemindar::where('status_active',1)
                                                            ->where('mst_id',$id)
                                                            ->get();

        foreach ($reminder_data as $key => $value) {
            if($value->time)
            {
                $remidnar_time                      =date("H:i:s",strtotime($value->time));
                $value->time                        =$remidnar_time;
            }

            $i=$value->reminder_no-1;
            $reminder_details_arr[$i]['reminder_no']    =$value->reminder_no;
            $reminder_details_arr[$i]['reminder_period']=$value->reminder_period;
            $reminder_details_arr[$i]['time']           =$value->time;
            $reminder_details_arr[$i]['reminder_date']  =$value->reminder_date;
            $reminder_details_arr[$i]['email']          =$value->email;;
            $reminder_details_arr[$i]['description']    =$value->description;;
            $reminder_details_arr[$i]['id']             =$value->id;
            $reminder_details_arr[$i]['deminder_date']  =$value->deminder_date;
        }

        $data['reminder_details_arr']       =$reminder_details_arr;
       

        

        $calender_data                      =CalendarEvent::where('current_year',$year)
                                                ->where('status_active',1)->get();
                                            
        $sl=0;$data['calendar_list']=array();
        foreach ($calender_data as $key => $value) {
            $month=date("n",strtotime($value->event_date))-1;
            $day=date("j",strtotime($value->event_date));
            $words = preg_split('/\s+/', $value->message); // Split by whitespace
            $message = implode(' ', array_slice($words, 0, 20));
            $data['calendar_list'][$month][$day]['sl']                    =$sl+1;
            $data['calendar_list'][$month][$day]['id']                    =$value->id;
            $data['calendar_list'][$month][$day]['system_no']             =$value->system_no;
            $data['calendar_list'][$month][$day]['calendar_date']         =date("j-n-Y",strtotime($value->event_date));
            $data['calendar_list'][$month][$day]['subject']               =$value->subject;
            $data['calendar_list'][$month][$day]['message']               =$message;
        }
           
       // $data['calender_data_arr']          =$calender_event_sql;
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
            
            'event_date'        => 'required',
            'priority_level'    => 'required',
            'subject'           => 'required',
            'message'           => 'required',
            'required_action'   => 'required',
            
        ]);

        $event_date                             =date("Y-m-d",strtotime($request->input('event_date')));      

       
     
        if($request->input('start_date'))
        {
            $start_date                         =date("Y-m-d",strtotime($request->input('start_date')));
            $request->merge(['start_date'       =>$start_date]);
        }

        if($request->input('end_date'))
        {
            $end_date                           =date("Y-m-d",strtotime($request->input('end_date')));
            $request->merge(['end_date'         =>$end_date]);
        }

        if($request->input('start_time'))
        {
            $start_time                         =date("H:i:s",strtotime($request->input('start_time')));
            $request->merge(['start_time'       =>$start_time]);
        }

        if($request->input('end_time'))
        {
            $end_time                           =date("H:i:s",strtotime($request->input('end_time')));
            $request->merge(['end_time'         =>$end_time]);
        }
        
        $user_id=100;
        $request->merge(['updated_by '          =>$user_id]);
        $request->merge(['event_date'           =>$event_date]);

        DB::beginTransaction();
        $calendar_info= CalendarEvent::find($id)->update($request->all());

        foreach($request->reminder_details_arr as $key=>$details)
        {
                      
            if($details['reminder_period'])
            {


                if($details['time'])
                {
                    $remidnar_time                      =date("H:i:s",strtotime($details['time']));
                    $details['time']                    =$remidnar_time;
                }

                if($details['reminder_date'])
                {
                    $reminder_date                      =date("Y-m-d",strtotime($details['reminder_date']));
                    $details['reminder_date']           =$reminder_date;
                }

                if($details['id']>0)
                {
                    $details_data_update= array(
                        'mst_id'                    =>$id,
                        'reminder_no'               =>$details['reminder_no'],
                        'email'                     =>$details['email'],
                        'time'                      =>$details['time'],
                        'reminder_date'             =>$details['reminder_date'],
                        'description'               =>$details['description'],
                        'reminder_period'           =>$details['reminder_period'],
                        'updated_by'                =>$user_id,
                    );

                    $productData=CalendarRemindar::where('id',"=",$details['id'])->update($details_data_update);
                    if( !$productData)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                
                    $data_deminder_details[]= array(
                        'mst_id'                    =>$id,
                        'reminder_no'               =>$details['reminder_no'],
                        'email'                     =>$details['email'],
                        'time'                      =>$details['time'],
                        'description'               =>$details['description'],
                        'reminder_period'           =>$details['reminder_period'],
                        'inserted_by'               =>$user_id,
                    );
                }
            }
        } 

        $RId1=true;
        if(!empty($data_deminder_details))
        {
            $RId1=CalendarRemindar::insert($data_deminder_details);
        } 
        
        if($calendar_info && $RId1)
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

        
        $user_id=100;
        DB::beginTransaction();
        $calendar_info= CalendarEvent::find($id)->update(['updated_by'=>$user_id,'status_active'=>0,'is_deleted'=>1]);       

        $update_data= array(
            'status_active'             =>0,
            'is_deleted'                =>1,
            'updated_by'                =>$user_id,
        );

        $petty_cash_delete=CalendarRemindar::where('mst_id',"=",$id)->update($update_data);
        if($calendar_info)
        {   DB::commit();
            return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }

    
}
