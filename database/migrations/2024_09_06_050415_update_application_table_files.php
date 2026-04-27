<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApplicationTableFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->unsignedInteger('submission_file_id')->nullable();
            $table->unsignedInteger('submission_guarantee_id')->nullable();
        });
        Schema::table('submission_files', function (Blueprint $table) {
            $table->integer('plafond')->nullable();
            $table->integer('debitur')->nullable();
        });
        Schema::table('submission_guarantees', function (Blueprint $table) {
            $table->integer('plafond')->nullable();
            $table->integer('debitur')->nullable();
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
                'submission_file_id',
                'submission_guarantee_id'
            ]);
        });
        Schema::table('submission_files', function (Blueprint $table) {
            $table->dropColumn([
                'plafond',
                'debitur'
            ]);
        });
        Schema::table('submission_guarantees', function (Blueprint $table) {
            $table->dropColumn([
                'plafond',
                'debitur'
            ]);
        });
    }
}
