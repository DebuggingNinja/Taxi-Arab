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
        Schema::create('ride_tracking', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('ride_id')->nullable()->index('ride_id');
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->float('speed', 10, 0)->nullable();
            $table->timestamp('timestamp')->nullable();
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
        Schema::dropIfExists('ride_tracking');
    }
};
