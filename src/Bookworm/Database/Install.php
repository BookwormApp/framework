<?php namespace Bookworm\Database;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class Install extends Seeder {

    protected $installers = [
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        foreach ( $this->installers as $installer ) {
            $this->call('Bookworm\Database\Install\\'.$installer);
        }
    }

}
