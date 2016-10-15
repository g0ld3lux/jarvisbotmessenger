<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsChannelsRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions_channels_recipients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('channel_id')->unsigned();
            $table->integer('recipient_id')->unsigned();
            $table->string('type')->nullable()->default(null);
            $table->nullableTimestamps();
            $table->unique(['channel_id', 'recipient_id']);
            $table
                ->foreign('channel_id')
                ->references('id')
                ->on('subscriptions_channels')
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
        Schema::drop('subscriptions_channels_recipients');
    }
}
