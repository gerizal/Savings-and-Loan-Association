<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fund extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'status',
        'amount',
        'description',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'application_id' => 'integer',
        'amount'         => 'decimal:2',
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
     * Scope: datatable for fund list.
     */
    public function scopeDataTable($query, $request)
    {
        $query->select(
                  'funds.*', 'applications.tenor', 'applications.plafon',
                  'taspens.name', 'taspens.nopen', 'products.name as product_name',
                  'finance_types.name as finance_type',
                  \DB::raw("DATE_FORMAT(applications.created_at,'%d-%m-%Y') as date")
              )
              ->join('applications', 'applications.id', '=', 'funds.application_id')
              ->join('taspens', 'taspens.id', '=', 'applications.taspen_id')
              ->join('products', 'products.id', '=', 'applications.product_id')
              ->join('finance_types', 'finance_types.id', '=', 'applications.finance_type_id')
              ->when(isset($request->status), fn($q) => $q->where('funds.status', $request->status))
              ->orderBy('id', 'DESC');

        return $query;
    }
}
