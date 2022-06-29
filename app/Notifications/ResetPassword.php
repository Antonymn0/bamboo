<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use App\Channels\Messages\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;
    protected $user;
    protected $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->token = rand(1000,9999);
        $this->user->remember_token = $this->token;
        $this->user->save();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //return ['mail',SmsChannel::class];
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
                    ->greeting("Hello ".ucfirst($this->user->first_name.","))
                    ->line('A request to reset your password has been received. If you did not intiate this process no further action is needed. You can use the code below to reset your password.')
                    ->line($this->token)
                    ->line('Thank you for using our application!');
    }

    public function toSms($notifiable)
    {
        return (new SmsMessage)
                    ->from(env('APP_NAME','Lincoln Finch'))
                    ->to($notifiable->phone)
                    ->line($this->token)
                    ->line("is your reset password code.");
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
