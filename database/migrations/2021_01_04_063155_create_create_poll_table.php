<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreatePollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_poll', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('interest_category_id')->nullable();
            $table->foreign('interest_category_id')->references('id')->on('interest_category');
             $table->unsignedBigInteger('interest_sub_category_id')->nullable();
            $table->foreign('interest_sub_category_id')->references('id')->on('interest_sub_category');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('generic_title');
            $table->enum('poll_type_id', ['1', '2', '3', '4', '5', '6'])->comment('1 = Pic One, 2 = Thumbs Up / Thumbs Down, 3 = Yes / No, 4 = Heat-O-Meter, 5 = Rank In Order, 6 = Sorting');
            $table->enum('no_of_option', ['1', '2', '3', '4', '5']);
            $table->foreign('color_palette_id')->references('id')->on('color_palette');
             $table->unsignedBigInteger('color_palette_id')->nullable();
             $table->boolean('is_light')->default(0)->comment('1 = Light, 0 = Dark');
             $table->enum('poll_style_id', ['1', '2', '3', '4'])->comment('1 = Text, 2 = Image, 3 = Music, 4 = Video');
            $table->string('background')->nullable();
             $table->boolean('is_background_image')->default(0)->comment('1 = Yes, 0 = No');
            $table->integer('template_id')->comment('0 = Other');
            $table->dateTime('launch_date_time');
            $table->boolean('forever_status')->default(0)->comment('0 = Limited time poll, 1 = Infinite poll');
            $table->string('set_duration')->nullable();
            $table->boolean('poll_privacy')->default(0)->comment('0 = Public, 1 = Private');
            $table->enum('chart_id', ['1', '2', '3'])->comment('1 = Donut Chart, 2 = Pie Chart, 3 = Bar Chart');
            $table->boolean('share_status')->default(0)->comment('0 = Share Disable, 1 = Share Enable');
            $table->boolean('status')->default(1)->comment('1 = Active, 0 = Inactive');
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
        Schema::dropIfExists('create_poll');
    }
}
