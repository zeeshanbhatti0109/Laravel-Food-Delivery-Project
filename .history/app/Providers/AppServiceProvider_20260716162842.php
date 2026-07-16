<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    /**a
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
        Vite::prefetch(concurrency: 3);
    }
}
