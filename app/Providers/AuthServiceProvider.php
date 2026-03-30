<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        // Passport::loadKeysFrom(__DIR__.'/../secrets/oauth');

        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        /*VerifyEmail::toMailUsing(function ($notifiable, $url) {
	        return (new MailMessage)
	            ->subject('Verify Email Address')
	            ->line('Click the button below to verify your email address.')
	            ->action('Verify Email Address', $url);
	    });*/

	    /*ResetPassword::toMailUsing(function ($notifiable, $url) {
	        return (new MailMessage)
	            ->subject(Lang::get('Reset Password Notification'))
	            ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
	            ->action(Lang::get('Reset Password'), $url)
	            ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
	            ->line(Lang::get('If you did not request a password reset, no further action is required.'))
	    });*/
    }
}
