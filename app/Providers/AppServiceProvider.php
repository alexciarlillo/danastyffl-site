<?php

namespace App\Providers;

use App\Services\MFLApiService;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MFLApiService::class, function ($app) {
            return new MFLApiService(config('mfl.league_host'), config('mfl.league_id'), config('mfl.league_api_key'));
        });

        $this->app->instance('JsonMapper', function ($app) {
            return new \JsonMapper();
        });
    }
}
