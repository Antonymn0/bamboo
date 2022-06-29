<?php

namespace App\Listeners\Leave;

use App\Events\Leave\LeaveUnderReviewEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\Leave\LeaveUnderReviewNotification;
use App\Models\User;

class LeaveUnderReviewListener
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
     * @param  \App\Events\Leave\LeaveUnderReviewEvent  $event
     * @return void
     */
    public function handle(LeaveUnderReviewEvent $event)
    {
        $user = User::where('id', $event->leave->employee_id)->first();

        $user->notify(new LeaveUnderReviewNotification($event->leave));
    }
}
