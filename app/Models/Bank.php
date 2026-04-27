<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Bank extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'address',
        'administration_fee',
        'installment_fee',
        'other_fee',
        'management_fee',
        'stamp_fee',
        'account_opening_fee',
        'flagging_fee',
        'epotpen_fee',
        'provision_fee',
        'interest',
        'round_off',
        'coop_fee',
        'is_syariah',
        'is_flash',
        'logo',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_syariah'         => 'boolean',
        'is_flash'           => 'boolean',
        'administration_fee' => 'decimal:2',
        'management_fee'     => 'decimal:2',
        'stamp_fee'          => 'decimal:2',
        'account_opening_fee'=> 'decimal:2',
        'flagging_fee'       => 'decimal:2',
        'epotpen_fee'        => 'decimal:2',
        'round_off'          => 'decimal:2',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function droppings(): HasMany
    {
        return $this->hasMany(Dropping::class);
    }

    public function submissionFiles(): HasMany
    {
        return $this->hasMany(SubmissionFile::class);
    }

    public function submissionGuarantees(): HasMany
    {
        return $this->hasMany(SubmissionGuarantee::class);
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Scope for the SI (pencairan) datatable — groups approved applications
     * waiting for disbursement by bank.
     */
    public function scopeSiDataTable($query, $request)
    {
        $user      = \Auth::user();
        $user_role = user_role();

        $query->select('banks.id', 'banks.name', 'applications.id as application_id',
                       \DB::raw('sum(applications.plafon) as plafond'),
                       \DB::raw('count(applications.taspen_id) as debitur'))
              ->join('applications', 'applications.bank_id', '=', 'banks.id')
              ->leftJoin('sliks', 'sliks.application_id', '=', 'applications.id')
              ->leftJoin('verifications', 'verifications.application_id', '=', 'applications.id')
              ->leftJoin('approvals', 'approvals.application_id', '=', 'applications.id')
              ->leftJoin('disbursements', 'disbursements.application_id', '=', 'applications.id')
              ->leftJoin('droppings', 'droppings.id', '=', 'applications.dropping_id')
              ->where('sliks.status', 'approve')
              ->where('verifications.status', 'approve')
              ->where('approvals.status', 'approve')
              ->whereNull('disbursements.status')
              ->whereNull('droppings.status')
              ->groupBy('banks.id')
              ->orderBy('banks.name', 'ASC');

        if ($user_role && in_array($user_role->slug, ['approval', 'bank'])) {
            $query->where('applications.bank_id', $user->bank_id);
        }

        return $query;
    }

    /**
     * Scope for the dashboard bank summary.
     */
    public function scopeDashboard($query, bool $is_flash = false)
    {
        $user      = \Auth::user();
        $user_role = user_role();

        $query->selectRaw('banks.name, SUM(CASE WHEN sliks.status="queue" THEN 1 ELSE 0 END) as slik, SUM(CASE WHEN approvals.status="queue" then 1 else 0 end) as approval, sum(CASE WHEN droppings.status="queue" THEN droppings.plafond ELSE 0 END) as dropping_queue, sum(CASE WHEN droppings.status="on process" THEN droppings.plafond ELSE 0 END) as dropping_process, SUM(droppings.plafond) as total_dropping, SUM(droppings.plafond) as total_os')
              ->leftJoin('applications', 'applications.bank_id', '=', 'banks.id')
              ->leftJoin('sliks', 'sliks.application_id', '=', 'applications.id')
              ->leftJoin('approvals', 'approvals.application_id', '=', 'applications.id')
              ->leftJoin('droppings', 'droppings.id', '=', 'applications.dropping_id')
              ->where('banks.is_flash', $is_flash)
              ->groupBy('banks.id');

        if ($user_role && in_array($user_role->slug, ['approval', 'bank'])) {
            $query->where('applications.bank_id', $user->bank_id);
        }

        return $query;
    }
}
