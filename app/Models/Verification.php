<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'application_id',
        'status',
        'description',
        'checked_by',
        'checker_name',
    ];

    protected $casts = [
        'application_id' => 'integer',
        'checked_by'     => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Apply bank-role filter via the joined application.
     */
    public function scopeForRole($query)
    {
        $user      = \Auth::user();
        $user_role = user_role();

        if ($user_role && in_array($user_role->slug, ['approval', 'bank'])) {
            $query->where('applications.bank_id', $user->bank_id);
        }

        return $query;
    }

    /**
     * Scope: datatable for verification list (queries from Application).
     */
    public function scopeDataTable($query, $request)
    {
        // Note: this scope is applied on Application::query() for historical reasons
        // (the old code queried via Application). Kept compatible.
        $query->select(
                  'verifications.*', 'applications.tenor', 'applications.plafon',
                  'taspens.name', 'taspens.nopen', 'products.name as product_name',
                  'finance_types.name as finance_type',
                  \DB::raw("DATE_FORMAT(applications.created_at,'%d-%m-%Y') as date")
              )
              ->join('verifications', 'verifications.application_id', '=', 'applications.id')
              ->join('taspens', 'taspens.id', '=', 'applications.taspen_id')
              ->join('products', 'products.id', '=', 'applications.product_id')
              ->join('finance_types', 'finance_types.id', '=', 'applications.finance_type_id')
              ->when(isset($request->status), fn($q) => $q->where('verifications.status', $request->status))
              ->when(isset($request->bank), fn($q) => $q->where('applications.bank_id', $request->bank))
              ->when(
                  isset($request->start_date) && isset($request->end_date) && $request->start_date && $request->end_date,
                  fn($q) => $q->whereDate('applications.created_at', '>=', $request->start_date)
                              ->whereDate('applications.created_at', '<=', $request->end_date)
              )
              ->forRole()
              ->orderBy('id', 'DESC');

        return $query;
    }
}
