<?php

namespace LaravelFlare\Settings;

use LaravelFlare\Flare\FlareModuleProvider as ServiceProvider;

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

        // Views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'flare');
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/flare'),
        ]);
    }

    /**
     * Register any package services.
     */
    public function register()
    {
        $this->registerFlareHelpers();
    }

    /**
     * Register Flare Helper for Pages.
     */
    protected function registerFlareHelpers()
    {
        $this->flare->registerHelper('settings', \LaravelFlare\Settings\SettingsManager::class);
    }
}
