<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settlement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'application_id',
        'status',
        'amount',
        'description',
        'file',
        'settlement_date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'application_id'  => 'integer',
        'amount'          => 'decimal:2',
        'settlement_date' => 'date',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
