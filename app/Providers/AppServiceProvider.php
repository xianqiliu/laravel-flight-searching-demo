<?php

namespace App\Providers;

use Amadeus\Amadeus;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(Amadeus::class, function($app) {
            return Amadeus::builder(env('AMADEUS_CLIENT_ID'),env('AMADEUS_CLIENT_SECRET'))->build();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
