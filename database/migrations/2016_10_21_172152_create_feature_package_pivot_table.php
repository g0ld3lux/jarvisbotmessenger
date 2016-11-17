<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturePackagePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('feature_package', function (Blueprint $table) {
          $table->integer('feature_id')->unsigned();
          $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');
          $table->integer('package_id')->unsigned();
          $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
          $table->string('feature_description')->nullable();
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
        Schema::drop('feature_package');
    }
}
