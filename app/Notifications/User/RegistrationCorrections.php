<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationCorrections extends Notification
{
    use Queueable;
    protected $user,$randomPass;

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
                ->greeting("Hi ".ucfirst($this->user->first_name))
                ->line('You are requested to make corrections of the registration details you submitted')
                ->line($this->user->basic_details_comments ? 'For Basic Details: '.$this->user->basic_details_comments : '')
                ->line($this->user->address_details_comments ? 'For Address Details: '.$this->user->address_details_comments : '')
                ->line($this->user->education_details_comments ? 'For Education Details: '.$this->user->education_details_comments : '')
                ->line($this->user->certifications_details_comments ? 'For Certifications Details: '.$this->user->certifications_details_comments : '')
                ->line($this->user->languages_details_comments ? 'For Languages Details: '.$this->user->languages_details_comments : '')
                ->line($this->user->work_experience_details_comments ? 'For Work Experience Details: '.$this->user->work_experience_details_comments : '')
                ->line($this->user->referees_details_comments ? 'For Referees Details: '.$this->user->referees_details_comments : '')
                ->line($this->user->emergency_details_comments ? 'For Emergency Details: '.$this->user->emergency_details_comments : '')
                ->line($this->user->dependants_details_comments ? 'For Dependants Details: '.$this->user->dependants_details_comments : '')
                ->line($this->user->beneficiaries_details_comments ? 'For Beneficiaries Details: '.$this->user->beneficiaries_details_comments : '')
                ->line('Kindly login using the following credentials:')
                ->line('Email: '.$this->user->email)
                ->line('Password: '.$this->randomPass)
                ->action('Correct', url('/'))
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
