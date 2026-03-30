<?php

namespace App\NotificationChannels;

use App\Facades\Twilio;
use App\Models\User;
use Illuminate\Notifications\Notification;

class TwilioSMSChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notification
     * we will change the User type later if we put more model to it
     */
    public function send(User $user, Notification $notification)
    {
        $message = $notification->toTwilioSMS($user);

        return Twilio::sendSMS($user->phone, $message);
    }
}
