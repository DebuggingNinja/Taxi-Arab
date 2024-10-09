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
            $table->text('cancellation_reason')->nullable();
            $table->double('price_before_discount')->nullable();
            $table->boolean('discount_enabled')->default(false);
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
            $table->dropColumn('cancellation_reason');
            $table->dropColumn('price_before_discount');
            $table->dropColumn('discount_enabled');
        });
    }
};
