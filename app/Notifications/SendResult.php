<?php

namespace App\Notifications;

use App\Models\Result;
use App\NotificationChannels\TwilioSMSChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendResult extends Notification
{
    // use Queueable;

    public Result $result;

    public $via = "mail";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Result $result, $via = "mail")
    {
        $this->result = $result;
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
            ->markdown('emails.result.result', [
                'result' => $this->result,
                'user' => $notifiable,
            ])
            ->subject('Test Result');
    }

    /**
     * Twilio Sms
     */
    public function toTwilioSMS($notifiable)
    {
        return "Here's your Order for your K-Shala account. 1234";
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
