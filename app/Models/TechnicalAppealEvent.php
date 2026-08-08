<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalAppealEvent extends Model
{
    protected $fillable = ['appeal_id', 'user_id', 'event_type', 'event_details'];

    public function appeal()
    {
        return $this->belongsTo(TechnicalAppeal::class, 'appeal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
