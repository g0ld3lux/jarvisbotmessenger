<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thread_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bot_id')->unsigned();
            $table->text('greeting_text')->nullable()->default(null);
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
        Schema::drop('thread_settings');
    }
}
