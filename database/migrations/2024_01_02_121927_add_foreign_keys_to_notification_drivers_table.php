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
        Schema::table('notification_drivers', function (Blueprint $table) {
            $table->foreign(['driver_id'], 'notification_drivers_ibfk_1')->references(['id'])->on('drivers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['notification_id'], 'notification_drivers_ibfk_2')->references(['id'])->on('notifications')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notification_drivers', function (Blueprint $table) {
            $table->dropForeign('notification_drivers_ibfk_1');
            $table->dropForeign('notification_drivers_ibfk_2');
        });
    }
};
