<?php

namespace App\Listeners\Leave;

use App\Events\Leave\LeaveDeclinedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\Leave\LeaveDeclinedNotification;
use App\Models\User;

class LeaveDeclinedListener
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
     * @param  \App\Events\Leave\LeaveDeclinedEvent  $event
     * @return void
     */
    public function handle(LeaveDeclinedEvent $event)
    {
        $user = User::where('id', $event->leave->employee_id)->first();

        $user->notify(new LeaveDeclinedNotification($event->leave));
    }
}
