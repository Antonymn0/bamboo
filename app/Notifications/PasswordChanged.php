<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Channels\SmsChannel;
use App\Channels\Messages\SmsMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChanged extends Notification implements ShouldQueue
{
    use Queueable;
    private $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
                            ->greeting("Hello ".ucfirst($this->user->first_name.","))
                            ->line('Your password has been successfully reset.')
                            ->line('Thank you for using our application!'); 
    }

    public function toSms($notifiable)
    {
        return (new SmsMessage)
                    ->from(env('APP_NAME','Lincoln Finch'))
                    ->to($notifiable->phone)
                    ->line("Your password has been successfully reset.");
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
            'message' => 'Your password has been successfully reset.',
        ];
    }
}
