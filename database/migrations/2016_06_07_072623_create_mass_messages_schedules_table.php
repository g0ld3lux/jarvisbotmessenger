<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMassMessagesSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mass_messages_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mass_message_id')->unsigned();
            $table->integer('recipient_id')->unsigned();
            $table->text('error')->nullable()->default(null);
            $table->dateTime('scheduled_at');
            $table->dateTime('sent_at')->nullable()->default(null);
            $table->dateTime('paused_at')->nullable()->default(null);
            $table->dateTime('started_at')->nullable()->default(null);
            $table->dateTime('finished_at')->nullable()->default(null);
            $table->dateTime('failed_at')->nullable()->default(null);
            $table->nullableTimestamps();
            $table
                ->foreign('mass_message_id')
                ->references('id')
                ->on('mass_messages')
                ->onDelete('cascade');
            $table
                ->foreign('recipient_id')
                ->references('id')
                ->on('recipients')
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
        Schema::drop('mass_messages_schedules');
    }
}
