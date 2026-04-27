<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'bank_id',
        'insurance_fee',
        'interest',
        'min_age',
        'max_age',
        'max_paid_age',
        'max_tenor',
        'max_plafon',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'bank_id'       => 'integer',
        'insurance_fee' => 'decimal:2',
        'interest'      => 'decimal:4',
        'min_age'       => 'integer',
        'max_age'       => 'integer',
        'max_paid_age'  => 'integer',
        'max_tenor'     => 'integer',
        'max_plafon'    => 'decimal:2',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
