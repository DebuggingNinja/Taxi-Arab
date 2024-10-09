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
        Schema::table('rides', function (Blueprint $table) {
            $table->foreign(['user_id'], 'rides_ibfk_1')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['driver_id'], 'rides_ibfk_2')->references(['id'])->on('drivers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['pickup_location_id'], 'rides_ibfk_3')->references(['id'])->on('locations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['dropoff_location_id'], 'rides_ibfk_4')->references(['id'])->on('locations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->dropForeign('rides_ibfk_1');
            $table->dropForeign('rides_ibfk_2');
            $table->dropForeign('rides_ibfk_3');
            $table->dropForeign('rides_ibfk_4');
        });
    }
};
