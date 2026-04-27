<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('loan_applications');
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('taspen_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('finance_type_id');
            $table->unsignedInteger('service_unit_id');
            $table->unsignedInteger('branch_unit_id');
            $table->string('id_number');
            $table->decimal('interest')->nullable();
            $table->integer('mutation_fee')->nullable();
            $table->integer('insurance_fee')->nullable();
            $table->integer('tenor');
            $table->integer('plafon');
            $table->integer('administration_fee')->nullable();
            $table->decimal('coop_fee')->nullable();
            $table->decimal('other_fee')->nullable();
            $table->integer('management_fee')->nullable();
            $table->integer('stamp_fee')->nullable();
            $table->integer('account_opening_fee')->nullable();
            $table->decimal('installment_fee')->nullable();
            $table->integer('flagging_fee')->nullable();
            $table->integer('epotpen_fee')->nullable();
            $table->integer('provision_fee')->nullable();
            $table->integer('bpp_fee')->nullable();
            $table->integer('repayment_fee')->nullable();
            $table->integer('block_installment')->nullable();
            $table->integer('round_off')->default(1);
            $table->boolean('is_flash')->default(0);
            $table->string('original_paymaster')->nullable();
            $table->string('destination_paymaster')->nullable();
            $table->integer('previous_loan')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_bank_number')->nullable();
            $table->unsignedInteger('marketing_id')->nullable();
            $table->string('fronting_agent')->nullable();
            $table->unsignedInteger('referral_id')->nullable();
            $table->string('interest_type')->nullable();
            $table->decimal('referral_fee')->nullable();
            $table->text('purpose')->nullable();
            $table->text('other_purpose')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('applications');
    }
}
