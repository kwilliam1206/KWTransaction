<?php

namespace KW\Transactions\Providers;

use Illuminate\Support\ServiceProvider;
use KW\Transactions\Services\LocaleService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $view->with('locale', new LocaleService());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
