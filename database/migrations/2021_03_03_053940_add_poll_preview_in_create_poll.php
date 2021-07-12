<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPollPreviewInCreatePoll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('create_poll', function (Blueprint $table) {
            $table->string('poll_preview')->nullable()->after('is_secret');
            $table->string('poll_time')->nullable()->after('is_secret');
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
            $table->dropColumn('poll_preview');
        });
    }
}
