<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('packages', function (Blueprint $table) {
          $table->increments('id');
          $table->string('plan', 30)->unique();
          $table->string('name', 30);
          $table->decimal('cost', 7, 2);
          $table->string('currency_code', 4)->default('USD');
          $table->enum('per', ['month', 'year','lifetime'])->default('month');
          $table->boolean('active')->default(0);
          $table->boolean('featured')->default(0);
          $table->integer('order')->nullable();
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('packages');
    }
}
