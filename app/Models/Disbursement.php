<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disbursement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'application_id',
        'status',
        'description',
        'checked_by',
        'checker_name',
        'transfer_evidence',
        'reception_evidence',
        'reception_date',
    ];

    protected $casts = [
        'application_id' => 'integer',
        'checked_by'     => 'integer',
        'reception_date' => 'date',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
