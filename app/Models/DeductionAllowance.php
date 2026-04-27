<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeductionAllowance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'taspen_id',
        'anak',
        'istri',
        'beras',
        'cacat',
        'dahor',
        'alimentasi',
        'askes',
        'assos',
        'ganti_rugi',
        'kasda',
        'kpkn',
        'pph21',
        'sewa_rumah',
        'spn',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'taspen_id' => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function taspen(): BelongsTo
    {
        return $this->belongsTo(Taspen::class);
    }
}
