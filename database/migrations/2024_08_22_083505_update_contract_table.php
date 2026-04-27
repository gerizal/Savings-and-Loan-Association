<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->timestamp('settlement_date')->nullable();
        });
        Schema::table('applications', function (Blueprint $table) {
            $table->integer('bank_id')->nullable();
            $table->boolean('is_paid')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn([
                'settlement_date',
            ]);
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'bank_id',
                'is_paid',
            ]);
        });
    }
}
