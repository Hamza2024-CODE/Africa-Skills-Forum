<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MinisterialOfficial extends Model
{
    use HasTranslations;

    protected $table = 'ministerial_officials';

    protected $fillable = [
        'uuid',
        'user_id',
        'country_id',
        'full_name',
        'title_ar',
        'title_fr',
        'title_en',
        'ministry_name',
        'availability_status',
        'contact_phone',
        'security_level',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($m) {
            if (empty($m->uuid)) {
                $m->uuid = (string) Str::uuid();
            }
        });
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hostedMeetings()
    {
        return $this->hasMany(DiplomaticMeeting::class, 'host_minister_id');
    }

    public function guestMeetings()
    {
        return $this->hasMany(DiplomaticMeeting::class, 'guest_minister_id');
    }
}
