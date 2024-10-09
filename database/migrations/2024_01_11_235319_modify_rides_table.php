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
            // Modify existing fields
            $table->renameColumn('distance', 'expected_distance');
            $table->renameColumn('fare', 'expected_total_fare');

            // Add new fields
            $table->double('actual_distance')->nullable();
            $table->time('actual_ride_duration')->nullable();
            $table->double('expected_driver_fare')->nullable();
            $table->double('expected_app_fare')->nullable();
            $table->double('actual_total_fare')->nullable();
            $table->double('actual_driver_fare')->nullable();
            $table->double('actual_app_fare')->nullable();
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
            // Reverse modifications
            $table->renameColumn('expected_distance', 'distance');
            $table->renameColumn('expected_total_fare', 'fare');

            // Remove added fields
            $table->dropColumn([
                'actual_distance',
                'actual_ride_duration',
                'expected_driver_fare',
                'expected_app_fare',
                'actual_total_fare',
                'actual_driver_fare',
                'actual_app_fare',
            ]);
        });
    }
};
