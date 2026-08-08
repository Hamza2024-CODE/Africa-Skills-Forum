<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ParticipantDocument extends Model
{
    protected $fillable = [
        'uuid',
        'registration_id',
        'document_type',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
        'status',
        'rejection_reason',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($doc) {
            if (empty($doc->uuid)) {
                $doc->uuid = (string) Str::uuid();
            }
            if (empty($doc->original_name)) {
                $doc->original_name = basename((string) $doc->file_path);
            }
            if (empty($doc->mime_type)) {
                $doc->mime_type = 'application/octet-stream';
            }
            if (empty($doc->file_size)) {
                $doc->file_size = 0;
            }
        });
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
