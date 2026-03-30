<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;

class RevokeExistingTokens
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
    public function handle($event)
    {

        if(env('APP_ENV') != 'local') {

            $user = User::find($event->userId);
            $user->tokens()->limit(100)->offset(1)->get()->map(function ($token) {
                $token->revoke();
                $token->delete();
            });
        }
    }
}
