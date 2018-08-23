<?php

namespace FlickerLeap\Clickatell;

use Clickatell\Rest;
use FlickerLeap\Clickatell\Exceptions\ConfigError;
use Illuminate\Support\ServiceProvider;

class ClickatellServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/services.php',
            'services'
        );

        $this->app->when(ClickatellChannel::class)
            ->needs(ClickatellClient::class)
            ->give(function () {
                if (!config('services.clickatell.api_key')) {
                    throw ConfigError::configNotSet('services.clickatell.api_key', 'CLICKATELL_TOKEN');
                }

                return new ClickatellClient(new Rest(config('services.clickatell.api_key')));
            });
    }
}
