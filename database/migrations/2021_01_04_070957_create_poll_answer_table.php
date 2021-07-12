<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poll_answer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poll_id')->nullable();
            $table->foreign('poll_id')->references('id')->on('create_poll');
            $table->string('poll_text_answer')->nullable();
            $table->string('poll_source_answer')->nullable();
            $table->string('poll_display_answer')->nullable();
            $table->string('is_link')->nullable();
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
        Schema::dropIfExists('poll_answer');
    }
}
