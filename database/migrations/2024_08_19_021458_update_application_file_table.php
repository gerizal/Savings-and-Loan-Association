<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApplicationFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_files', function (Blueprint $table) {
            $table->timestamp('akad_date')->nullable();
            $table->timestamp('settlement_date')->nullable();
            $table->string('guarantee')->nullable();
            $table->timestamp('guarantee_date')->nullable();
            $table->timestamp('mutation_date')->nullable();
            $table->timestamp('account_bank_date')->nullable();
            $table->timestamp('flagging_date')->nullable();
            $table->timestamp('epotpen_date')->nullable();
            $table->timestamp('disbursement_date')->nullable();
            $table->timestamp('disbursement_video_date')->nullable();
            $table->timestamp('disbursement_video_2_date')->nullable();
            $table->timestamp('disbursement_video_3_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application_files', function (Blueprint $table) {
            $table->dropColumn([
                'akad_date',
                'settlement_date',
                'guarantee',
                'guarantee_date',
                'mutation_date',
                'account_bank_date',
                'flagging_date',
                'epotpen_date',
                'disbursement_date',
                'disbursement_video_date',
                'disbursement_video_2_date',
                'disbursement_video_3_date',
            ]);
        });
    }
}
