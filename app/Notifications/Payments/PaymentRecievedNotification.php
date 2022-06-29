<?php

namespace App\Notifications\Payments;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Helpers\GeneratePDF;
// use App\Channels\Messages\SmsMessage;

class PaymentRecievedNotification extends Notification
{
    use Queueable;

    public $payment;
    public $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
        $this->user = User::findOrFail($this->payment->user_id);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail', 'sms'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $pdf = GeneratePDF::subscriptionPaymentRecieptPDF($this->payment);

        return (new MailMessage)
                    ->line('Dear ' . $this->user->first_name . ' Your payment of KSH ' . $this->payment->transaction_amount . ' via ' . ucfirst($this->payment->payment_method) . ' has been recieved.')
                   
                    ->line('Thank you for choosing ' . ucfirst( env('APP_NAME') ) . '!')
                    ->attachData($pdf->output(), "payment.pdf"); 
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $user = User::findOrFail($this->payment->user_id);

        return [
            'notification_type' => 'payment',
            'notification_sub_type' => 'payment_recieved',
            'message' => 'Your subscription payment via' . ucfirst($this->payment->payment_method) . ' has been successfuly recieved',
            'notification_url' => 'company.registration.subscription'
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
        $user = User::findOrFail($this->payment->user_id);

        // return (new SmsMessage)
        //         ->line('Dear ' . $this->user->first_name . ' Your payment of KSH ' . $this->payment->transaction_amount . ' via ' . ucfirst($this->payment->payment_method) . ' has been recieved.')
        //         ->line('Thank you for choosing ' . ucfirst(env('APP_NAME')) . '!') 
        //         ->send();
        
    }
}
