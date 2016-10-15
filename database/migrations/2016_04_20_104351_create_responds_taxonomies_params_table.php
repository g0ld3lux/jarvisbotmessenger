<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespondsTaxonomiesParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responds_taxonomies_params', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('respond_taxonomy_id')->unsigned();
            $table->integer('order')->default(0);
            $table->string('key');
            $table->string('value');
            $table->nullableTimestamps();
            $table
                ->foreign('respond_taxonomy_id')
                ->references('id')
                ->on('responds_taxonomies')
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
        Schema::drop('responds_taxonomies_params');
    }
}
