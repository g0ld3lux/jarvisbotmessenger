<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMassMessagesRespondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mass_messages_responds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mass_message_id')->unsigned();
            $table->integer('respond_id')->unsigned();
            $table->nullableTimestamps();
            $table
                ->foreign('mass_message_id')
                ->references('id')
                ->on('mass_messages')
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
        Schema::drop('mass_messages_responds');
    }
}
