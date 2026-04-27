<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domicile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'taspen_id',
        'residential_status',
        'occupied_at',
        'address',
        'rt',
        'rw',
        'sub_district_id',
        'district_id',
        'city_id',
        'province_id',
        'post_code',
        'latitude',
        'longitude',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'taspen_id'       => 'integer',
        'sub_district_id' => 'integer',
        'district_id'     => 'integer',
        'city_id'         => 'integer',
        'province_id'     => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function taspen(): BelongsTo
    {
        return $this->belongsTo(Taspen::class);
    }

    // -------------------------------------------------------------------------
    // Static helpers (retained — upsert-by-taspen logic)
    // -------------------------------------------------------------------------

    public static function createUpdateByTaspen($request): self
    {
        $data = self::whereTaspenId($request->taspen_id)->first();
        if (!$data) {
            $data = new self;
            $data->created_by = \Auth::id();
        } else {
            $data->updated_by = \Auth::id();
        }

        $data->fill([
            'taspen_id'          => $request->taspen_id,
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
            'latitude'           => $request->latitude,
            'longitude'          => $request->longitude,
        ]);
        $data->save();

        return $data;
    }
}
