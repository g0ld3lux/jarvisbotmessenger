<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipientsVariablesRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipients_variables_recipients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('recipient_variable_id')->unsigned();
            $table->integer('recipient_id')->unsigned();
            $table->nullableTimestamps();
            $table
                ->foreign('recipient_variable_id')
                ->references('id')
                ->on('recipients_variables')
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
        Schema::drop('recipients_variables_recipients');
    }
}
