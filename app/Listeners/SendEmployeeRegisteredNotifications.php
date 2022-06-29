<?php

namespace App\Listeners;

use App\Events\EmployeeRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmployeeRegisteredNotifications
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
     * @param  \App\Events\EmployeeRegistered  $event
     * @return void
     */
    public function handle(EmployeeRegistered $event)
    {
        //$user = $event->user;
        //$user->notify(new VerifyEmail($user));
    }
}
