<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('day')->nullable();
            $table->integer('max_tenor')->nullable();
            $table->integer('max_installment')->nullable();
            $table->integer('max_plafon')->nullable();
            $table->integer('information_fee')->nullable();
            $table->integer('blockir_fee')->nullable();
            $table->integer('total_cost')->nullable();
            $table->integer('gross_amount')->nullable();
            $table->integer('net_amount')->nullable();
            $table->integer('rest_salary')->nullable();
            $table->integer('primary_loan')->nullable();
            $table->integer('margin')->nullable();
            $table->integer('bank_installment')->nullable();
            $table->integer('col_fee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'year',
                'month',
                'day',
                'max_tenor',
                'max_installment',
                'max_plafon',
                'information_fee',
                'blockir_fee',
                'gross_amount',
                'net_amount',
                'rest_salary',
                'total_cost',
                'primary_loan',
                'margin',
                'bank_installment',
                'col_fee',
            ]);
        });
    }
}
