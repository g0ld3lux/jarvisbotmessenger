<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFlowIdToLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('communication_log', function (Blueprint $table) {
            $table->integer('flow_id')->unsigned()->nullable(true)->default(null)->after('bot_id');
            $table
                ->foreign('flow_id')
                ->references('id')
                ->on('flows')
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
        Schema::table('communication_log', function (Blueprint $table) {
            $table->dropForeign(['flow_id']);
            $table->dropColumn('flow_id');
        });
    }
}
