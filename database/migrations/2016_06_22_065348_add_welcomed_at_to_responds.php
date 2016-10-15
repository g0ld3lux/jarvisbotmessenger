<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWelcomedAtToResponds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('responds', function (Blueprint $table) {
            $table->dateTime('welcomed_at')->nullable()->default(null)->after('published_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('responds', function (Blueprint $table) {
            $table->dropColumn('welcomed_at');
        });
    }
}
