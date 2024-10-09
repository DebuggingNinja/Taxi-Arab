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
        Schema::create('driver_charge_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->nullable()->references('id')
                ->on('drivers')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('admin_id')->nullable()->references('id')
                ->on('admins')->cascadeOnUpdate()->nullOnDelete();
            $table->double('amount')->nullable();
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
        Schema::dropIfExists('drivers_charge_logs');
    }
};
