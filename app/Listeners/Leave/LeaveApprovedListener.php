<?php

namespace App\Listeners\Leave;

use App\Events\Leave\LeaveApprovedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\Leave\LeaveApprovedNotification;
use App\Models\User;

class LeaveApprovedListener
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
     * @param  \App\Events\Leave\LeaveApprovedEvent  $event
     * @return void
     */
    public function handle(LeaveApprovedEvent $event)
    {
        $user = User::where('id', $event->leave->employee_id)->first();

        $user->notify(new LeaveApprovedNotification($event->leave));
    }
}
