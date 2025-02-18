<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CalendarEvent;
use App\Models\CalendarRemindar;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventReminderMail;
use Illuminate\Support\Facades\DB;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = CalendarEvent::join('calendar_remindars', 'calendar_events.id', '=', 'calendar_remindars.mst_id')
            ->where('calendar_events.status_active',1)
            ->where('calendar_remindars.reminder_date', '<=', now())
            ->where('calendar_remindars.time', '>=', now())
            ->where('calendar_remindars.status_active',1)
            ->where('calendar_remindars.mail_sent',0)
            ->select('calendar_events.*', 'calendar_remindars.*','calendar_remindars.id as dtls_id')
            ->get();

        $update_data= array(
            'mail_sent'         =>1,
            'updated_by'        =>100,
        );

        DB::beginTransaction();
        foreach ($events as $event) {
            Mail::to($event->email)->send(new EventReminderMail($event));

            $productData=CalendarRemindar::where('id',"=",$event->dtls_id)->update($update_data);
            if( !$productData)
            {
                DB::rollBack();
                return 10;
                die;
            }
        }

        DB::commit();
    }
}
