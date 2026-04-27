<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileEvidenceApplicationFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('submission_files', function (Blueprint $table) {
            $table->string('evidence')->nullable();
            $table->timestamp('upload_date')->nullable();
            $table->enum('status',['queue','on process','approve', 'reject', 'pending'])->nullable();
        });
        Schema::table('submission_guarantees', function (Blueprint $table) {
            $table->string('evidence')->nullable();
            $table->timestamp('upload_date')->nullable();
            $table->enum('status',['queue','on process','approve', 'reject', 'pending'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('submission_files', function (Blueprint $table) {
            $table->dropColumn([
                'evidence',
                'upload_date'
            ]);
        });
        Schema::table('submission_guarantees', function (Blueprint $table) {
            $table->dropColumn([
                'evidence',
                'upload_date'
            ]);
        });
    }
}
