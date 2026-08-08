<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DelegationArrival extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'arrival_date',
        'arrival_time',
        'airline_name',
        'flight_number',
        'arrival_airport',
        'passenger_count',
        'ticket_path',
        'ticket_filename',
        'ticket_type',
        'notes',
        'status',
        'shuttle_assigned',
    ];

    protected $casts = [
        'arrival_date' => 'date:Y-m-d',
        'passenger_count' => 'integer',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
