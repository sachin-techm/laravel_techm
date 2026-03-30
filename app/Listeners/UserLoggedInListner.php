<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\RegisterMailable;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Mail;

class UserLoggedInListner
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;
        // Mail::to($user)
        //     ->send(new RegisterMailable($user));
    }
}
