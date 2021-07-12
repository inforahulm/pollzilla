<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poll_invites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poll_owner_id');
            $table->foreign('poll_owner_id')->references('id')->on('users');
            $table->integer('group_or_user_id');
            $table->boolean('is_group')->default(0)->comment('1 = Is it a group user id, 0 = Normal user id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poll_invites');
    }
}
