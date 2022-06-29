<?php

namespace App\Notifications\Payments;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
// use App\Channels\Messages\SmsMessage;
class AccountActivatedNotification extends Notification
{
    use Queueable;


    public $user;
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
        return ['database', 'mail', 'sms'];
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
                ->line('Dear ' . ucfirst($this->user->first_name) .',' )
                ->line('Your account has been activated and is now ready for service.')
                ->line('Please visit your dashboard for more.')
                ->action('Dashboard', url('/dashboard'))
                ->line('Thank you for choosing ' . ucfirst(env('APP_NAME')) . '!');
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
            'notification_type' => 'activation',
            'notification_sub_type' => 'account_activated',
            'message' => ucfirst($this->user->first_name) .', Your account is now active',
            'notification_url' => 'dashboard'
        ];
    }

    /**
     * Get sms representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toSms($notifiable)
    {
        // $user = User::findOrFail($this->payment->user_id);

        // return (new SmsMessage)
        //     ->line('Dear ' . ucfirst($this->user->first_name) . ',')
        //     ->line('Your account has been activated and is now ready for service.')
        //     ->line('Thank you for choosing ' . ucfirst(env('APP_NAME')) . '!')
        //     ->send();
    }
}
