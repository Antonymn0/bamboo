<?php

namespace App\Notifications\Leave;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class LeaveCreatedNotification extends Notification
{
    use Queueable;

    public $leave;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($leave)
    {
        $this->leave = $leave;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $user = User::where('id', $this->leave->employee_id)->first();

        return (new MailMessage)
            ->line('Dear ' .  ucfirst($user->first_name) . ',')
            ->action('You have new leave request requiring approval', url('/'))
            ->line('Visit your dashboard for more datails!');
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
            'notification_type' => 'leave',
            'notification_sub_type' => 'leave_created',
            'message' => $this->leave->number_of_days,
            'notification_url'=> 'admin.leave.approvals.page'
        ];
    }
}
