<?php

namespace App\Models;

use App\Traits\Shardable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Application extends Model
{
    use HasFactory, SoftDeletes, Shardable;

    // Shard by id — high-volume table, distributed across shards by PK range
    protected string $shardKey = 'id';

    protected $fillable = [
        'taspen_id',
        'product_id',
        'finance_type_id',
        'service_unit_id',
        'branch_unit_id',
        'bank_id',
        'dropping_id',
        'referral_id',
        'marketing_id',
        'submission_file_id',
        'submission_guarantee_id',
        'id_number',
        'interest',
        'interest_type',
        'mutation_fee',
        'insurance_fee',
        'tenor',
        'plafon',
        'administration_fee',
        'coop_fee',
        'other_fee',
        'management_fee',
        'stamp_fee',
        'account_opening_fee',
        'installment_fee',
        'flagging_fee',
        'epotpen_fee',
        'provision_fee',
        'round_off',
        'is_flash',
        'original_paymaster',
        'destination_paymaster',
        'previous_loan',
        'bank_name',
        'account_bank_number',
        'fronting_agent',
        'referral_fee',
        'purpose',
        'other_purpose',
        'bpp_fee',
        'repayment_fee',
        'block_installment',
        'installment',
        'salary',
        'year',
        'month',
        'day',
        'max_tenor',
        'max_installment',
        'max_plafon',
        'information_fee',
        'blockir_fee',
        'gross_amount',
        'net_amount',
        'rest_salary',
        'total_cost',
        'primary_loan',
        'margin',
        'bank_installment',
        'col_fee',
        'status',
        'disbursement_status',
        'is_confirm',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_flash'           => 'boolean',
        'is_confirm'         => 'boolean',
        'plafon'             => 'decimal:2',
        'installment'        => 'decimal:2',
        'salary'             => 'decimal:2',
        'gross_amount'       => 'decimal:2',
        'net_amount'         => 'decimal:2',
        'rest_salary'        => 'decimal:2',
        'max_installment'    => 'decimal:2',
        'max_plafon'         => 'decimal:2',
        'administration_fee' => 'decimal:2',
        'management_fee'     => 'decimal:2',
        'insurance_fee'      => 'decimal:2',
        'stamp_fee'          => 'decimal:2',
        'mutation_fee'       => 'decimal:2',
        'provision_fee'      => 'decimal:2',
        'flagging_fee'       => 'decimal:2',
        'epotpen_fee'        => 'decimal:2',
        'bpp_fee'            => 'decimal:2',
        'repayment_fee'      => 'decimal:2',
        'information_fee'    => 'decimal:2',
        'blockir_fee'        => 'decimal:2',
        'tenor'              => 'integer',
        'max_tenor'          => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function taspen(): BelongsTo
    {
        return $this->belongsTo(Taspen::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function financeType(): BelongsTo
    {
        return $this->belongsTo(FinanceType::class);
    }

    public function serviceUnit(): BelongsTo
    {
        return $this->belongsTo(ServiceUnit::class);
    }

    public function branchUnit(): BelongsTo
    {
        return $this->belongsTo(BranchUnit::class);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function dropping(): BelongsTo
    {
        return $this->belongsTo(Dropping::class);
    }

    public function marketing(): BelongsTo
    {
        return $this->belongsTo(User::class, 'marketing_id');
    }

    public function slik(): HasOne
    {
        return $this->hasOne(Slik::class);
    }

    public function verification(): HasOne
    {
        return $this->hasOne(Verification::class);
    }

    public function approval(): HasOne
    {
        return $this->hasOne(Approval::class);
    }

    public function disbursement(): HasOne
    {
        return $this->hasOne(Disbursement::class);
    }

    public function contract(): HasOne
    {
        return $this->hasOne(Contract::class);
    }

    public function applicationFile(): HasOne
    {
        return $this->hasOne(ApplicationFile::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'document_id')
                    ->where('document_type', self::class);
    }

    public function installmentSchedules(): HasMany
    {
        return $this->hasMany(InstallmentSchedule::class);
    }

    public function funds(): HasMany
    {
        return $this->hasMany(Fund::class);
    }

    public function droppingDetails(): HasMany
    {
        return $this->hasMany(DroppingDetail::class);
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Apply bank-role filter (approval/bank roles see only their bank).
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
     * Filter by bank id.
     */
    public function scopeFilterByBank($query, $bankId)
    {
        return $query->when($bankId, fn($q) => $q->where('applications.bank_id', $bankId));
    }

    /**
     * Filter by date range on created_at.
     */
    public function scopeFilterByDateRange($query, $startDate, $endDate)
    {
        return $query->when(
            $startDate && $endDate,
            fn($q) => $q->whereDate('applications.created_at', '>=', $startDate)
                        ->whereDate('applications.created_at', '<=', $endDate)
        );
    }

    /**
     * Eager-load common related data for list views.
     */
    public function scopeWithListData($query)
    {
        return $query->with(['taspen', 'product', 'financeType']);
    }

    /**
     * Scope for the main application datatable (unconfirmed applications).
     */
    public function scopeDataTable($query, $request)
    {
        $query->select('applications.*', 'taspens.name', 'taspens.nopen', 'products.name as product_name', 'finance_types.name as finance_type',
                       \DB::raw("DATE_FORMAT(applications.created_at,'%d-%m-%Y') as date"))
              ->join('taspens', 'taspens.id', '=', 'applications.taspen_id')
              ->join('products', 'products.id', '=', 'applications.product_id')
              ->join('finance_types', 'finance_types.id', '=', 'applications.finance_type_id')
              ->where('applications.is_confirm', 0)
              ->filterByBank($request->bank)
              ->filterByDateRange($request->start_date ?? null, $request->end_date ?? null)
              ->forRole()
              ->orderBy('id', 'DESC');

        return $query;
    }

    /**
     * Scope for the monitoring datatable.
     */
    public function scopeMonitoringDataTable($query, $request)
    {
        $query->select(
                  'approvals.status as approval_status', 'approvals.description as approval_description',
                  'approvals.checker_name as approval_checker_name', 'sliks.status as slik_status',
                  'sliks.description as slik_description', 'sliks.checker_name as slik_checker_name',
                  'verifications.status as verification_status', 'verifications.description as verification_description',
                  'verifications.checker_name as verification_checker_name',
                  'applications.id as application_id', 'applications.tenor', 'applications.plafon',
                  'taspens.name', 'taspens.nopen', 'products.name as product_name', 'banks.name as bank_name',
                  'finance_types.name as finance_type', 'disbursements.status as disbursement_status',
                  'disbursements.description as disbursement_description', 'disbursements.checker_name as disbursement_checker_name',
                  'disbursements.reception_evidence as reception_evidence',
                  \DB::raw("DATE_FORMAT(applications.created_at,'%d-%m-%Y') as date"),
                  \DB::raw("DATE_FORMAT(approvals.created_at,'%d-%m-%Y') as approval_date"),
                  \DB::raw("DATE_FORMAT(sliks.created_at,'%d-%m-%Y') as slik_date"),
                  \DB::raw("DATE_FORMAT(verifications.created_at,'%d-%m-%Y') as verification_date"),
                  \DB::raw("DATE_FORMAT(disbursements.reception_date,'%d-%m-%Y') as disbursement_date"),
                  'contracts.number as contract_number', 'contracts.date as contract_date', 'contracts.file_url as file_url',
                  'branch_units.name as branch_name', 'applications.interest', 'applications.interest_type', 'banks.code as code_bank'
              )
              ->join('banks', 'banks.id', '=', 'applications.bank_id')
              ->join('taspens', 'taspens.id', '=', 'applications.taspen_id')
              ->join('products', 'products.id', '=', 'applications.product_id')
              ->join('finance_types', 'finance_types.id', '=', 'applications.finance_type_id')
              ->leftJoin('sliks', 'sliks.application_id', '=', 'applications.id')
              ->leftJoin('verifications', 'verifications.application_id', '=', 'applications.id')
              ->leftJoin('approvals', 'approvals.application_id', '=', 'applications.id')
              ->leftJoin('disbursements', 'disbursements.application_id', '=', 'applications.id')
              ->leftJoin('contracts', 'contracts.application_id', '=', 'applications.id')
              ->leftJoin('branch_units', 'branch_units.id', '=', 'applications.branch_unit_id')
              ->forRole()
              ->orderBy('applications.id', 'DESC');

        if (isset($request->status)) {
            if ($request->status === 'queue') {
                $query->where(function ($q) {
                    $q->whereIn('approvals.status', ['queue', 'pending'])
                      ->orWhereIn('sliks.status', ['queue', 'pending'])
                      ->orWhereIn('verifications.status', ['queue', 'pending'])
                      ->orWhereIn('disbursements.status', ['queue', 'pending']);
                });
            } elseif ($request->status === 'on process') {
                $query->where(function ($q) {
                    $q->where('approvals.status', 'approve')
                      ->where('sliks.status', 'approve')
                      ->where('verifications.status', 'approve')
                      ->orWhere('disbursements.status', 'on process');
                });
            } elseif ($request->status === 'reject') {
                $query->where(function ($q) {
                    $q->where('approvals.status', 'reject')
                      ->orWhere('sliks.status', 'reject')
                      ->orWhere('verifications.status', 'reject')
                      ->orWhere('disbursements.status', 'reject');
                });
            } elseif ($request->status === 'approve') {
                $query->where('approvals.status', 'approve')
                      ->where('sliks.status', 'approve')
                      ->where('verifications.status', 'approve')
                      ->where('disbursements.status', 'approve');
            }
        }

        if ($request->search && isset($request->search['value'])) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->whereRaw("lower(banks.name) like '%{$search}%'")
                  ->orWhereRaw("lower(products.name) like '%{$search}%'")
                  ->orWhereRaw("lower(taspens.name) like '%{$search}%'")
                  ->orWhereRaw("lower(taspens.nopen) like '%{$search}%'")
                  ->orWhereRaw("lower(finance_types.name) like '%{$search}%'");
            });
        }

        return $query;
    }

    /**
     * Scope for the document datatable.
     */
    public function scopeDocumentDataTable($query, $request)
    {
        $query->select(
                  'approvals.status as approval_status', 'approvals.description as approval_description',
                  'approvals.checker_name as approval_checker_name', 'sliks.status as slik_status',
                  'sliks.description as slik_description', 'sliks.checker_name as slik_checker_name',
                  'verifications.status as verification_status', 'verifications.description as verification_description',
                  'verifications.checker_name as verification_checker_name',
                  'applications.id as application_id', 'applications.tenor', 'applications.plafon',
                  'taspens.name', 'taspens.nopen', 'products.name as product_name', 'finance_types.name as finance_type',
                  'disbursements.status as disbursement_status', 'disbursements.description as disbursement_description',
                  'disbursements.checker_name as disbursement_checker_name',
                  'application_files.account_bank', 'application_files.account_bank_number', 'application_files.account_bank_date',
                  'application_files.bank_name', 'application_files.akad', 'application_files.disbursement',
                  'application_files.disbursement_video', 'application_files.disbursement_video_2', 'application_files.disbursement_video_3',
                  'application_files.epotpen', 'application_files.flagging', 'application_files.insurance',
                  'application_files.mutation', 'application_files.settlement', 'application_files.disbursement_date',
                  'application_files.disbursement_video_2_date', 'application_files.disbursement_video_3_date',
                  'application_files.disbursement_video_date', 'application_files.epotpen_date', 'application_files.flagging_date',
                  'application_files.guarantee', 'application_files.guarantee_date', 'application_files.mutation_date',
                  'application_files.settlement_date',
                  \DB::raw("DATE_FORMAT(applications.created_at,'%d-%m-%Y') as date"),
                  \DB::raw("DATE_FORMAT(applications.created_at,'%d-%m-%Y') as application_file_date"),
                  'contracts.file_url as akad_file',
                  \DB::raw("DATE_FORMAT(contracts.created_at,'%d-%m-%Y') as akad_date")
              )
              ->join('taspens', 'taspens.id', '=', 'applications.taspen_id')
              ->join('products', 'products.id', '=', 'applications.product_id')
              ->join('finance_types', 'finance_types.id', '=', 'applications.finance_type_id')
              ->leftJoin('application_files', 'application_files.application_id', '=', 'applications.id')
              ->leftJoin('sliks', 'sliks.application_id', '=', 'applications.id')
              ->leftJoin('verifications', 'verifications.application_id', '=', 'applications.id')
              ->leftJoin('approvals', 'approvals.application_id', '=', 'applications.id')
              ->leftJoin('disbursements', 'disbursements.application_id', '=', 'applications.id')
              ->leftJoin('contracts', 'contracts.application_id', '=', 'applications.id')
              ->when(isset($request->status), fn($q) => $q->where('approvals.status', $request->status))
              ->forRole()
              ->orderBy('applications.id', 'DESC');

        return $query;
    }

    /**
     * Scope for disbursement (mutasi) datatable.
     */
    public function scopeDisbursementDataTable($query, $request)
    {
        $query->select(
                  'droppings.number', 'taspens.nopen', 'taspens.skep_number', 'taspens.name as debitur',
                  'products.name as product_name', 'banks.name as bank_name', 'finance_types.name as finance_type',
                  'branch_units.name as branch_name', 'applications.plafon as plafond', 'applications.net_amount',
                  'applications.id as application_id', 'disbursements.transfer_evidence', 'disbursements.reception_evidence',
                  \DB::raw("CASE WHEN disbursements.reception_date IS NULL THEN '-' ELSE DATE_FORMAT(disbursements.reception_date,'%d-%m-%Y') END as reception_date")
              )
              ->join('banks', 'banks.id', '=', 'applications.bank_id')
              ->join('taspens', 'taspens.id', '=', 'applications.taspen_id')
              ->join('products', 'products.id', '=', 'applications.product_id')
              ->join('finance_types', 'finance_types.id', '=', 'applications.finance_type_id')
              ->leftJoin('disbursements', 'disbursements.application_id', '=', 'applications.id')
              ->leftJoin('branch_units', 'branch_units.id', '=', 'applications.branch_unit_id')
              ->leftJoin('droppings', 'droppings.id', '=', 'applications.dropping_id')
              ->where('droppings.status', 'approve')
              ->whereRaw("LOWER(finance_types.name) like '%mutasi%'")
              ->when(isset($request->status), fn($q) => $q->where('disbursements.status', $request->status))
              ->filterByBank($request->bank ?? null)
              ->when(
                  isset($request->start_date) && isset($request->end_date) && $request->start_date && $request->end_date,
                  fn($q) => $q->whereDate('disbursements.reception_date', '>=', $request->start_date)
                              ->whereDate('disbursements.reception_date', '<=', $request->end_date)
              )
              ->forRole()
              ->orderBy('applications.id', 'DESC');

        return $query;
    }

    /**
     * Scope for the files datatable.
     */
    public function scopeFilesDataTable($query, $request)
    {
        $query->select(
                  'applications.id as application_id', 'applications.tenor', 'applications.plafon as plafond',
                  'taspens.name as debitur', 'taspens.nopen', 'products.name as product_name',
                  'finance_types.name as finance_type', 'contracts.number as contract_number', 'contracts.file_url as contract_file',
                  'banks.name as bank_name', 'service_units.name as service_unit_name',
                  'application_files.settlement', 'application_files.guarantee', 'application_files.account_bank',
                  'application_files.mutation', 'application_files.flagging',
                  \DB::raw("CASE WHEN disbursements.reception_date IS NULL THEN '-' ELSE DATE_FORMAT(disbursements.reception_date,'%d-%m-%Y') END as disbursement_date")
              )
              ->join('branch_units', 'branch_units.id', '=', 'applications.branch_unit_id')
              ->join('service_units', 'service_units.id', '=', 'branch_units.id')
              ->join('taspens', 'taspens.id', '=', 'applications.taspen_id')
              ->join('products', 'products.id', '=', 'applications.product_id')
              ->join('finance_types', 'finance_types.id', '=', 'applications.finance_type_id')
              ->join('contracts', 'contracts.application_id', '=', 'applications.id')
              ->join('disbursements', 'disbursements.application_id', '=', 'applications.id')
              ->join('banks', 'banks.id', '=', 'applications.bank_id')
              ->leftJoin('application_files', 'application_files.application_id', '=', 'applications.id')
              ->where('applications.disbursement_status', 'approve')
              ->when(isset($request->status), fn($q) => $q->where('disbursements.status', $request->status))
              ->filterByBank($request->bank ?? null)
              ->filterByDateRange($request->start_date ?? null, $request->end_date ?? null)
              ->forRole()
              ->orderBy('applications.id', 'DESC');

        return $query;
    }

    /**
     * Scope for submission files grouping.
     */
    public function scopeSubmissionFilesDataTable($query, $request)
    {
        $query->select('banks.id', 'banks.name', 'applications.id as application_id',
                       \DB::raw('sum(applications.plafon) as plafond'),
                       \DB::raw('count(applications.taspen_id) as debitur'),
                       \DB::raw("GROUP_CONCAT(applications.id SEPARATOR ',') AS application_ids"))
              ->join('banks', 'banks.id', '=', 'applications.bank_id')
              ->leftJoin('submission_files', 'submission_files.id', '=', 'applications.submission_file_id')
              ->whereNull('submission_files.status')
              ->where('applications.disbursement_status', 'approve')
              ->groupBy('applications.bank_id')
              ->forRole()
              ->orderBy('banks.name', 'ASC');

        return $query;
    }

    /**
     * Scope for submission guarantees grouping.
     */
    public function scopeSubmissionGuaranteeDataTable($query, $request)
    {
        $query->select('banks.id', 'banks.name', 'applications.id as application_id',
                       \DB::raw('sum(applications.plafon) as plafond'),
                       \DB::raw('count(applications.taspen_id) as debitur'),
                       \DB::raw("GROUP_CONCAT(applications.id SEPARATOR ',') AS application_ids"))
              ->join('banks', 'banks.id', '=', 'applications.bank_id')
              ->join('submission_files', 'submission_files.id', '=', 'applications.submission_file_id')
              ->leftJoin('submission_guarantees', 'submission_guarantees.id', '=', 'applications.submission_guarantee_id')
              ->where('submission_files.status', 'approve')
              ->whereNull('submission_guarantees.status')
              ->where('applications.disbursement_status', 'approve')
              ->groupBy('applications.bank_id')
              ->forRole()
              ->orderBy('banks.name', 'ASC');

        return $query;
    }

    /**
     * Scope for the report query.
     */
    public function scopeReport($query, $request)
    {
        $query->select(
                  'contracts.number as contract_number', 'taspens.nopen', 'taspens.skep_number', 'taspens.name as debitur',
                  'products.name as product_name', 'banks.name as bank_name', 'finance_types.name as finance_type',
                  'branch_units.name as branch_name', 'service_units.name as area_name',
                  'applications.plafon as plafond', 'applications.tenor', 'applications.id as application_id',
                  'applications.col_fee', 'applications.installment', 'applications.bank_installment',
                  'applications.net_amount', 'applications.margin',
                  \DB::raw("DATE_FORMAT(applications.created_at,'%d-%m-%Y') date"),
                  \DB::raw("CASE WHEN contracts.date IS NULL THEN '-' ELSE DATE_FORMAT(contracts.date,'%d-%m-%Y') END as contract_date"),
                  \DB::raw("CASE WHEN disbursements.reception_date IS NULL THEN '-' ELSE DATE_FORMAT(disbursements.reception_date,'%d-%m-%Y') END as reception_date"),
                  \DB::raw("CASE WHEN disbursements.reception_date IS NULL THEN '-' ELSE DATE_FORMAT(disbursements.reception_date,'%d-%m-%Y') END as settlement_date")
              )
              ->join('banks', 'banks.id', '=', 'applications.bank_id')
              ->join('taspens', 'taspens.id', '=', 'applications.taspen_id')
              ->join('products', 'products.id', '=', 'applications.product_id')
              ->join('finance_types', 'finance_types.id', '=', 'applications.finance_type_id')
              ->leftJoin('disbursements', 'disbursements.application_id', '=', 'applications.id')
              ->leftJoin('branch_units', 'branch_units.id', '=', 'applications.branch_unit_id')
              ->leftJoin('service_units', 'service_units.id', '=', 'branch_units.service_unit_id')
              ->leftJoin('droppings', 'droppings.id', '=', 'applications.dropping_id')
              ->leftJoin('contracts', 'contracts.application_id', '=', 'applications.id')
              ->when(isset($request->status), fn($q) => $q->where('disbursements.status', $request->status))
              ->filterByBank($request->bank ?? null)
              ->when(
                  isset($request->start_date) && isset($request->end_date) && $request->start_date && $request->end_date,
                  fn($q) => $q->whereDate('disbursements.reception_date', '>=', $request->start_date)
                              ->whereDate('disbursements.reception_date', '<=', $request->end_date)
              )
              ->forRole()
              ->orderBy('applications.id', 'DESC');

        return $query;
    }

    /**
     * Scope for applications that are fully approved and ready to be dropped (SI disbursement).
     */
    public function scopeReadyForDropping($query, $bank_id = null)
    {
        $query->select('applications.*')
              ->join('sliks', 'sliks.application_id', '=', 'applications.id')
              ->join('verifications', 'verifications.application_id', '=', 'applications.id')
              ->join('approvals', 'approvals.application_id', '=', 'applications.id')
              ->join('disbursements', 'disbursements.application_id', '=', 'applications.id')
              ->where('sliks.status', 'approve')
              ->where('verifications.status', 'approve')
              ->where('approvals.status', 'approve')
              ->whereNull('disbursements.status')
              ->orderBy('applications.id', 'DESC');

        if ($bank_id) {
            $query->where('applications.bank_id', $bank_id);
        }

        return $query;
    }

    // -------------------------------------------------------------------------
    // Static helpers (retained — complex logic)
    // -------------------------------------------------------------------------

    /**
     * Save a new loan application. Renamed from saveLoanApplication().
     */
    public static function fromRequest($request, $taspen_id): self
    {
        $data    = new self;
        $product = Product::find($request->product_id);

        $data->fill([
            'taspen_id'           => $taspen_id,
            'product_id'          => $request->product_id,
            'finance_type_id'     => $request->finance_type_id,
            'service_unit_id'     => $request->service_unit_id,
            'branch_unit_id'      => $request->branch_unit_id,
            'bank_id'             => $product->bank_id,
            'id_number'           => $request->id_number,
            'interest'            => $request->interest,
            'interest_type'       => $request->interest_type,
            'mutation_fee'        => unmaskCurrency($request->mutation_fee),
            'insurance_fee'       => unmaskCurrency($request->insurance_fee),
            'tenor'               => $request->tenor,
            'plafon'              => unmaskCurrency($request->plafon),
            'administration_fee'  => unmaskCurrency($request->administration_fee),
            'coop_fee'            => $request->coop_fee,
            'other_fee'           => $request->other_fee,
            'management_fee'      => unmaskCurrency($request->management_fee),
            'stamp_fee'           => unmaskCurrency($request->stamp_fee),
            'account_opening_fee' => unmaskCurrency($request->account_opening_fee),
            'installment_fee'     => $request->installment_fee,
            'flagging_fee'        => unmaskCurrency($request->flagging_fee),
            'epotpen_fee'         => unmaskCurrency($request->epotpen_fee),
            'provision_fee'       => unmaskCurrency($request->provision_fee),
            'round_off'           => unmaskCurrency($request->round_off),
            'is_flash'            => true,
            'original_paymaster'  => $request->original_paymaster,
            'destination_paymaster'=> $request->destination_paymaster,
            'previous_loan'       => unmaskCurrency($request->previous_loan),
            'bank_name'           => $request->bank_name,
            'account_bank_number' => $request->account_bank_number,
            'marketing_id'        => $request->marketing_id,
            'fronting_agent'      => $request->fronting_agent,
            'referral_fee'        => $request->referral_fee,
            'referral_id'         => $request->referral_id,
            'purpose'             => $request->purpose,
            'other_purpose'       => $request->other_purpose,
            'bpp_fee'             => unmaskCurrency($request->bpp_fee),
            'repayment_fee'       => unmaskCurrency($request->repayment_fee),
            'block_installment'   => $request->block_installment,
            'installment'         => unmaskCurrency($request->installment),
            'salary'              => unmaskCurrency($request->salary),
            'year'                => $request->year,
            'month'               => $request->month,
            'day'                 => $request->day,
            'max_tenor'           => $request->max_tenor,
            'max_installment'     => unmaskCurrency($request->max_installment),
            'max_plafon'          => unmaskCurrency($request->max_plafon),
            'information_fee'     => unmaskCurrency($request->information_fee),
            'blockir_fee'         => unmaskCurrency($request->blockir_fee),
            'gross_amount'        => unmaskCurrency($request->gross_amount),
            'net_amount'          => unmaskCurrency($request->net_amount),
            'rest_salary'         => unmaskCurrency($request->rest_salary),
            'total_cost'          => $request->total_cost,
            'primary_loan'        => $request->primary_loan,
            'margin'              => $request->margin,
            'bank_installment'    => $request->bank_installment,
            'col_fee'             => $request->col_fee,
            'created_by'          => \Auth::id(),
        ]);

        $data->save();

        self::handleDocumentUploads($request, $data->id);
        self::generateCreditAnalysis($data->id);

        return $data;
    }

    /**
     * Update an existing loan application. Renamed from updateLoanApplication().
     */
    public static function updateFromRequest($request, $id): self
    {
        $data    = self::findOrFail($id);
        $product = Product::find($request->product_id);

        $data->fill([
            'taspen_id'           => $request->taspen_id,
            'product_id'          => $request->product_id,
            'finance_type_id'     => $request->finance_type_id,
            'service_unit_id'     => $request->service_unit_id,
            'branch_unit_id'      => $request->branch_unit_id,
            'bank_id'             => $product->bank_id,
            'id_number'           => $request->id_number,
            'interest'            => $request->interest,
            'interest_type'       => $request->interest_type,
            'mutation_fee'        => unmaskCurrency($request->mutation_fee),
            'insurance_fee'       => unmaskCurrency($request->insurance_fee),
            'tenor'               => $request->tenor,
            'plafon'              => unmaskCurrency($request->plafon),
            'administration_fee'  => unmaskCurrency($request->administration_fee),
            'coop_fee'            => $request->coop_fee,
            'other_fee'           => $request->other_fee,
            'management_fee'      => unmaskCurrency($request->management_fee),
            'stamp_fee'           => unmaskCurrency($request->stamp_fee),
            'account_opening_fee' => unmaskCurrency($request->account_opening_fee),
            'installment_fee'     => $request->installment_fee,
            'flagging_fee'        => unmaskCurrency($request->flagging_fee),
            'epotpen_fee'         => unmaskCurrency($request->epotpen_fee),
            'provision_fee'       => unmaskCurrency($request->provision_fee),
            'round_off'           => unmaskCurrency($request->round_off),
            'is_flash'            => true,
            'original_paymaster'  => $request->original_paymaster,
            'destination_paymaster'=> $request->destination_paymaster,
            'previous_loan'       => unmaskCurrency($request->previous_loan),
            'bank_name'           => $request->bank_name,
            'account_bank_number' => $request->account_bank_number,
            'marketing_id'        => $request->marketing_id,
            'fronting_agent'      => $request->fronting_agent,
            'referral_fee'        => $request->referral_fee,
            'referral_id'         => $request->referral_id,
            'purpose'             => $request->purpose,
            'other_purpose'       => $request->other_purpose,
            'bpp_fee'             => unmaskCurrency($request->bpp_fee),
            'repayment_fee'       => unmaskCurrency($request->repayment_fee),
            'block_installment'   => $request->block_installment,
            'installment'         => unmaskCurrency($request->installment),
            'salary'              => unmaskCurrency($request->salary),
            'year'                => $request->year,
            'month'               => $request->month,
            'day'                 => $request->day,
            'max_tenor'           => $request->max_tenor,
            'max_installment'     => unmaskCurrency($request->max_installment),
            'max_plafon'          => unmaskCurrency($request->max_plafon),
            'information_fee'     => unmaskCurrency($request->information_fee),
            'blockir_fee'         => unmaskCurrency($request->blockir_fee),
            'gross_amount'        => unmaskCurrency($request->gross_amount),
            'net_amount'          => unmaskCurrency($request->net_amount),
            'rest_salary'         => unmaskCurrency($request->rest_salary),
            'total_cost'          => $request->total_cost,
            'primary_loan'        => $request->primary_loan,
            'margin'              => $request->margin,
            'bank_installment'    => $request->bank_installment,
            'col_fee'             => $request->col_fee,
            'updated_by'          => \Auth::id(),
        ]);

        $data->save();

        self::handleDocumentUploads($request, $data->id);

        return $data;
    }

    /**
     * Handle document file uploads for slik, application, interview & insurance videos.
     */
    protected static function handleDocumentUploads($request, $application_id): void
    {
        $types = [
            'slik_file'       => 'slik',
            'application_file'=> 'application',
            'interview_video' => 'interview_video',
            'insurance_video' => 'insurance_video',
        ];

        foreach ($types as $field => $type) {
            if ($request->hasFile($field)) {
                $upload = Document::uploadFile($request->$field);
                Document::createUpdate([
                    'document_id'   => $application_id,
                    'document_type' => self::class,
                    'type'          => $type,
                    'name'          => $upload['original_name'],
                    'url'           => $upload['path'],
                ]);
            }
        }
    }

    public static function generateCreditAnalysis($application_id): bool
    {
        try {
            $application = self::find($application_id);
            if (!$application) return false;

            $taspen       = Taspen::find($application->taspen_id);
            $taspen->complete_address = "{$taspen->address}, {$taspen->post_code}";

            $domicile = Domicile::whereTaspenId($taspen->id)->first();
            if ($domicile) {
                $domicile->complete_address = "{$domicile->address}, {$domicile->post_code}";
            }
            $taspen->domicile = $domicile ? $domicile->toArray() : [];

            $application->taspen       = $taspen->toArray();
            $application->product      = Product::find($application->product_id)->toArray();
            $application->finance_type = FinanceType::find($application->finance_type_id)->toArray();

            $spouse = FamilyMember::whereTaspenId($taspen->id)->whereRelationStatus('spouse')->first();
            if (!$spouse) {
                $spouse = new FamilyMember;
                $spouse->taspen_id = $taspen->id;
                $spouse->id_number = '';
                $spouse->name      = '';
                $spouse->birth_place = '';
                $spouse->birth_date  = '';
                $spouse->occupation  = '';
                $spouse->relation_status = '';
                $spouse->complete_address = '';
            } else {
                $spouse->complete_address = $taspen->complete_address;
            }
            $application->spouse = $spouse;

            $pdf       = Pdf::loadView('application.loan.credit-analysis', $application->toArray())->setPaper('a4');
            $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_credit-analysis.pdf';
            $file_path = "documents/{$file_name}";
            Storage::disk('azure')->put($file_path, $pdf->output());

            Document::createUpdate([
                'document_id'   => $application_id,
                'document_type' => self::class,
                'type'          => 'credit-analysis',
                'name'          => $file_name,
                'url'           => $file_path,
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function deleteData($id): bool
    {
        self::find($id)->delete();
        Slik::whereApplicationId($id)->delete();
        Verification::whereApplicationId($id)->delete();
        Approval::whereApplicationId($id)->delete();
        Disbursement::whereApplicationId($id)->delete();
        return true;
    }

    public static function getNotificationData(): array
    {
        $total     = 0;
        $data      = [];
        $user      = \Auth::user();
        $user_role = user_role();
        $role_id   = $user_role ? $user_role->id : null;

        $slik = Slik::join('applications', 'applications.id', '=', 'sliks.application_id')
                    ->join('taspens', 'taspens.id', '=', 'applications.taspen_id')
                    ->join('products', 'products.id', '=', 'applications.product_id')
                    ->join('finance_types', 'finance_types.id', '=', 'applications.finance_type_id')
                    ->whereNull('applications.deleted_at')
                    ->where('sliks.status', 'queue');

        $verification = self::join('verifications', 'verifications.application_id', '=', 'applications.id')
                    ->join('taspens', 'taspens.id', '=', 'applications.taspen_id')
                    ->join('products', 'products.id', '=', 'applications.product_id')
                    ->join('finance_types', 'finance_types.id', '=', 'applications.finance_type_id')
                    ->where('verifications.status', 'queue');

        $approval = self::join('taspens', 'taspens.id', '=', 'applications.taspen_id')
                    ->join('products', 'products.id', '=', 'applications.product_id')
                    ->join('finance_types', 'finance_types.id', '=', 'applications.finance_type_id')
                    ->join('sliks', 'sliks.application_id', '=', 'applications.id')
                    ->join('verifications', 'verifications.application_id', '=', 'applications.id')
                    ->leftJoin('approvals', 'approvals.application_id', '=', 'applications.id')
                    ->where('sliks.status', 'approve')
                    ->where('verifications.status', 'approve')
                    ->where('approvals.status', 'queue');

        if ($user_role && in_array($user_role->slug, ['approval', 'bank'])) {
            $slik         = $slik->where('applications.bank_id', $user->bank_id);
            $verification = $verification->where('applications.bank_id', $user->bank_id);
            $approval     = $approval->where('applications.bank_id', $user->bank_id);
        }

        $slik_count         = $slik->count();
        $verification_count = $verification->count();
        $approval_count     = $approval->count();
        $disbursement_count = Bank::scopeSiDataTable(Bank::query(), request())->get()->count();

        $allNotifications = [
            ['title' => 'Slik',      'route' => route('application.slik.index'),             'total' => $slik_count,         'roles' => [1, 5, null]],
            ['title' => 'Verifikasi','route' => route('application.verification.index'),       'total' => $verification_count, 'roles' => [1, 9, null]],
            ['title' => 'Approval',  'route' => route('application.approval.index'),          'total' => $approval_count,     'roles' => [1, 4, null]],
            ['title' => 'Pencairan', 'route' => route('application.internal.si-disbursement'),'total' => $disbursement_count, 'roles' => [1, 5, null]],
        ];

        foreach ($allNotifications as $notification) {
            if (in_array($role_id, $notification['roles'])) {
                $data[]  = ['title' => $notification['title'], 'route' => $notification['route'], 'total' => $notification['total']];
                $total  += $notification['total'];
            }
        }

        return ['total' => $total, 'data' => $data];
    }

    public static function reportCashFlow($request): array
    {
        $where = '';
        if ($request->has('bank') && $request->bank != '') {
            $where .= " AND a.bank_id = {$request->bank} ";
        }
        if ($request->has('start_date') && $request->start_date != '') {
            $where .= " AND a.created_at >= '{$request->start_date}' ";
        }
        if ($request->has('end_date') && $request->end_date != '') {
            $where .= " AND a.created_at <= '{$request->end_date}' ";
        }
        if ($request->has('status') && $request->status != '') {
            $where .= " AND a.disbursement_status = {$request->status} ";
        }

        return \DB::select(\DB::raw(
            "SELECT a.id, su.`name` area_pelayanan, bu.`name` unit_pelayanan, u.`name` moc_admin,
                t.id_number nopen, t.skep_publisher no_sk_pensiun, t.`name` nama_pemohon,
                b.`name` mitra_bank, 'Dana Pensiun' sumber_dana, a.tenor, a.plafon plafond,
                p.`name` produk_pembiayaan, ft.`name` jenis_pembiayaan,
                af.created_at tanggal_pengajuan, af.akad_date tanggal_akad, af.disbursement_date tanggal_cair,
                af.settlement_date tanggal_lunas, a.margin, a.administration_fee admin_bank,
                0 admin_mitra, 0 pencadangan_pusat, 0 tatalaksana, 'Tidak' status_deviasi,
                'Tidak ada deviasi' keterangan_deviasi, a.insurance_fee asuransi, 0 premi_asuransi,
                0 selisih_asuransi, 'Informasi tambahan' AS data_informasi, 0 pembukaan_tabungan,
                0 biaya_materai, a.mutation_fee biaya_mutasi, 0 biaya_provisi,
                a.installment angsuran_perbulan, 0 angsuran_bank, 0 angsuran_kpf, 0 blokir_angsuran,
                0 nominal_take_over, 0 pencairan, 0 dropping
            FROM applications a
            JOIN service_units su ON su.id = a.service_unit_id
            JOIN branch_units bu ON bu.id = a.branch_unit_id
            JOIN users u ON u.id = a.created_by
            JOIN taspens t ON t.id = a.taspen_id
            JOIN banks b ON a.bank_id = b.id
            JOIN products p ON p.id = a.product_id
            JOIN finance_types ft ON ft.id = a.finance_type_id
            JOIN application_files af ON af.application_id = a.id
            WHERE 1=1 {$where};"
        ));
    }

    public static function reportOutstanding($request): array
    {
        $where = '';
        if ($request->has('bank') && $request->bank != '') {
            $where .= " AND a.bank_id = {$request->bank} ";
        }
        if ($request->has('start_date') && $request->start_date != '') {
            $where .= " AND a.created_at >= '{$request->start_date}' ";
        }
        if ($request->has('end_date') && $request->end_date != '') {
            $where .= " AND a.created_at <= '{$request->end_date}' ";
        }
        if ($request->has('status') && $request->status != '') {
            $where .= " AND a.disbursement_status = {$request->status} ";
        }

        return \DB::select(\DB::raw(
            "SELECT a.id, t.id_number nopen, t.`name` nama_pemohon, 'Dana Pensiun' sumber_dana,
                af.akad_date tanggal_akad, af.disbursement_date tanggal_cair, af.settlement_date tanggal_lunas,
                p.`name` produk_pembiayaan, ft.`name` jenis_pembiayaan, a.tenor, a.plafon plafond,
                a.installment angsuran, i.margin_bank angsuran_bank, 0 pokok,
                i.number angsuran_ke, (a.tenor - i.number) sisa_tenor, i.remains outstanding
            FROM applications a
            JOIN service_units su ON su.id = a.service_unit_id
            JOIN branch_units bu ON bu.id = a.branch_unit_id
            JOIN users u ON u.id = a.created_by
            JOIN taspens t ON t.id = a.taspen_id
            JOIN banks b ON a.bank_id = b.id
            JOIN products p ON p.id = a.product_id
            JOIN finance_types ft ON ft.id = a.finance_type_id
            JOIN application_files af ON af.application_id = a.id
            JOIN installment_schedules i ON i.application_id = a.id
            WHERE 1=1 {$where};"
        ));
    }

    public static function reportDebtor($request): array
    {
        $where = '';
        if ($request->has('bank') && $request->bank != '') {
            $where .= " AND a.bank_id = {$request->bank} ";
        }
        if ($request->has('start_date') && $request->start_date != '') {
            $where .= " AND a.created_at >= '{$request->start_date}' ";
        }
        if ($request->has('end_date') && $request->end_date != '') {
            $where .= " AND a.created_at <= '{$request->end_date}' ";
        }
        if ($request->has('status') && $request->status != '') {
            $where .= " AND a.disbursement_status = {$request->status} ";
        }

        return \DB::select(\DB::raw(
            "SELECT a.id, a.`status` status_pelunasan, su.`name` area_pelayanan,
                t.id_number nopen, t.skep_publisher no_sk, t.`name` nama_pemohon,
                'AKAD-45678' no_akad, af.akad_date tanggal_akad, 'berkas_pelunasan.pdf' berkas_pelunasan,
                af.settlement_date tanggal_pelunasan, 'Dana Internal' sumber_dana,
                p.`name` produk_pembiayaan, a.tenor, a.plafon plafond
            FROM applications a
            JOIN service_units su ON su.id = a.service_unit_id
            JOIN branch_units bu ON bu.id = a.branch_unit_id
            JOIN users u ON u.id = a.created_by
            JOIN taspens t ON t.id = a.taspen_id
            JOIN banks b ON a.bank_id = b.id
            JOIN products p ON p.id = a.product_id
            JOIN finance_types ft ON ft.id = a.finance_type_id
            JOIN application_files af ON af.application_id = a.id
            WHERE 1=1 {$where};"
        ));
    }
}
