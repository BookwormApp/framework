<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BwCreateCasesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('ref', 10)->unique();
            $table->integer('project_id')->unsigned()->nullable()->index();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('assigned_to')->unsigned()->nullable();
            $table->integer('completed_by')->unsigned()->nullable();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('status');
            $table->string('type')->index();
            $table->string('priority')->nullable();
            $table->timestamp('due_at');
            $table->boolean('completed')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->foreign('completed_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('case_user', function(Blueprint $table)
        {
            $table->integer('case_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('case_id')->references('id')->on('cases');
            $table->foreign('user_id')->references('id')->on('users');
            $table->primary(['case_id','user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('case_user');
        Schema::drop('cases');
    }
}
