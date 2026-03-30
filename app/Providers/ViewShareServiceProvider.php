<?php

namespace App\Providers;

use View;
use App\Models\LogActivity;
use Illuminate\Support\ServiceProvider;
use App\Models\AdminSettings;

class ViewShareServiceProvider extends ServiceProvider
{

    public function boot()
    {
        // AdminSettings::$shouldAppends = false;
        $adminSettings     = AdminSettings::where('status', 1)->first();

        View::share(
            [
                'adminSettings' => $adminSettings,
            ]
        );
    }

    public function register()
    {
        //
    }

}
