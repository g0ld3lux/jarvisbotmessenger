<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlowsRespondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flows_responds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('flow_id')->unsigned();
            $table->integer('respond_id')->unsigned();
            $table->nullableTimestamps();
            $table
                ->foreign('flow_id')
                ->references('id')
                ->on('flows')
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
        Schema::drop('flows_responds');
    }
}
