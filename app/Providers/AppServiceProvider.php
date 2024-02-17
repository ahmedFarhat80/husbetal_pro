<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        app()->singleton('lang', function () {
            if (session()->has('lang')) {
                return session()->get('lang');
            } else {
                return 'ar';
            }
        });

        Carbon::setLocale(config('app.locale'));
        Schema::defaultStringLength(191);
    }
}
