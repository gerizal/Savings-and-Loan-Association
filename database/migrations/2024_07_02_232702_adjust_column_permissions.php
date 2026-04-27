<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustColumnPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            if (Schema::hasColumn('permissions', 'slug')) {
                $table->dropColumn('slug');
            }
            if (Schema::hasColumn('permissions', 'name')) {
                $table->dropColumn('name');
            }
            $table->string('feature')->nullable();
            $table->string('access')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('slug');
            $table->string('name');
            $table->dropColumn('feature');
            $table->string('access');
        });
    }
}
