<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsThemeInCreatePoll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('create_poll', function (Blueprint $table) {
            $table->integer('is_theme')->default(0)->after('poll_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('create_poll', function (Blueprint $table) {
            $table->dropColumn('is_theme');
        });
    }
}
