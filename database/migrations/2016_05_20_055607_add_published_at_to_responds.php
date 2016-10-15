<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublishedAtToResponds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('responds', function (Blueprint $table) {
            $table->dateTime('published_at')->nullable()->default(null)->after('match_type');
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
            $table->dropColumn('published_at');
        });
    }
}
