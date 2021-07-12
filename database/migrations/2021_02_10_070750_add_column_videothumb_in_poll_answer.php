<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnVideothumbInPollAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poll_answer', function (Blueprint $table) {
             $table->string('video_thumb')->nullable()->after('is_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poll_answer', function (Blueprint $table) {
            $table->dropColumn('video_thumb');
        });
    }
}
