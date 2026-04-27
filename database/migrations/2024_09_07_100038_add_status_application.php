<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusApplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->enum('verification_status',['queue','on process','approve', 'reject', 'pending'])->nullable();
            $table->enum('approval_status',['queue','on process','approve', 'reject', 'pending'])->nullable();
            $table->enum('disbursement_status',['queue','on process','approve', 'reject', 'pending'])->nullable();
            $table->enum('settlement_status',['queue','on process','approve', 'reject', 'pending'])->nullable();
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
                'verification_status',
                'approval_status',
                'disbursement_status',
                'settlement_status'
            ]);
        });
    }
}
