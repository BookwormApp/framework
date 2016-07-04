<?php

namespace Bookworm\Providers;

use Bookworm\Http\Composers\CaseOptionsComposer;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->app['view']->addLocation(__DIR__.'/../../../resources/views');

        $this->app['view']->composer('cases.form', CaseOptionsComposer::class);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
    }
}
