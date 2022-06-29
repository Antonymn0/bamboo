<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContinueRegistration extends Notification implements ShouldQueue
{
    use Queueable;
    protected $user, $randomPass;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$randomPass)
    {
        $this->user = $user;
        $this->randomPass = $randomPass;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hi '.ucfirst($this->user->first_name))
                    ->line('Kindly complete your registation using the following credentials:')
                    ->line('Email: '.$this->user->email)
                    ->line('Password: '.$this->randomPass)
                    ->action('Continue Registration', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
