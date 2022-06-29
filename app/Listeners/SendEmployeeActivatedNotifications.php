<?php

namespace App\Listeners;

use App\Events\EmployeeActivated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\User\AccountActivated;

class SendEmployeeActivatedNotifications
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
     * @param  \App\Events\EmployeeActivated  $event
     * @return void
     */
    public function handle(EmployeeActivated $event)
    {
        $user = $event->user;
        $randomPassword = $event->randomPassword;
        $user->notify(new AccountActivated($user,$randomPassword));
    }
}
