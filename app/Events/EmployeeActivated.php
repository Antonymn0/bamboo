<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmployeeActivated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user, $randomPassword;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user,$randomPassword)
    {
        $this->user = $user;
        $this->randomPassword = $randomPassword;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
