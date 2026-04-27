<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Dropping extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'number',
        'date',
        'transfer_date',
        'status',
        'plafond',
        'dropping',
        'debitur',
        'evidence',
        'file',
        'transfer_evidence',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'bank_id'    => 'integer',
        'date'       => 'date',
        'transfer_date' => 'date',
        'plafond'    => 'decimal:2',
        'dropping'   => 'decimal:2',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function droppingDetails(): HasMany
    {
        return $this->hasMany(DroppingDetail::class);
    }

    public function applications(): HasManyThrough
    {
        return $this->hasManyThrough(Application::class, DroppingDetail::class, 'dropping_id', 'id', 'id', 'application_id');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Scope: datatable for dropping list.
     */
    public function scopeDataTable($query, $request)
    {
        $user      = \Auth::user();
        $user_role = user_role();

        $query->select(
                  'droppings.bank_id', 'droppings.debitur', 'droppings.evidence', 'droppings.file',
                  'droppings.id', 'droppings.number', 'droppings.status', 'droppings.transfer_evidence',
                  'banks.name',
                  \DB::raw("CONCAT('Rp ',FORMAT(droppings.plafond, 2,'id_ID')) as plafond"),
                  \DB::raw("CONCAT('Rp ',FORMAT(droppings.dropping, 2,'id_ID')) as dropping"),
                  \DB::raw("CASE WHEN date IS NULL THEN '' ELSE DATE_FORMAT(droppings.date,'%d-%m-%Y') END as date"),
                  \DB::raw("CASE WHEN transfer_date IS NULL THEN '-' ELSE DATE_FORMAT(droppings.transfer_date,'%d-%m-%Y') END as disbursement_date")
              )
              ->join('banks', 'banks.id', '=', 'droppings.bank_id')
              ->whereNotNull('droppings.status')
              ->when(isset($request->status), fn($q) => $q->where('droppings.status', $request->status))
              ->when(isset($request->bank), fn($q) => $q->where('droppings.bank_id', $request->bank))
              ->when(
                  isset($request->start_date) && isset($request->end_date) && $request->start_date && $request->end_date,
                  fn($q) => $q->whereDate('droppings.date', '>=', $request->start_date)
                              ->whereDate('droppings.date', '<=', $request->end_date)
              )
              ->orderBy('droppings.id', 'DESC');

        if ($user_role && in_array($user_role->slug, ['approval', 'bank'])) {
            $query->where('banks.id', $user->bank_id);
        }

        return $query;
    }
}
