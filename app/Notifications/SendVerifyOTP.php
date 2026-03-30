<?php

namespace App\Notifications;

use App\Models\Otp;
use App\NotificationChannels\TwilioSMSChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendVerifyOTP extends Notification
{
    // use Queueable;

    public Otp $otp;

    public $via = "mail";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Otp $otp, $via = "mail")
    {
        $this->otp = $otp;
        $this->via = $via;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($this->via === "sms") {
            info("via sms");
            return [TwilioSMSChannel::class];
        }

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
            ->markdown('emails.notifications.send-verify-otp', [
                'otp' => $this->otp,
                'user' => $notifiable,
            ])
            ->subject('Verify Email');
    }

    /**
     * Twilio Sms
     */
    public function toTwilioSMS($notifiable)
    {
        return "Here's your OTP verification code for your K-Shala account. {$this->otp->code}";
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
