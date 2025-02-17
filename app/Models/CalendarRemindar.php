<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarRemindar extends Model
{
    protected $fillable = [ 
            'project_id', 
            'mst_id', 
            'reminder_no',
            'reminder_period', 
            'time', 
            'email',
            'description',
            'inserted_by', 
            'updated_by', 
            'status_active', 
            'is_deleted'
        ];
}
