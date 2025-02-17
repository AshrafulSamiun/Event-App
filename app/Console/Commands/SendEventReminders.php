<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CalendarEvent;
use App\Models\CalendarRemindar;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventReminderMail;

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
            ->where('calendar_remindars.reminder_date', '>=', now())
            ->where('calendar_remindars.time', '>=', now())
            ->where('calendar_remindars.status_active',1)
            ->select('calendar_events.*', 'calendar_remindars.*')
            ->get();


        foreach ($events as $event) {
            Mail::to('recipient@example.com')->send(new EventReminderMail($event));
        }
    }
}
