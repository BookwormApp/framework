<?php namespace Bookworm\Providers;

use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider {

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
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerInstall();
        $this->registerUpdate();
    }

    private function registerInstall()
    {
        $this->app->singleton('command.bookworm.install', function($app)
        {
            return $app->make('Bookworm\Console\Commands\InstallCommand');
        });

        $this->commands('command.bookworm.install');
    }

    private function registerUpdate()
    {
        $this->app->singleton('command.bookworm.update', function($app)
        {
            return $app->make('Bookworm\Console\Commands\UpdateCommand');
        });

        $this->commands('command.bookworm.update');
    }

}