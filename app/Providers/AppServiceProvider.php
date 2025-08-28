<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
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
        if (app()->environment('local')) {
            try {
                Http::timeout(1)->get('http://localhost:5173');
            } catch (\Exception $e) {
                throw new \Exception("Vite is not running please run in before open this site");
            }
        }
    }
}
