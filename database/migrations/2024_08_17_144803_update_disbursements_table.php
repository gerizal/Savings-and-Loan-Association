<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDisbursementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('disbursements', function (Blueprint $table) {
            $table->unsignedInteger('bank_id')->nullable();
            $table->string('si_file')->nullable();
            $table->string('transfer_evidence')->nullable();
            $table->boolean('is_active')->nullable();
            $table->string('reference_number')->nullable();
            $table->boolean('disbursement_status')->nullable();
            $table->string('si_file_date')->nullable();
            $table->string('transfer_evidence_date')->nullable();
            $table->string('print_date')->nullable();
            $table->string('process_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('disbursements', function (Blueprint $table) {
            $table->dropColumn(['bank_id','si_file','transfer_evidence','is_active','reference_number','disbursement_status','si_file_date','transfer_evidence_date','print_date','process_date']);
        });
    }
}
