<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Route;


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
        $this->mapApiRoutes();
    }

    /**
     * Define API routes.
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api') // Prefix URL dengan "api"
            ->middleware('api') // Middleware untuk API
            ->group(base_path('routes/api.php')); // Menghubungkan ke routes/api.php
    }
}
