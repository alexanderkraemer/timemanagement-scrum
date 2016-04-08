<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTaskMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usertask', function (Blueprint $table) {
            $table->integer('task_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->primary(['task_id', 'user_id']);


            $table->foreign('task_id')->references('id')->on('task');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('usertask');
    }
}
