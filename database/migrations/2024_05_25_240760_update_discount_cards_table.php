<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::table('discount_cards')->delete();
        Schema::table('discount_cards', function (Blueprint $table) {
            $table->dropColumn('used_at');
            $table->dropColumn('show_in_app');

            $table->date('valid_from')->nullable()->after('card_number');
            $table->date('valid_to')->nullable()->after('valid_from');
            $table->bigInteger('repeat_limit')->default(1)->after('valid_to');
            $table->bigInteger('charge_count')->default(0)->after('repeat_limit');
            $table->bigInteger('allow_user_to_reuse')->default(false)->after('charge_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discount_cards', function (Blueprint $table) {
            $table->dropColumn('valid_from');
            $table->dropColumn('valid_to');
            $table->dropColumn('repeat_limit');
            $table->dropColumn('charge_count');
            $table->dropColumn('allow_user_to_reuse');

            $table->date('used_at');
            $table->bigInteger('show_in_app')->default(false);
        });
    }
};
