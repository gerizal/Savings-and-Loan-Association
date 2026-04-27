<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->string('file')->nullable();
            $table->integer('admin_fee')->nullable();
            $table->text('description')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_bank_number')->nullable();
            $table->integer('remains')->nullable();
            $table->timestamp('date')->nullable();
            $table->enum('type',['topup','meninggal dunia','lepas'])->nullable();
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
        Schema::dropIfExists('settlements');
    }
}
