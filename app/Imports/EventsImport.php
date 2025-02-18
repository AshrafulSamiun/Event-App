<?php

namespace App\Imports;

use App\Models\CalendarEvent;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
class EventsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $year                                   =date("Y",strtotime($row[0]));
        $event_date                             =date("Y-m-d",strtotime($row[0]));
        $end_time='';
        $start_time='';
        if($row[1])
        {
            $start_time                         =date("H:i:s",strtotime($row[1]));
        }

        if($row[2])
        {
            $end_time                           =date("H:i:s",strtotime($row[2]));
        }

        $max_system_data = CalendarEvent::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from calendar_events 
            where  YEAR(created_at)=".date('Y')." )  and  YEAR(created_at)=".date('Y'))->get(['system_prefix']);

          

        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }
        $system_no="EVNT-".date('Y')."-".str_pad($max_system_prefix, 4, 0, STR_PAD_LEFT);
        //dd($max_system_prefix) ;
        return new CalendarEvent([
            'system_prefix'     => $max_system_prefix,
            'system_no'         => $system_no,
            'current_year'      => $year,
            'event_date'        => $event_date,
            'priority_level'    => $row[3],
            'start_time'        => $start_time,
            'end_time'          => $end_time,
            'subject'           => $row[4],
            'message'           => $row[5],
            'comments'          => $row[6],
            'inserted_by'       =>101
        ]);

        DB::commit();
        return "1**$event";
    }
}
