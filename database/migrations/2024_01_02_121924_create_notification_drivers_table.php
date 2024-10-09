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
        Schema::create('notification_drivers', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('driver_id')->nullable()->index('driver_id');
            $table->unsignedBigInteger('notification_id')->nullable()->index('notification_id');
            $table->boolean('is_read')->nullable();
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
        Schema::dropIfExists('notification_drivers');
    }
};
