<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPollCuurentStatusInCreatePoll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('create_poll', function (Blueprint $table) {
            $table->integer('poll_current_status')->default(3)->after('repoll_count')->comment('1 for runing, 2  for end  poll,3 for upcomming poll,41 repoll runing,42 rollpoll end ,43 repoll upcomming');
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
            $table->dropColumn('poll_current_status');
        });
    }
}
