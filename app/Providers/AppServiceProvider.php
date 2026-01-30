<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Dao registration
        $this->app->bind('App\Contracts\Dao\UserDaoInterface', 'App\Dao\UserDao');
        $this->app->bind('App\Contracts\Dao\ProjectDaoInterface', 'App\Dao\ProjectDao');
        $this->app->bind('App\Contracts\Dao\MediaObjectDaoInterface', 'App\Dao\MediaObjectDao');

        // Service registration
        $this->app->bind('App\Contracts\Service\UserServiceInterface', 'App\Service\UserService');
        $this->app->bind('App\Contracts\Service\ProjectServiceInterface', 'App\Service\ProjectService');
        $this->app->bind('App\Contracts\Service\MediaObjectServiceInterface', 'App\Service\MediaObjectService');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
