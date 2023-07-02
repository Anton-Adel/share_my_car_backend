<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
           $table->id();
           $table->string('start_location');
           $table->string('end_location');
           $table->time('start_time');
           $table->time('end_time')->nullable();
           $table->date('start_date');
           $table->integer('shared_seats')->nullable();
           $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
           $table->string('user_cluster');
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
        Schema::dropIfExists('trips');
    }
}
