<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTaspenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taspens', function (Blueprint $table) {
            $table->string('account_number')->nullable();
            $table->boolean('bad_data')->nullable();
            $table->integer('id_number_periode')->nullable();
            $table->timestamp('tmt_pensiun')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taspens', function (Blueprint $table) {
            $table->dropColumn([
                'account_number',
                'bad_data',
                'tmt_pensiun',
                'id_number_periode'
            ]);
        });
    }
}
