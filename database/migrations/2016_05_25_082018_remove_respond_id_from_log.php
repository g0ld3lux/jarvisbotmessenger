<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveRespondIdFromLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('communication_log', function (Blueprint $table) {
            $table->dropForeign(['respond_id']);
            $table->dropColumn('respond_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('communication_log', function (Blueprint $table) {
            $table->integer('respond_id')->unsigned()->nullable(true)->default(null)->after('project_id');
            $table
                ->foreign('respond_id')
                ->references('id')
                ->on('responds')
                ->onDelete('cascade');
        });
    }
}
