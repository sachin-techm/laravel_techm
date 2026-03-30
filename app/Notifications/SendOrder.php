<?php

namespace App\Notifications;

use App\Models\Order;
use App\NotificationChannels\TwilioSMSChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// class SendOrder extends Notification implements ShouldQueue
class SendOrder extends Notification
{
    // use Queueable;

    public Order $order;

    public $via = "mail";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order, $via = "mail")
    {
        $this->order = $order;
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
            ->markdown('emails.order.order-invoice', [
                'order' => $this->order,
                'user' => $notifiable,
            ])
            ->subject('K-Shala Order');
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
