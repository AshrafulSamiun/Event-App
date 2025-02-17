<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $fillable = [ 
            'project_id',
            'system_prefix',
            'system_no', 
            'event_date', 
            'start_time', 
            'end_time',
            'current_year',
            'priority_level', 
            'subject',
            'message',
            'recurring_cycle', 
            'repeat_every', 
            'start_date', 
            'repeat_no_date_id', 
            'never_end', 
            'comments', 
            'required_action',
            'repeat_end_after',
            'occerance_number',
            'end_on', 
            'end_date', 
            'inserted_by', 
            'updated_by', 
            'status_active', 
            'is_deleted'];
}

                  
