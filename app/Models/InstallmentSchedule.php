<?php

namespace App\Models;

use App\Traits\Shardable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstallmentSchedule extends Model
{
    use HasFactory, SoftDeletes, Shardable;

    // Co-locate with Application on same shard via application_id
    protected string $shardKey = 'application_id';

    protected $fillable = [
        'application_id',
        'contract_id',
        'number',
        'amount',
        'primary_loan',
        'margin',
        'margin_bank',
        'colfee',
        'remains',
        'status',
        'payment_date',
        'settlement_date',
        'description',
        'file',
        'payment_code',
        'payment_type',
    ];

    protected $casts = [
        'status'         => 'boolean',
        'payment_date'   => 'date',
        'settlement_date'=> 'date',
        'amount'         => 'decimal:2',
        'primary_loan'   => 'decimal:2',
        'margin'         => 'decimal:2',
        'margin_bank'    => 'decimal:2',
        'colfee'         => 'decimal:2',
        'remains'        => 'decimal:2',
        'number'         => 'integer',
        'application_id' => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'application_id', 'application_id');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Scope: datatable for a single application's installment list.
     */
    public function scopeDataTable($query, $request, $application_id)
    {
        $query->select(
                  'installment_schedules.id', 'installment_schedules.application_id',
                  'installment_schedules.margin', 'installment_schedules.number',
                  'installment_schedules.primary_loan', 'installment_schedules.settlement_date',
                  'installment_schedules.status', 'installment_schedules.description',
                  'installment_schedules.file', 'installment_schedules.payment_code',
                  'installment_schedules.payment_type', 'contracts.number as akad',
                  \DB::raw("DATE_FORMAT(installment_schedules.payment_date,'%d-%m-%Y') as payment_date"),
                  \DB::raw("CONCAT('Rp ',FORMAT(installment_schedules.amount, 2,'id_ID')) as amount"),
                  \DB::raw("CONCAT('Rp ',FORMAT(installment_schedules.colfee, 2,'id_ID')) as colfee"),
                  \DB::raw("CONCAT('Rp ',FORMAT(installment_schedules.margin_bank, 2,'id_ID')) as margin_bank"),
                  \DB::raw("CONCAT('Rp ',FORMAT(installment_schedules.remains, 2,'id_ID')) as remains")
              )
              ->join('applications', 'applications.id', '=', 'installment_schedules.application_id')
              ->join('contracts', 'contracts.application_id', '=', 'installment_schedules.application_id')
              ->where('installment_schedules.application_id', $application_id)
              ->whereIn('applications.disbursement_status', ['approve', 'on process'])
              ->when(isset($request->status) && $request->status !== '', fn($q) => $q->where('installment_schedules.status', boolval($request->status)))
              ->when(
                  isset($request->start_date) && isset($request->end_date) && $request->start_date && $request->end_date,
                  fn($q) => $q->whereDate('installment_schedules.payment_date', '>=', $request->start_date)
                              ->whereDate('installment_schedules.payment_date', '<=', $request->end_date)
              )
              ->forRole()
              ->orderBy('installment_schedules.number', 'ASC');

        return $query;
    }

    /**
     * Apply bank-role filter via the application relationship.
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
     * Scope: full installment datatable (all applications).
     */
    public function scopeInstallmentDataTable($query, $request)
    {
        $query->join('applications', 'applications.id', '=', 'installment_schedules.application_id')
              ->join('products', 'products.id', '=', 'applications.product_id')
              ->join('finance_types', 'finance_types.id', '=', 'applications.finance_type_id')
              ->join('taspens', 'taspens.id', '=', 'applications.taspen_id')
              ->join('contracts', 'contracts.application_id', '=', 'applications.id')
              ->select(
                  'installment_schedules.id', 'installment_schedules.application_id',
                  'installment_schedules.margin', 'installment_schedules.number',
                  'installment_schedules.primary_loan', 'installment_schedules.settlement_date',
                  'installment_schedules.status', 'installment_schedules.description',
                  'installment_schedules.file', 'installment_schedules.payment_code',
                  'installment_schedules.payment_type', 'contracts.number as akad',
                  'applications.id as app_id', 'products.name as product_name',
                  'finance_types.name as finance_name', 'taspens.name as applicant_name',
                  'taspens.nopen', 'applications.plafon', 'applications.tenor',
                  \DB::raw("DATE_FORMAT(installment_schedules.payment_date,'%d-%m-%Y') as payment_date"),
                  \DB::raw("applications.tenor-installment_schedules.number as tenor_left"),
                  \DB::raw("CONCAT('Rp ',FORMAT(installment_schedules.amount, 2,'id_ID')) as amount"),
                  \DB::raw("CONCAT('Rp ',FORMAT(installment_schedules.colfee, 2,'id_ID')) as colfee"),
                  \DB::raw("CONCAT('Rp ',FORMAT(installment_schedules.margin_bank, 2,'id_ID')) as margin_bank"),
                  \DB::raw("CONCAT('Rp ',FORMAT(installment_schedules.remains, 2,'id_ID')) as remains")
              )
              ->whereIn('applications.disbursement_status', ['approve', 'on process'])
              ->when(isset($request->status) && $request->status !== '', fn($q) => $q->where('installment_schedules.status', boolval($request->status)))
              ->when(isset($request->group) && $request->group !== '', fn($q) => $q->where('products.name', 'like', '%' . $request->group . '%'))
              ->when(isset($request->bank) && $request->bank !== '', fn($q) => $q->where('applications.bank_id', $request->bank))
              ->when(
                  isset($request->start_date) && isset($request->end_date) && $request->start_date && $request->end_date,
                  fn($q) => $q->whereDate('installment_schedules.payment_date', '>=', $request->start_date)
                              ->whereDate('installment_schedules.payment_date', '<=', $request->end_date),
                  fn($q) => $q->whereMonth('installment_schedules.payment_date', '>=', date('m'))
                              ->whereYear('installment_schedules.payment_date', '>=', date('Y'))
              )
              ->forRole()
              ->orderBy('installment_schedules.payment_date', 'asc');

        return $query;
    }
}
