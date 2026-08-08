<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ParticipantClothing extends Model
{
    use HasTranslations;

    protected $table = 'participant_clothing';

    protected $fillable = [
        'uuid',
        'participant_profile_id',
        'item_name_ar',
        'item_name_fr',
        'item_name_en',
        'size',
        'quantity',
        'is_mandatory',
        'provided_by',
        'status',
        'delivered_at',
    ];

    protected $casts = [
        'is_mandatory' => 'boolean',
        'delivered_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cl) {
            if (empty($cl->uuid)) {
                $cl->uuid = (string) Str::uuid();
            }
        });
    }

    public function participantProfile()
    {
        return $this->belongsTo(ParticipantProfile::class);
    }
}
