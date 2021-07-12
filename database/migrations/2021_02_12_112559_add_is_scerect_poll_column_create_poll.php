<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsScerectPollColumnCreatePoll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('create_poll', function (Blueprint $table) {
            $table->integer('is_secret')->default(0)->after('repoll_count')->comment('1 for Secret, 0  for normal');
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
            $table->dropColumn('is_secret');
        });
    }
}
