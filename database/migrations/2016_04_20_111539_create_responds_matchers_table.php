<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespondsMatchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responds_matchers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('respond_id')->unsigned();
            $table->integer('matcher_id')->unsigned();
            $table->nullableTimestamps();
            $table
                ->foreign('respond_id')
                ->references('id')
                ->on('responds')
                ->onDelete('cascade');
            $table
                ->foreign('matcher_id')
                ->references('id')
                ->on('matchers')
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
        Schema::drop('responds_matchers');
    }
}
