<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('email')->unique();
            $table->string('otp')->nullable();
            $table->string('password')->nullable();
            $table->boolean('verify_status')->default(0)->comment('1 = Verify, 0 = No');
            $table->string('first_name')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('birthdate')->nullable();
            $table->enum('gender', ['1', '2', '3'])->comment('1 = Male, 2 = Female, 3 = Other');
            $table->string('profile_picture')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('country');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('state');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('city');
            $table->string('company_name')->nullable();
            $table->string('school_name')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('interest_sub_category_ids')->nullable();
            $table->longText('following_user_ids')->nullable();
            $table->longText('follower_user_ids')->nullable();
            $table->enum('social_types', ['1', '2', '3', '4', '5'])->comment('1 = Normal, 2 = Facebook, 3 = Google, 4 = Apple, 5 = Twitter');
            $table->text('social_id')->nullable();
            $table->enum('device_type', ['1', '2'])->comment('0 = IOS, 1 = Android');
            $table->longText('device_token')->nullable();
            $table->boolean('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->string('current_version')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
