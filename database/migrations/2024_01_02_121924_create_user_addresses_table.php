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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_id')->nullable()->index('user_id');
            $table->enum('label', ['home', 'work', 'other'])->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('location_id')->nullable()->index('location_id');
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
        Schema::dropIfExists('user_addresses');
    }
};
