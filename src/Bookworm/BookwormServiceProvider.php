<?php

namespace Bookworm;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class BookwormServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $providers = [
        'AppServiceProvider',
        'ConfigServiceProvider',
        'ConsoleServiceProvider',
        'EventServiceProvider',
        'RouteServiceProvider',
        'ViewServiceProvider',
    ];

    protected $external = [
        'Origami\Notice\NoticeServiceProvider',
        'Origami\Seo\SeoServiceProvider',
        'Collective\Html\HtmlServiceProvider',
    ];

    protected $aliases = [
        'Seo' => 'Origami\Seo\SeoFacade',
        'Str' => 'Illuminate\Support\Str',
        'Form' => 'Collective\Html\FormFacade',
        'Html' => 'Collective\Html\HtmlFacade',
    ];

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        foreach ( $this->providers as $provider ) {
            $this->app->register('Bookworm\Providers\\'.$provider);
        }

        foreach ( $this->external as $provider ) {
            $this->app->register($provider);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $loader = AliasLoader::getInstance();

        foreach ( $this->aliases as $class => $alias) {
            $loader->alias($class, $alias);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}