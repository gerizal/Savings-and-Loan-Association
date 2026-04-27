<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'code',
        'phone_number',
        'address',
        'employee_id',
        'id_number',
        'first_name',
        'last_name',
        'birth_place',
        'birth_date',
        'job_title',
        'status_pkwt',
        'is_active',
        'contract_term',
        'target',
        'branch_unit_id',
        'bank_id',
        'created_by',
        'updated_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date'        => 'date',
        'is_active'         => 'boolean',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function branchUnit(): BelongsTo
    {
        return $this->belongsTo(BranchUnit::class);
    }

    public function userRole(): HasOne
    {
        return $this->hasOne(UserRole::class);
    }

    public function role(): HasOne
    {
        return $this->hasOneThrough(Role::class, UserRole::class, 'user_id', 'id', 'id', 'role_id');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'marketing_id');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Scope for the dashboard marketing summary.
     * Usage: User::scopeDashboard($query)->get()
     */
    public function scopeDashboard($query)
    {
        $user      = \Auth::user();
        $user_role = user_role();

        $query->join('branch_units', 'branch_units.id', '=', 'users.branch_unit_id')
              ->join('service_units', 'service_units.id', '=', 'branch_units.service_unit_id')
              ->leftJoin('applications', 'applications.marketing_id', '=', 'users.id')
              ->selectRaw('users.name as name, users.job_title, branch_units.name as branch_name, service_units.name as service_unit_name, count(applications.id) as total_debitur, SUM(CASE WHEN applications.status=1 THEN applications.plafon ELSE 0 END) as total_plafond')
              ->groupBy('users.id');

        if ($user_role && in_array($user_role->slug, ['approval', 'bank'])) {
            $query->where('applications.bank_id', $user->bank_id);
        }

        return $query;
    }
}
