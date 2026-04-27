<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationCheckersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_checkers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('application_id');
            $table->enum('type',['slik','verification','checker','maker', 'approval']);
            $table->enum('status',['queue','approve', 'reject', 'pending'])->nullable();
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
        Schema::dropIfExists('application_checkers');
    }
}
