<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallmentSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installment_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->integer('number');
            $table->integer('amount');
            $table->integer('primary_loan');
            $table->integer('margin');
            $table->integer('margin_bank');
            $table->integer('colfee');
            $table->boolean('status')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->timestamp('settlement_date')->nullable();
            $table->integer('remains');
            $table->softDeletes();
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
        Schema::dropIfExists('installment_schedules');
    }
}
