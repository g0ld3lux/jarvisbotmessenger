<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('statisticable');
            $table->string('key');
            $table->integer('value');
            $table->date('date_at');
            $table->nullableTimestamps();
            $table->unique(['statisticable_type', 'statisticable_id', 'key', 'date_at'], 'unique_date_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('statistics');
    }
}
