<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchersParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matchers_params', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('matcher_id')->unsigned();
            $table->integer('order')->default(0);
            $table->string('key');
            $table->string('value');
            $table->nullableTimestamps();
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
        Schema::drop('matchers_params');
    }
}
