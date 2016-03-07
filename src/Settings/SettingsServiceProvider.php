<?php

namespace LaravelFlare\Settings;

use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        // Config
        $this->publishes([
            __DIR__.'/../config/flare/settings.php' => config_path('flare/settings.php'),
        ]);

        // Migrations
        $this->publishes([
            __DIR__.'/Database/Migrations' => base_path('database/migrations'),
        ]);
    }

    /**
     * Register any package services.
     */
    public function register()
    {
        
    }
}
