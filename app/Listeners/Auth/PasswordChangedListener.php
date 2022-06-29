<?php

namespace App\Listeners\Auth;

use App\Events\Auth\PasswordChangedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\Auth\PasswordChangedNotification;

class PasswordChangedListener
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
     * @param  \App\Events\Auth\PasswordChangedEvent  $event
     * @return void
     */
    public function handle(PasswordChangedEvent $event)
    {
        $user = $event->user;

        $event->user->notify(new PasswordChangedNotification($event->user));
    }
}
