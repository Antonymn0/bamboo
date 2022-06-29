<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\UserRegistered' => [
            'App\Listeners\SendEmailVerificationNotification',
        ],
        'App\Events\PasswordChanged' => [
            'App\Listeners\SendPasswordChangedNotifications',
        ],
        'App\Events\EmployeeRegistered' => [
            'App\Listeners\SendEmployeeRegisteredNotifications',
        ],
        'App\Events\EmployeeActivated' => [
            'App\Listeners\SendEmployeeActivatedNotifications',
        ],       
        'App\Events\Leave\LeaveCreatedEvent' => [
            'App\Listeners\Leave\LeaveCreatedListener',
        ],
        'App\Events\Leave\LeaveApprovedEvent' => [
            'App\Listeners\Leave\LeaveApprovedListener',
        ],
        'App\Events\Leave\LeaveUnderReviewEvent' => [
            'App\Listeners\Leave\LeaveUnderReviewListener',
        ],
        'App\Events\Leave\LeaveDeclinedEvent' => [
            'App\Listeners\Leave\LeaveDeclinedListener',
        ],

        'App\Events\Auth\PasswordChangedEvent' => [
            'App\Listeners\Auth\PasswordChangedListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        //return true;
    }
}
