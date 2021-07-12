<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPollIdInPollInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poll_invites', function (Blueprint $table) {
            $table->unsignedBigInteger('poll_id')->after('poll_owner_id');
            $table->foreign('poll_id')->references('id')->on('create_poll');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poll_invites', function (Blueprint $table) {
            $table->dropColumn('poll_id');
        });
    }
}
