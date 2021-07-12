<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterestSubCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interest_sub_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('interest_category_id');
            $table->foreign('interest_category_id')->references('id')->on('interest_category');
            $table->string('interest_sub_category_name');
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
        Schema::dropIfExists('interest_sub_category');
    }
}
