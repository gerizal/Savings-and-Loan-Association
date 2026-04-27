<?php

namespace App\Models;

use File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'document_type',
        'document_id',
        'type',
        'name',
        'url',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    /**
     * Polymorphic: belongs to either Taspen or Application (or any model).
     */
    public function documentable(): MorphTo
    {
        return $this->morphTo('document', 'document_type', 'document_id');
    }

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    public function getUrlAttribute($value): ?string
    {
        return $value ? generateSecureUrl($value) : null;
    }

    // -------------------------------------------------------------------------
    // Static helpers
    // -------------------------------------------------------------------------

    /**
     * Upsert a document record by (document_type, document_id, type).
     */
    public static function createUpdate(array $data): self
    {
        $document = self::where('document_type', $data['document_type'])
                        ->where('document_id', $data['document_id'])
                        ->where('type', $data['type'])
                        ->first() ?? new self;

        $document->fill([
            'name'          => $data['name'],
            'url'           => $data['url'],
            'document_type' => $data['document_type'],
            'document_id'   => $data['document_id'],
            'type'          => $data['type'],
        ]);
        $document->save();

        return $document;
    }

    /**
     * Upload a file to Azure storage and return metadata.
     */
    public static function uploadFile($file, $user_id = null): array
    {
        $original_name = $file->getClientOriginalName();
        $file_name     = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
        $file_size     = File::size($file);
        $file_type     = File::mimeType($file);
        $file_path     = "documents/{$file_name}";

        Storage::disk('azure')->put($file_path, file_get_contents($file));

        return [
            'name'          => $file_name,
            'original_name' => $original_name,
            'size'          => $file_size,
            'type'          => $file_type,
            'path'          => $file_path,
        ];
    }
}
