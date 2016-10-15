<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRecipientOnCommunicationLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('communication_log', function (Blueprint $table) {
            $table->dropColumn('sender');
            $table->integer('recipient_id')->unsigned()->nullable()->default(null)->after('respond_id');
            $table
                ->foreign('recipient_id')
                ->references('id')
                ->on('recipients')
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
            $table->dropForeign(['recipient_id']);
            $table->dropColumn('recipient_id');
            $table->text('sender')->after('respond_id');
        });
    }
}
