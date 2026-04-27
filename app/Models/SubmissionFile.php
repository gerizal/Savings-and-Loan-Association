<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubmissionFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bank_id',
        'application_id',
        'number',
        'date',
        'upload_date',
        'status',
        'plafond',
        'debitur',
        'evidence',
        'file',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'bank_id'       => 'integer',
        'application_id'=> 'integer',
        'date'          => 'date',
        'upload_date'   => 'date',
        'plafond'       => 'decimal:2',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Scope: datatable for submission file list.
     */
    public function scopeDataTable($query, $request)
    {
        $user      = \Auth::user();
        $user_role = user_role();

        $query->select(
                  'submission_files.bank_id', 'submission_files.debitur', 'submission_files.evidence',
                  'submission_files.file', 'submission_files.id', 'submission_files.number',
                  'submission_files.plafond', 'submission_files.status', 'submission_files.application_id',
                  'banks.name',
                  \DB::raw("CASE WHEN date IS NULL THEN '' ELSE DATE_FORMAT(submission_files.date,'%d-%m-%Y') END as date"),
                  \DB::raw("CASE WHEN upload_date IS NULL THEN '-' ELSE DATE_FORMAT(submission_files.upload_date,'%d-%m-%Y') END as upload_date")
              )
              ->join('banks', 'banks.id', '=', 'submission_files.bank_id')
              ->whereNotNull('submission_files.status')
              ->groupBy('banks.id')
              ->when(isset($request->status), fn($q) => $q->where('submission_files.status', $request->status))
              ->when(isset($request->bank), fn($q) => $q->where('submission_files.bank_id', $request->bank))
              ->when(
                  isset($request->start_date) && isset($request->end_date) && $request->start_date && $request->end_date,
                  fn($q) => $q->whereDate('submission_files.date', '>=', $request->start_date)
                              ->whereDate('submission_files.date', '<=', $request->end_date)
              )
              ->orderBy('submission_files.id', 'DESC');

        if ($user_role && in_array($user_role->slug, ['approval', 'bank'])) {
            $query->where('banks.id', $user->bank_id);
        }

        return $query;
    }
}
