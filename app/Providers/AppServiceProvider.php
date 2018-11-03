<?php

namespace App\Providers;

use App\Sdc\Repositories\CampaignRepositoryImpl;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Sdc\Repositories\ClientRepositoryImpl;
use App\Sdc\Repositories\UserRepositoryImpl;
use App\Sdc\Repositories\BeaconRepositoryImpl;


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
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Inversion of control
        // Instructing the app classes to inject
        $this->app->bind('App\Sdc\Repositories\UserRepositoryInterface', function() {
            return new UserRepositoryImpl;
        });
        $this->app->bind('App\Sdc\Repositories\ClientRepositoryInterface', function() {
            return new ClientRepositoryImpl;
        });
        $this->app->bind('App\Sdc\Repositories\BeaconRepositoryInterface', function() {
            return new BeaconRepositoryImpl;
        });
        $this->app->bind('App\Sdc\Repositories\CampaignRepositoryInterface', function() {
            return new CampaignRepositoryImpl;
        });
    }
}
