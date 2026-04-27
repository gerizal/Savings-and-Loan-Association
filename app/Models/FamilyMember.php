<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'taspen_id',
        'id_number',
        'name',
        'birth_place',
        'birth_date',
        'occupation',
        'relation_status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'taspen_id'  => 'integer',
        'birth_date' => 'date',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function taspen(): BelongsTo
    {
        return $this->belongsTo(Taspen::class);
    }

    // -------------------------------------------------------------------------
    // Static helpers (retained — upsert-by-taspen+relation logic)
    // -------------------------------------------------------------------------

    public static function createUpdateByTaspen($request): self
    {
        $data = self::whereTaspenId($request->taspen_id)
                    ->whereRelationStatus($request->relation_status)
                    ->first();

        if (!$data) {
            $data = new self;
            $data->created_by = \Auth::id();
        } else {
            $data->updated_by = \Auth::id();
        }

        $data->fill([
            'taspen_id'       => $request->taspen_id,
            'id_number'       => $request->id_number,
            'name'            => $request->name,
            'birth_place'     => $request->birth_place,
            'birth_date'      => $request->birth_date,
            'occupation'      => $request->occupation,
            'relation_status' => $request->relation_status,
        ]);
        $data->save();

        return $data;
    }
}
