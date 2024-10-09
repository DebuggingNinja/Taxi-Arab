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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id('id');
            $table->string('name')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->string('otp', 6)->nullable();
            $table->string('national_id', 20)->nullable();
            $table->string('vehicle_registration_plate', 20)->nullable();
            $table->string('vehicle_manufacture_date', 4)->nullable();
            $table->string('vehicle_color')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_image')->nullable();
            $table->string('vehicle_license_image')->nullable();
            $table->string('personal_image')->nullable();
            $table->string('personal_license_image')->nullable();
            $table->string('personal_identification_card_image')->nullable();
            $table->string('personal_criminal_records_certificate_image')->nullable();
            $table->double('current_credit_amount')->nullable();
            $table->boolean('accepting_rides')->nullable();
            $table->unsignedBigInteger('latest_location_id')->nullable()->index('latest_location_id');
            $table->enum('acceptance_status', ['accepted', 'rejected', 'pending'])->nullable();
            $table->boolean('is_verified')->nullable();
            $table->boolean('is_blocked')->nullable();
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
        Schema::dropIfExists('drivers');
    }
};
