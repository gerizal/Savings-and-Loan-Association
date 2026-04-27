<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'mutation_fee',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'mutation_fee' => 'decimal:2',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function simulations(): HasMany
    {
        return $this->hasMany(Simulation::class);
    }
}
