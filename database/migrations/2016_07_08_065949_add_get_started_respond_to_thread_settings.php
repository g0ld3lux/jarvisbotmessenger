<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGetStartedRespondToThreadSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('thread_settings', function (Blueprint $table) {
            $table->integer('get_started_respond_id')->unsigned()->nullable()->default(null)->after('greeting_text');
            $table
                ->foreign('get_started_respond_id')
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
        Schema::table('thread_settings', function (Blueprint $table) {
            $table->dropForeign(['get_started_respond_id']);
            $table->dropColumn('get_started_respond_id');
        });
    }
}
