<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChangeIslinkInPollAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poll_answer', function (Blueprint $table) {
           $table->boolean('is_link')->default(0)->comment('1 = Yes Link, 0 = No Link')->change();
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
            //
        });
    }
}
