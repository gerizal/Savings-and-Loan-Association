<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDroppingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('droppings', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->unsignedInteger('bank_id')->nullable();
            $table->string('file')->nullable();
            $table->string('evidence')->nullable();
            $table->integer('plafond')->nullable();
            $table->integer('dropping')->nullable();
            $table->integer('debitur')->nullable();
            $table->enum('status',['queue','on process','approve', 'reject', 'pending'])->nullable();
            $table->timestamp('date')->nullable();
            $table->timestamp('disbursement_date')->nullable();
            $table->timestamps();
        });

        Schema::table('disbursements', function (Blueprint $table) {
            $table->unsignedInteger('dropping_id')->nullable();
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->unsignedInteger('dropping_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('droppings');
        Schema::table('disbursements', function (Blueprint $table) {
            $table->dropColumn(['dropping_id']);
        });
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['dropping_id']);
        });
    }
}
