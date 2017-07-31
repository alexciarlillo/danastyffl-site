<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use App\Extensions\MFLUserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('mfl', function($app, array $config) {
            return new MFLUserProvider();
        });
    }
}
