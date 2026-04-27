<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $indexes = [
        'applications'       => [
            ['bank_id'],
            ['status'],
            ['taspen_id'],
            ['marketing_id'],
            ['dropping_id'],
            ['branch_unit_id'],
            ['service_unit_id'],
            ['product_id'],
            ['finance_type_id'],
            ['bank_id', 'status'],
            ['created_at'],
        ],
        'taspens'            => [
            ['nopen'],
            ['id_number'],
            ['is_active'],
        ],
        'sliks'              => [
            ['application_id'],
            ['status'],
            ['application_id', 'status'],
        ],
        'verifications'      => [
            ['application_id'],
            ['status'],
            ['application_id', 'status'],
        ],
        'approvals'          => [
            ['application_id'],
            ['status'],
            ['application_id', 'status'],
        ],
        'disbursements'      => [
            ['application_id'],
            ['dropping_id'],
            ['status'],
        ],
        'droppings'          => [
            ['bank_id'],
            ['status'],
            ['bank_id', 'status'],
        ],
        'installment_schedules' => [
            ['application_id'],
            ['contract_id'],
            ['application_id', 'number'],
        ],
        'contracts'          => [
            ['application_id'],
        ],
        'user_roles'         => [
            ['user_id', 'role_id'],
        ],
        'permission_roles'   => [
            ['role_id', 'permission_id'],
        ],
        'products'           => [
            ['bank_id'],
            ['is_active'],
        ],
        'submission_files'   => [
            ['bank_id'],
            ['status'],
        ],
        'submission_guarantees' => [
            ['bank_id'],
            ['status'],
        ],
        'funds'              => [
            ['application_id'],
        ],
        'dropping_details'   => [
            ['dropping_id'],
            ['application_id'],
        ],
    ];

    public function up(): void
    {
        foreach ($this->indexes as $table => $tableIndexes) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($table, $tableIndexes) {
                $existing = $this->getExistingIndexes($table);

                foreach ($tableIndexes as $columns) {
                    $name = $table . '_' . implode('_', $columns) . '_index';
                    if (! in_array($name, $existing)) {
                        $blueprint->index($columns, $name);
                    }
                }
            });
        }
    }

    public function down(): void
    {
        foreach ($this->indexes as $table => $tableIndexes) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($table, $tableIndexes) {
                foreach ($tableIndexes as $columns) {
                    $name = $table . '_' . implode('_', $columns) . '_index';
                    try {
                        $blueprint->dropIndex($name);
                    } catch (\Exception) {
                        // Index may not exist, skip
                    }
                }
            });
        }
    }

    private function getExistingIndexes(string $table): array
    {
        try {
            return array_keys(
                Schema::getConnection()->getDoctrineSchemaManager()->listTableIndexes($table)
            );
        } catch (\Exception) {
            return [];
        }
    }
};
