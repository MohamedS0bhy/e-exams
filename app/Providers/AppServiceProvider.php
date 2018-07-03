<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(request()->server('SERVER_NAME') == 'examsvc.herokuapp.com')
        {
            URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(request()->server('SERVER_NAME') == 'examsvc.herokuapp.com') {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
