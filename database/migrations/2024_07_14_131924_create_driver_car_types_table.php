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
        Schema::create('driver_car_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->references('id')
                ->on('drivers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('car_type_id')->references('id')
                ->on('car_types')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::table('driver_car_types', function (Blueprint $table) {
            $table->dropForeign(['driver_id']);
            $table->dropForeign(['car_type_id']);
        });
        Schema::dropIfExists('driver_car_types');
    }
};
