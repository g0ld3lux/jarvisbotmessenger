<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFlowIdToMatchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matchers', function (Blueprint $table) {
            $table->integer('flow_id')->unsigned()->after('id');
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
        Schema::table('matchers', function (Blueprint $table) {
            $table->dropForeign(['flow_id']);
            $table->dropColumn('flow_id');
        });
    }
}
