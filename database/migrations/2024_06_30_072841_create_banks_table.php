<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->decimal('administration_fee')->nullable();
            $table->decimal('coop_fee')->nullable();
            $table->decimal('interest')->nullable();
            $table->decimal('other_fee')->nullable();
            $table->decimal('management_fee')->nullable();
            $table->decimal('stamp_fee')->nullable();
            $table->decimal('account_opening_fee')->nullable();
            $table->decimal('installment_fee')->nullable();
            $table->decimal('flagging_fee')->nullable();
            $table->decimal('epotpen_fee')->nullable();
            $table->decimal('provision_fee')->nullable();
            $table->integer('round_off')->default(1);
            $table->boolean('is_syariah')->default(0);
            $table->text('logo')->nullable();
            $table->string('up_directur')->nullable();
            $table->string('directur')->nullable();
            $table->string('person_in_charge')->nullable();
            $table->string('account_officer')->nullable();
            $table->string('credit_review')->nullable();
            $table->string('head_of_credit')->nullable();
            $table->string('vice_chairman')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('position_checked')->nullable();
            $table->string('authorized_by')->nullable();
            $table->string('authorization_title')->nullable();
            $table->string('contract')->nullable();
            $table->text('contract_decision_letter')->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_flash')->default(0);
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
        Schema::dropIfExists('banks');
    }
}
