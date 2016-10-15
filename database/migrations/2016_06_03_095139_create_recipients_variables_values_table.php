<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipientsVariablesValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipients_variables_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('relation_id')->unsigned();
            $table->string('key')->index();
            $table->text('value');
            $table->integer('order');
            $table->nullableTimestamps();
            $table
                ->foreign('relation_id')
                ->references('id')
                ->on('recipients_variables_recipients')
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
        Schema::drop('recipients_variables_values');
    }
}
