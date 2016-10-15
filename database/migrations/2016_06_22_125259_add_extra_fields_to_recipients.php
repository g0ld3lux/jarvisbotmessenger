<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraFieldsToRecipients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipients', function (Blueprint $table) {
            $table->string('timezone')->nullable()->default(null)->after('last_name');
            $table->string('gender', 60)->nullable()->default(null)->after('last_name');
            $table->string('locale', 60)->nullable()->default(null)->after('last_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipients', function (Blueprint $table) {
            $table->dropColumn('timezone');
            $table->dropColumn('gender');
            $table->dropColumn('locale');
        });
    }
}
