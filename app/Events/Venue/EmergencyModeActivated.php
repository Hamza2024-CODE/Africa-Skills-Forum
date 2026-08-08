<?php

namespace App\Events\Venue;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmergencyModeActivated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public bool $active;
    public string $reasonAr;

    public function __construct(bool $active = true, string $reasonAr = 'تفعيل وضع الإخلاء الطارئ')
    {
        $this->active   = $active;
        $this->reasonAr = $reasonAr;
    }
}
