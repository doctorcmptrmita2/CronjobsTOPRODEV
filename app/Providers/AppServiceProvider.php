<?php

namespace App\Providers;

use App\Listeners\SendLoginNotification;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
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
        Schema::defaultStringLength(191);

        // Register login event listener
        Event::listen(Login::class, SendLoginNotification::class);

        // Force HTTPS for all URLs in production if APP_URL is HTTPS
        if (config('app.env') === 'production') {
            $appUrl = config('app.url');
            $assetUrl = config('app.asset_url') ?: $appUrl;
            
            if ($appUrl && str_starts_with($appUrl, 'https://')) {
                // Force all URLs to use HTTPS
                URL::forceScheme('https');
                URL::forceRootUrl($appUrl);
            }
            
            // Override asset URL if ASSET_URL is set
            if ($assetUrl && str_starts_with($assetUrl, 'https://')) {
                config(['app.asset_url' => $assetUrl]);
            }
        }
    }
}
