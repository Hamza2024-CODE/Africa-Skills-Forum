<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalAppealDecision extends Model
{
    protected $fillable = ['appeal_id', 'decided_by_user_id', 'decision', 'reasoning'];

    // Decisions are IMMUTABLE — no soft deletes, no updates allowed
    public static function boot()
    {
        parent::boot();
        static::updating(function () {
            throw new \RuntimeException('Appeal decisions are immutable and cannot be modified after issuance.');
        });
        static::deleting(function () {
            throw new \RuntimeException('Appeal decisions cannot be deleted.');
        });
    }

    public function appeal()
    {
        return $this->belongsTo(TechnicalAppeal::class, 'appeal_id');
    }

    public function decidedBy()
    {
        return $this->belongsTo(User::class, 'decided_by_user_id');
    }
}
