<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsOnBotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bots', function (Blueprint $table) {
            $table->dropColumn('app_token');
            $table->dropColumn('verification_token');
            $table->dropColumn('endpoint_token');
            $table->string('page_token')->nullable()->default(null)->after('title');
            $table->string('page_id')->nullable()->default(null)->after('title');
            $table->string('page_title')->nullable()->default(null)->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bots', function (Blueprint $table) {
            $table->dropColumn('page_title');
            $table->dropColumn('page_id');
            $table->dropColumn('page_token');
            $table->string('app_token')->nullable()->default(null);
            $table->string('verification_token')->nullable()->default(null);
            $table->string('endpoint_token')->nullable()->default(null);
        });
    }
}
