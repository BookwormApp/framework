<?php namespace Bookworm\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider {

	/**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    	$this->app['view']->addLocation(__DIR__.'/../../../resources/views');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

}