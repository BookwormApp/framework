<?php namespace Bookworm\Console\Commands;

use Illuminate\Console\Command;
use Bookworm\Events\UserCreated;
use Bookworm\Users\UserRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Schema;
use Illuminate\Console\ConfirmableTrait;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InstallCommand extends Command {

    use ConfirmableTrait;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'bookworm:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run migration and installation for bookworm';
    /**
     * @var \Illuminate\Foundation\Application
     */
    private $app;

    protected $user;

    /**
     * Create a new command instance.
     *
     * @param Application $app
     */
	public function __construct(Application $app, UserRepository $user)
	{
		parent::__construct();

        $this->app = $app;
        $this->user = $user;
    }

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        if ( ! $this->confirmToProceed('Database already installed', function() { return Schema::hasTable('migrations'); })) return;

        // Copy the migrations, etc.
        $this->info('Copying migrations');
        $this->call('vendor:publish', ['--provider' => 'Bookworm\Providers\AppServiceProvider', '--tag' => ['migrations']]);

        $this->info('Copying assets');
        $this->call('vendor:publish', ['--provider' => 'Bookworm\Providers\AppServiceProvider', '--tag' => ['assets']]);

        if ( Schema::hasTable('migrations') ) {
            $this->call('migrate:reset', ['--force']);
        }

		// Migrate the database
        $this->info('Migrating the database');
        $this->call('migrate', ['--force']);

        $this->createUser();

        // Install the database
        $this->info('Seeding the database');
        $this->getSeeder()->run();
	}

	protected function createUser()
	{
		$name = $this->ask('Your name (initial user)');
		$email = $this->ask('Your e-mail (initial user)');
		$password = $this->secret('Create password (initial user');

		$user = $this->user->create([
			'name' => $name,
			'email' => $email,
			'password' => $password
		]);

		event(new UserCreated($user));

		return $user;
	}

    /**
     * Get a seeder instance from the container.
     *
     * @return \Illuminate\Database\Seeder
     */
    protected function getSeeder()
    {
        $class = $this->app->make('Bookworm\Database\Install');

        return $class->setContainer($this->app)->setCommand($this);
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
            array('force', null, InputOption::VALUE_NONE, 'Force the operation to run when already installed.'),
        );
	}

}
