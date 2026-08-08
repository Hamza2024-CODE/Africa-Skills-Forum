<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BadgeReplacement extends Model
{
    protected $table = 'wsap_badge_replacements';

    protected $fillable = [
        'original_badge_id',
        'replacement_badge_id',
        'user_id',
        'action_type',
        'reason_ar',
        'performed_by',
    ];

    public function originalBadge()
    {
        return $this->belongsTo(Badge::class, 'original_badge_id');
    }

    public function replacementBadge()
    {
        return $this->belongsTo(Badge::class, 'replacement_badge_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
