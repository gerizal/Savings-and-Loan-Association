<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add indexes for frequently queried columns
        Schema::table('users', function (Blueprint $table) {
            if (!$this->hasIndex('users', 'users_branch_unit_id_index')) {
                $table->index('branch_unit_id');
            }
        });

        Schema::table('user_roles', function (Blueprint $table) {
            if (!$this->hasIndex('user_roles', 'user_roles_user_id_role_id_index')) {
                $table->index(['user_id', 'role_id']);
            }
        });

        Schema::table('permission_roles', function (Blueprint $table) {
            if (!$this->hasIndex('permission_roles', 'permission_roles_role_id_permission_id_index')) {
                $table->index(['role_id', 'permission_id']);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_branch_unit_id_index');
        });
        Schema::table('user_roles', function (Blueprint $table) {
            $table->dropIndex('user_roles_user_id_role_id_index');
        });
        Schema::table('permission_roles', function (Blueprint $table) {
            $table->dropIndex('permission_roles_role_id_permission_id_index');
        });
    }

    private function hasIndex(string $table, string $index): bool
    {
        try {
            $indexes = Schema::getConnection()->getSchemaBuilder()->getIndexListing($table);
            return in_array($index, $indexes);
        } catch (\Exception $e) {
            return false;
        }
    }
};
