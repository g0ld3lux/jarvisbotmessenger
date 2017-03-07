<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunicationLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communication_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bot_id')->unsigned();
            $table->integer('respond_id')->unsigned()->nullable(true)->default(null);
            $table->text('sender');
            $table->text('message');
            $table->nullableTimestamps();
            $table
                ->foreign('bot_id')
                ->references('id')
                ->on('bots')
                ->onDelete('cascade');
            $table
                ->foreign('respond_id')
                ->references('id')
                ->on('responds')
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
        Schema::drop('communication_log');
    }
}
