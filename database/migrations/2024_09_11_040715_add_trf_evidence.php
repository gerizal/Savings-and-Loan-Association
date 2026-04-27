<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrfEvidence extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('droppings', function (Blueprint $table) {
            $table->string('transfer_evidence')->nullable();
            $table->timestamp('transfer_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('droppings', function (Blueprint $table) {
            $table->dropColumn([
                'transfer_evidence',
                'transfer_date',
            ]);
        });
    }
}
