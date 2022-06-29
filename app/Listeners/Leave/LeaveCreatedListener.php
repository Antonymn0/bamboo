<?php

namespace App\Listeners\Leave;

use App\Events\Leave\LeaveCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\Leave\LeaveCreatedNotification;
use App\Models\User;
use Notification;

class LeaveCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Leave\LeaveCreatedEvent  $event
     * @return void
     */
    public function handle(LeaveCreatedEvent $event)
    {
        $employee = User::where('id', $event->leave->employee_id)->first();

        $users = User::Where('company_id', $employee->company_id)
                        ->permission('approve_leave')
                        ->get();

        foreach ($users as $user) {
            $user->notify(new LeaveCreatedNotification($event->leave));
        }        

    }
}
