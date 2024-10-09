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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('name')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->string('otp', 6)->nullable();
            $table->integer('points')->nullable();
            $table->unsignedBigInteger('latest_location_id')->nullable()->index('latest_location_id');
            $table->string('profile_image')->nullable();
            $table->boolean('is_verified')->nullable();
            $table->boolean('is_blocked')->nullable();
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
};
