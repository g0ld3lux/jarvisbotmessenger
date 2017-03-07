<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMassMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mass_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bot_id')->unsigned();
            $table->string('name');
            $table->dateTime('scheduled_at');
            $table->dateTime('started_at')->nullable()->default(null);
            $table->dateTime('paused_at')->nullable()->default(null);
            $table->dateTime('finished_at')->nullable()->default(null);
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
        Schema::drop('mass_messages');
    }
}
