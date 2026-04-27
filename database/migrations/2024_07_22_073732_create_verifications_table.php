<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('funds');
        Schema::create('verifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('application_id');
            $table->enum('status',['queue','on process','approve', 'reject', 'pending'])->nullable();
            $table->unsignedInteger('checked_by')->nullable();
            $table->string('checker_name')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('verifications');
    }
}
