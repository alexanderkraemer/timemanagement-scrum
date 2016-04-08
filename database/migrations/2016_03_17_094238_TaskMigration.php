<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaskMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sprint_id')->unsigned();
            $table->string('nr');
            $table->string('name');
            $table->string('estimatedtime');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sprint_id')->references('id')->on('sprint');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('task');
    }
}
