<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\SendPasswordResetEmail;
use App\Listeners\UserLoggedInListner;
use Illuminate\Auth\Events\PasswordReset;
use App\Listeners\SendMailVerifiedEmail;
use Illuminate\Auth\Events\Verified;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Verified::class => [
	        SendMailVerifiedEmail::class,
	    ],
        PasswordReset::class => [
	        SendPasswordResetEmail::class,
	    ],
        Login::class => [
            UserLoggedInListner::class,
        ],
        'Laravel\Passport\Events\AccessTokenCreated' => [
            'App\Listeners\RevokeExistingTokens',
        ],

        // 'Laravel\Passport\Events\RefreshTokenCreated' => [
        //     'App\Listeners\RevokeExistingTokens',
        // ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
