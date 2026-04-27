<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DroppingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'dropping_id',
        'application_id',
    ];

    protected $casts = [
        'dropping_id'    => 'integer',
        'application_id' => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function dropping(): BelongsTo
    {
        return $this->belongsTo(Dropping::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
