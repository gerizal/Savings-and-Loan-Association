<?php

namespace App\Models;

use App\Traits\Shardable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Taspen extends Model
{
    use HasFactory, SoftDeletes, Shardable;

    // High-volume debitur table — shard by id
    protected string $shardKey = 'id';

    protected $fillable = [
        'id_number',
        'name',
        'birth_place',
        'birth_date',
        'gender',
        'education',
        'phone_number',
        'religion',
        'tax_number',
        'mother_name',
        'address',
        'rt',
        'rw',
        'sub_district_id',
        'district_id',
        'city_id',
        'province_id',
        'post_code',
        'is_domicile',
        'current_job',
        'current_job_address',
        'business_type',
        'marital_status',
        'nopen',
        'employee_code',
        'work_periode',
        'employee_grade',
        'skep_name',
        'skep_number',
        'skep_date',
        'skep_publisher',
        'retirement_type',
        'participant_status',
        'nipnrp',
        'start_flagging',
        'end_flagging',
        'latitude',
        'longitude',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'birth_date'   => 'date',
        'skep_date'    => 'date',
        'is_domicile'  => 'boolean',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function domicile(): HasOne
    {
        return $this->hasOne(Domicile::class);
    }

    public function familyMembers(): HasMany
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function deductionAllowances(): HasMany
    {
        return $this->hasMany(DeductionAllowance::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'document_id')
                    ->where('document_type', self::class);
    }

    // -------------------------------------------------------------------------
    // Static helpers (retained — complex orchestration logic)
    // -------------------------------------------------------------------------

    /**
     * Create or update a Taspen record along with its Domicile and spouse
     * FamilyMember. Renamed from createUpdate() per refactor rules.
     */
    public static function fromRequest(Request $request, $id = null): self
    {
        $data = $id ? self::findOrFail($id) : new self;

        $geo_location = explode(',', $request->geo_location ?? '');
        if ((!$request->address_latitude || !$request->address_longitude) && count($geo_location) === 2) {
            $request->merge([
                'address_latitude'  => $geo_location[0],
                'address_longitude' => $geo_location[1],
            ]);
        }

        $data->fill([
            'id_number'          => $request->id_number,
            'name'               => $request->name,
            'birth_place'        => $request->birth_place,
            'birth_date'         => date('Y-m-d', strtotime($request->birth_date)),
            'gender'             => $request->gender,
            'education'          => $request->education,
            'phone_number'       => $request->phone_number,
            'religion'           => $request->religion,
            'tax_number'         => $request->tax_number,
            'mother_name'        => $request->mother_name,
            'address'            => $request->address,
            'rt'                 => $request->rt,
            'rw'                 => $request->rw,
            'sub_district_id'    => $request->sub_district_id,
            'district_id'        => $request->district_id,
            'city_id'            => $request->city_id,
            'province_id'        => $request->province_id,
            'post_code'          => $request->post_code,
            'is_domicile'        => $request->is_domicile,
            'current_job'        => $request->current_job,
            'current_job_address'=> $request->current_job_address,
            'business_type'      => $request->business_type,
            'marital_status'     => $request->marital_status,
            'nopen'              => $request->nopen,
            'employee_code'      => $request->employee_code,
            'work_periode'       => $request->work_periode,
            'employee_grade'     => $request->employee_grade,
            'skep_name'          => $request->skep_name,
            'skep_number'        => $request->skep_number,
            'skep_date'          => date('Y-m-d', strtotime($request->guarantee_skep_date ?? $request->skep_date)),
            'skep_publisher'     => $request->guarantee_skep_publisher ?? $request->skep_publisher,
            'retirement_type'    => $request->retirement_type,
            'participant_status' => $request->participant_status,
            'nipnrp'             => $request->nipnrp,
            'start_flagging'     => $request->start_flagging,
            'end_flagging'       => $request->end_flagging,
            'latitude'           => $request->address_latitude,
            'longitude'          => $request->address_longitude,
        ]);

        if ($id === null || $id === '') {
            $data->created_by = \Auth::id();
        } else {
            $data->updated_by = \Auth::id();
        }

        $data->save();

        // Domicile
        $domicileData = [
            'taspen_id'          => $data->id,
            'residential_status' => $request->residential_status,
            'occupied_at'        => $request->occupied_at,
            'address'            => $request->address,
            'rt'                 => $request->rt,
            'rw'                 => $request->rw,
            'sub_district_id'    => $request->sub_district_id,
            'district_id'        => $request->district_id,
            'city_id'            => $request->city_id,
            'province_id'        => $request->province_id,
            'post_code'          => $request->post_code,
            'latitude'           => $request->address_latitude,
            'longitude'          => $request->address_longitude,
        ];

        if (intval($data->is_domicile) === 0) {
            $domicileGeo = explode(',', $request->domicile_geo_location ?? '');
            if ((!$request->domicile_address_latitude || !$request->domicile_address_longitude) && count($domicileGeo) === 2) {
                $request->merge([
                    'domicile_address_latitude'  => $domicileGeo[0],
                    'domicile_address_longitude' => $domicileGeo[1],
                ]);
            }

            $domicileData = array_merge($domicileData, [
                'address'        => $request->domicile_address,
                'rt'             => $request->domicile_rt,
                'rw'             => $request->domicile_rw,
                'sub_district_id'=> $request->domicile_sub_district_id,
                'district_id'    => $request->domicile_district_id,
                'city_id'        => $request->domicile_city_id,
                'province_id'    => $request->domicile_province_id,
                'post_code'      => $request->domicile_post_code,
                'latitude'       => $request->domicile_address_latitude,
                'longitude'      => $request->domicile_address_longitude,
            ]);
        }

        Domicile::createUpdateByTaspen(new Request($domicileData));

        if ($data->marital_status === 'Kawin') {
            FamilyMember::createUpdateByTaspen(new Request([
                'taspen_id'       => $data->id,
                'id_number'       => $request->spouse_id_number,
                'name'            => $request->spouse_name,
                'birth_place'     => $request->spouse_birth_place,
                'birth_date'      => date('Y-m-d', strtotime($request->spouse_birth_date)),
                'occupation'      => $request->spouse_job,
                'relation_status' => 'spouse',
            ]));
        }

        return $data;
    }
}
