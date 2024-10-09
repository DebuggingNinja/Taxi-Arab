<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_id')->nullable()->index('user_id');
            $table->unsignedBigInteger('driver_id')->nullable()->index('driver_id');
            $table->double('driver_distance_from_pickup')->nullable();
            $table->double('distance')->nullable();
            $table->unsignedBigInteger('pickup_location_id')->nullable()->index('pickup_location_id');
            $table->dateTime('pickup_datetime')->nullable();
            $table->unsignedBigInteger('dropoff_location_id')->nullable()->index('dropoff_location_id');
            $table->dateTime('dropoff_datetime')->nullable();
            $table->time('expected_ride_duration')->nullable();
            $table->double('fare')->nullable();
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
        Schema::dropIfExists('rides');
    }
};
