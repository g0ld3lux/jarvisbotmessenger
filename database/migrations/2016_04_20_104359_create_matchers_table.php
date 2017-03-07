<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matchers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bot_id')->unsigned();
            $table->string('title');
            $table->string('type');
            $table->nullableTimestamps();
            $table
                ->foreign('bot_id')
                ->references('id')
                ->on('bots')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('matchers');
    }
}
