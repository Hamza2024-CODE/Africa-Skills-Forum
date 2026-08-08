<?php

namespace App\Livewire\Admin;

use App\Models\ParticipantProfile;
use App\Services\ParticipantReadinessService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class ReadinessCenter extends Component
{
    public $readinessSummary = [
        'average_score' => 88,
        'ready_count' => 0,
        'pending_count' => 0,
    ];

    public function mount(ParticipantReadinessService $readinessService)
    {
        $participants = ParticipantProfile::all();

        if ($participants->count() > 0) {
            $totalScore = 0;
            $ready = 0;

            foreach ($participants as $p) {
                $calc = $readinessService->calculateReadiness($p);
                $totalScore += $calc['overall_score'];
                if ($calc['is_ready']) {
                    $ready++;
                }
            }

            $this->readinessSummary['average_score'] = round($totalScore / $participants->count());
            $this->readinessSummary['ready_count'] = $ready;
            $this->readinessSummary['pending_count'] = $participants->count() - $ready;
        }
    }

    public function render()
    {
        return view('livewire.admin.readiness-center');
    }
}
