<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsChannelsBroadcastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions_channels_broadcasts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('channel_id')->unsigned();
            $table->integer('respond_id')->unsigned();
            $table->text('name');
            $table->dateTime('scheduled_at');
            $table->dateTime('started_at')->nullable()->default(null);
            $table->dateTime('paused_at')->nullable()->default(null);
            $table->dateTime('finished_at')->nullable()->default(null);
            $table->nullableTimestamps();
            $table
                ->foreign('channel_id')
                ->references('id')
                ->on('subscriptions_channels')
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
        Schema::drop('subscriptions_channels_broadcasts');
    }
}
