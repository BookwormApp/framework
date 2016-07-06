<?php

namespace Bookworm\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $config = [
        'site',
        'cases',
    ];

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config' => config_path(),
        ]);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        foreach ($this->config as $config) {
            $this->mergeConfigFrom(
                __DIR__.'/../../config/'.$config.'.php', $config
            );
        }
    }
}
