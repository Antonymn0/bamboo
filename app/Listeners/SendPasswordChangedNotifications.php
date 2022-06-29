<?php

namespace App\Listeners;

use App\Events\PasswordChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\PasswordChanged as PasswordChangedNotification;

class SendPasswordChangedNotifications 
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
     * @param  PasswordChanged  $event
     * @return void
     */
    public function handle(PasswordChanged $event)
    {
        $user = $event->user;
        $user->notify(new PasswordChangedNotification($user));
    }
}
