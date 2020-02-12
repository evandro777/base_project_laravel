<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
Use Schema;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Avoid problems with mariadb
        Schema::defaultStringLength(191);
    }
}
