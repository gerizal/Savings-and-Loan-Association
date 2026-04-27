<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Simulation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'finance_type_id',
        'nopen',
        'name',
        'address',
        'birth_date',
        'salary',
        'tenor',
        'plafon',
        'blockir_fee',
        'repayment_fee',
        'bpp_fee',
        'simulation_date',
        'year',
        'month',
        'day',
        'max_tenor',
        'max_angsuran',
        'max_plafon',
        'angsuran',
        'administration_fee',
        'management_fee',
        'insurance_fee',
        'account_opening_fee',
        'stamp_fee',
        'information_fee',
        'mutation_fee',
        'provision_fee',
        'block_installments',
        'gross_amount',
        'net_amount',
        'rest_salary',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'birth_date'      => 'date',
        'simulation_date' => 'date',
        'salary'          => 'decimal:2',
        'plafon'          => 'decimal:2',
        'repayment_fee'   => 'decimal:2',
        'bpp_fee'         => 'decimal:2',
        'max_plafon'      => 'decimal:2',
        'angsuran'        => 'decimal:2',
        'administration_fee' => 'decimal:2',
        'management_fee'  => 'decimal:2',
        'insurance_fee'   => 'decimal:2',
        'account_opening_fee' => 'decimal:2',
        'stamp_fee'       => 'decimal:2',
        'information_fee' => 'decimal:2',
        'mutation_fee'    => 'decimal:2',
        'provision_fee'   => 'decimal:2',
        'gross_amount'    => 'decimal:2',
        'net_amount'      => 'decimal:2',
        'rest_salary'     => 'decimal:2',
        'tenor'           => 'integer',
        'max_tenor'       => 'integer',
        'product_id'      => 'integer',
        'finance_type_id' => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function financeType(): BelongsTo
    {
        return $this->belongsTo(FinanceType::class);
    }
}
