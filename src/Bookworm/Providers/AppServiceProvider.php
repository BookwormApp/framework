<?php namespace Bookworm\Providers;

use Bookworm\Bookworm;
use Bookworm\Support\Shortlist;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

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
        $this->publishMigrations();
        $this->publishAssets();
    }

    private function publishMigrations()
    {
        $migrations_path = ( method_exists($this->app, 'databasePath') ? $this->app->databasePath().'/migrations' : base_path('database/migrations') );

        $this->publishes([
            __DIR__ . '/../../database/migrations' => $migrations_path,
        ], 'migrations');
    }

    private function publishAssets()
    {
        $public_path = public_path();
        $assets_path = base_path().'/resources/assets';

        $this->publishes([
            __DIR__.'/../../../public/assets' => $public_path.'/assets',
            __DIR__.'/../../../resources/assets/sass' => $assets_path.'/sass',
        ], 'assets');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHelper();
        $this->registerVersion();
        $this->registerLang();
    }

    private function registerHelper()
    {
        $this->app->singleton('bookworm', function()
        {
            $path = realpath(__DIR__.'/../../..');
            return new Bookworm($path);
        });
    }

    private function registerVersion()
    {
        $this->app['events']->listen("composing: admin.partials.sidebar", function()
        {
            echo '<p class="sidebar-powered-by">Powered by Bookworm <span class="sidebar-version">Version '.app('bookworm')->version().'</span></p>';
        });
    }

    private function registerLang()
    {
        $this->loadTranslationsFrom(__DIR__.'/../../../resources/lang', 'ds');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('bookworm');
    }

}