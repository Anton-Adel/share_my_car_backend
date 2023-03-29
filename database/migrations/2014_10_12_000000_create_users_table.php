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
            $table->string('first_name');
             $table->string('last_name');
            $table->string('gender');
            $table->string('age');
            $table->string('id_number')->unique();
            $table->string('personal_image');
            $table->string('card_image');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->string('phone_number')->unique();
            $table->boolean('have_car');
            $table->string('car_model')->nullable();
            $table->string('car_color')->nullable();
            $table->string('car_plate_number')->nullable();
            $table->string('car_image')->nullable();
            $table->string('car_plate_image')->nullable();
            $table->string('car_license_image')->nullable();
            $table->string('trip_gender');
            $table->boolean('smoke');
            $table->boolean('trip_smoke');
            $table->boolean('trip_music');
            $table->boolean('trip_conditioner');
            $table->boolean('trip_children');
            $table->boolean('trip_pets');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
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
