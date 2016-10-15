<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPersistentMenuToThreadSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('thread_settings', function (Blueprint $table) {
            $table
                ->integer('persistent_menu_respond_id')
                ->unsigned()
                ->nullable()
                ->default(null)
                ->after('get_started_respond_id');
            $table
                ->foreign('persistent_menu_respond_id')
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
            $table->dropForeign(['persistent_menu_respond_id']);
            $table->dropColumn('persistent_menu_respond_id');
        });
    }
}
