<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code_area',
        'number_code',
        'address',
        'service_unit_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'service_unit_id' => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function serviceUnit(): BelongsTo
    {
        return $this->belongsTo(ServiceUnit::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Dashboard aggregate scope.
     */
    public function scopeDashboard($query)
    {
        $user      = \Auth::user();
        $user_role = user_role();

        $query->from('service_units')
              ->leftJoin('branch_units', 'branch_units.service_unit_id', '=', 'service_units.id')
              ->leftJoin('applications', 'applications.branch_unit_id', '=', 'branch_units.id')
              ->leftJoin('approvals', 'approvals.application_id', '=', 'applications.id')
              ->leftJoin('disbursements', 'disbursements.application_id', '=', 'applications.id')
              ->selectRaw('branch_units.name as branch_name, service_units.name, service_units.code_area, count(branch_units.id) as total_branch, count(applications.marketing_id) as total_marketing, SUM(CASE WHEN approvals.status="queue" THEN 1 ELSE 0 END) as count_queue, SUM(CASE WHEN approvals.status="queue" THEN applications.plafon ELSE 0 END) as total_queue, SUM(CASE WHEN disbursements.status="approve" THEN 1 ELSE 0 END) as count_disbursement, SUM(CASE WHEN disbursements.status="approve" THEN applications.plafon ELSE 0 END) as total_disbursement')
              ->groupBy('branch_units.id');

        if ($user_role && in_array($user_role->slug, ['approval', 'bank'])) {
            $query->where('applications.bank_id', $user->bank_id);
        }

        return $query;
    }
}
