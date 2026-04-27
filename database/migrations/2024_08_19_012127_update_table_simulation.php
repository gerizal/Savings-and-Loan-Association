<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableSimulation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('simulations', function (Blueprint $table) {
            $table->date('simulation_date')->nullable();
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('day')->nullable();
            $table->integer('max_tenor')->nullable();
            $table->integer('max_angsuran')->nullable();
            $table->integer('max_plafon')->nullable();
            $table->integer('angsuran')->nullable();
            $table->integer('administration_fee')->nullable();
            $table->integer('management_fee')->nullable();
            $table->integer('insurance_fee')->nullable();
            $table->integer('account_opening_fee')->nullable();
            $table->integer('stamp_fee')->nullable();
            $table->integer('information_fee')->nullable();
            $table->integer('mutation_fee')->nullable();
            $table->integer('provision_fee')->nullable();
            $table->integer('block_installments')->nullable();
            $table->integer('gross_amount')->nullable();
            $table->integer('net_amount')->nullable();
            $table->integer('rest_salary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('simulations', function (Blueprint $table) {
            $table->dropColumn([
                'simulation_date',
                'year',
                'month',
                'day',
                'max_tenor',
                'max_angsuran',
                'max_plafon',
                'angsuran',
                'administration_fee',
                'management_fee',
                'insurance_fee',
                'account_opening_fee',
                'stamp_fee',
                'information_fee',
                'mutation_fee',
                'provision_fee',
                'block_installments',
                'gross_amount',
                'net_amount',
                'rest_salary'
            ]);
        });
    }
}
