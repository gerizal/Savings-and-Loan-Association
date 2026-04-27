<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->string('akad')->nullable();
            $table->string('settlement')->nullable();
            $table->string('insurance')->nullable();
            $table->string('mutation')->nullable();
            $table->string('account_bank')->nullable();
            $table->string('account_bank_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('flagging')->nullable();
            $table->string('epotpen')->nullable();
            $table->string('disbursement')->nullable();
            $table->string('disbursement_video')->nullable();
            $table->string('disbursement_video_2')->nullable();
            $table->string('disbursement_video_3')->nullable();
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
        Schema::dropIfExists('application_files');
    }
}
