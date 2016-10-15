<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespondsTaxonomiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responds_taxonomies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('respond_id')->unsigned();
            $table->integer('order')->default(0);
            $table->string('type');
            $table->nullableTimestamps();
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
        Schema::drop('responds_taxonomies');
    }
}
