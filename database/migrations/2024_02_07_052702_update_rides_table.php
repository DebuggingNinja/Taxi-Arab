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
        // Remove old status enum
        Schema::table('rides', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Add new status enum with additional value
        Schema::table('rides', function (Blueprint $table) {
            $table->enum('status', ['pending', 'accepted', 'at_pickup', 'ongoing',  'completed', 'cancelled'])
                ->default('pending')
                ->after('driver_id');
        });

        // Add new fields in the rides table
        Schema::table('rides', function (Blueprint $table) {
            $table->timestamp('driver_pickup_at')->nullable()->after('status');
            $table->foreignId('driver_pickup_location_id')->nullable()->constrained('locations')->after('driver_pickup_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Reverse the changes if needed
        Schema::table('rides', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('driver_pickup_at');
            $table->dropForeign(['driver_pickup_location_id']);
            $table->dropColumn('driver_pickup_location_id');
        });

        // Recreate the old status enum
        Schema::table('rides', function (Blueprint $table) {
            $table->enum('status', ['pending', 'ongoing', 'accepted', 'completed', 'cancelled'])
                ->default('pending')
                ->after('driver_id');
        });
    }
};
