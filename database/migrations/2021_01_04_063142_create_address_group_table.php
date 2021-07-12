<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_group', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_owner_id')->nullable();
            $table->foreign('group_owner_id')->references('id')->on('users');
            $table->string('group_join_user_ids')->nullable();
            $table->string('group_name');
            $table->string('group_icon')->nullable();
            $table->boolean('status')->default(0)->comment('1 = Active, 0 = Inactive');
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
        Schema::dropIfExists('address_group');
    }
}
