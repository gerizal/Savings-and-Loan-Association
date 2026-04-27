<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'application_id',
        'account_bank',
        'account_bank_number',
        'account_bank_date',
        'bank_name',
        'akad',
        'akad_date',
        'disbursement',
        'disbursement_date',
        'disbursement_video',
        'disbursement_video_date',
        'disbursement_video_2',
        'disbursement_video_2_date',
        'disbursement_video_3',
        'disbursement_video_3_date',
        'epotpen',
        'epotpen_date',
        'flagging',
        'flagging_date',
        'guarantee',
        'guarantee_date',
        'insurance',
        'mutation',
        'mutation_date',
        'settlement',
        'settlement_date',
    ];

    protected $casts = [
        'application_id'            => 'integer',
        'account_bank_date'         => 'date',
        'akad_date'                 => 'date',
        'disbursement_date'         => 'date',
        'disbursement_video_date'   => 'date',
        'disbursement_video_2_date' => 'date',
        'disbursement_video_3_date' => 'date',
        'epotpen_date'              => 'date',
        'flagging_date'             => 'date',
        'guarantee_date'            => 'date',
        'mutation_date'             => 'date',
        'settlement_date'           => 'date',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
