<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeductionAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deduction_allowances', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('taspen_id');
            $table->string('anak')->nullable();
            $table->string('istri')->nullable();
            $table->string('beras')->nullable();
            $table->string('cacat')->nullable();
            $table->string('dahor')->nullable();
            $table->string('alimentasi')->nullable();
            $table->string('askes')->nullable();
            $table->string('assos')->nullable();
            $table->string('ganti_rugi')->nullable();
            $table->string('kasda')->nullable();
            $table->string('kpkn')->nullable();
            $table->string('pph21')->nullable();
            $table->string('sewa_rumah')->nullable();
            $table->string('spn')->nullable();
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
        Schema::dropIfExists('deduction_allowances');
    }
}
