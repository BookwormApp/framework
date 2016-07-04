<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BwCreateUsersTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('users', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('ref', 20)->unique();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->boolean('active')->default(1);
            $table->string('avatar')->nullable();
            $table->timestamp('previous_login')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();

            $table->softDeletes();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('users');
    }

}
