<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Passport::routes(function ($router) {
            $router->forAccessTokens();
            $router->forPersonalAccessTokens();
            $router->forTransientTokens();
        });

        $nowPlus10Minutes = new \DateTime(date("Y-m-d H:i:s", strtotime("+10 minutes")));
        Passport::tokensExpireIn($nowPlus10Minutes);
        $nowPlus1Hour = new \DateTime(date("Y-m-d H:i:s", strtotime("+1 hours")));
        Passport::refreshTokensExpireIn($nowPlus1Hour);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
