<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

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
        Sanctum::authenticateAccessTokensUsing(function ($accessToken, $isValid) {
            if (is_null($accessToken->last_used_at) || $accessToken->last_used_at->lt(now()->subMinutes(5))) {
                $accessToken->forceFill(['last_used_at' => now()])->save();
            }

            return $isValid;
        });
    }
}