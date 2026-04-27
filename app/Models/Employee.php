<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Employee is a view/alias over the users table.
 * Complex createUpdate logic is retained (handles avatar upload, role assignment).
 */
class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'employee_id',
        'id_number',
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'birth_place',
        'birth_date',
        'address',
        'phone_number',
        'job_title',
        'status_pkwt',
        'is_active',
        'contract_term',
        'target',
        'branch_unit_id',
        'avatar',
        'created_by',
        'updated_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_active'  => 'boolean',
    ];

    // -------------------------------------------------------------------------
    // Static helpers (retained — handles avatar upload + role assignment)
    // -------------------------------------------------------------------------

    public static function fromRequest($request, $id = null): self
    {
        $data = $id ? self::findOrFail($id) : new self;

        $data->fill([
            'employee_id'   => $request->employee_id,
            'id_number'     => $request->id_number,
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'name'          => $request->name,
            'email'         => $request->email,
            'birth_place'   => $request->birth_place,
            'birth_date'    => date('Y-m-d', strtotime($request->birth_date)),
            'address'       => $request->address,
            'phone_number'  => $request->phone_number,
            'job_title'     => $request->job_title,
            'status_pkwt'   => $request->status_pkwt,
            'is_active'     => 0,
            'contract_term' => $request->masa_kontrak,
            'target'        => $request->target,
            'branch_unit_id'=> $request->branch_unit_id,
        ]);

        if ($request->has('password') && $request->password !== '') {
            $data->password = bcrypt($request->password);
        }

        if ($id === null || $id === '') {
            $data->created_by = \Auth::id();
        } else {
            $data->updated_by = \Auth::id();
        }

        $data->save();

        $role_user = new UserRole;
        $role_user->role_id = $request->role_id;
        $role_user->user_id = $data->id;
        $role_user->save();

        if ($request->hasFile('picture')) {
            $filename = $data->id . '.jpg';
            $filePath = 'avatar/' . $data->id . '/' . $filename;
            $azure    = \Storage::disk('azure');
            $azure->put($filePath, file_get_contents($request->picture), 'public');
            $data->avatar = $filePath;
            \Log::info('GENERATE', ['URL' => generateSecureUrl($data->avatar)]);
            $data->save();
        }

        return $data;
    }
}
