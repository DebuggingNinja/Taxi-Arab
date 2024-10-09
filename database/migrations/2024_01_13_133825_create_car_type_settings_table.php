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
        Schema::create('car_type_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_type_id')->nullable();
            $table->string('key_name');
            $table->text('value')->nullable();
            $table->timestamps();
            // Define foreign key constraint
            $table->foreign('car_type_id')
                ->references('id')
                ->on('car_types') // Replace 'car_types' with the actual table name you're referencing
                ->onDelete('cascade'); // You can adjust onDelete as needed (cascade, set null, restrict, etc.)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_type_settings');
    }
};
