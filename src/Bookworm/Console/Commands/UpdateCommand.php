<?php namespace Bookworm\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateCommand extends Command {

    use ConfirmableTrait;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'bookworm:update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run migration and updates for bookworm';

    /**
     * @var \Illuminate\Foundation\Application
     */
    private $app;

    /**
     * Create a new command instance.
     *
     * @param Application $app
     */
	public function __construct(Application $app)
	{
		parent::__construct();

        $this->app = $app;
    }

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        if ( ! $this->confirmToProceed() ) return;

        // Copy the migrations, etc.
        $this->info('Copying migrations');
        $this->call('vendor:publish', ['--provider' => 'Bookworm\Providers\AppServiceProvider', '--tag' => ['migrations']]);

		// Migrate the database
        $this->info('Migrating the database');
        $this->call('migrate', ['--force']);

		$this->info('Copying assets');
		$this->call('vendor:publish', ['--provider' => 'Bookworm\Providers\AppServiceProvider', '--tag' => ['assets']]);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
        return array(
            array('force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'),
        );
	}

}
