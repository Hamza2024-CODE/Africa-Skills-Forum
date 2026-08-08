<?php

namespace App\Services;

use App\Models\ParticipantDocument;
use App\Models\ParticipantEquipmentChecklist;
use App\Models\ParticipantProfile;

class ParticipantReadinessService
{
    /**
     * Calculate dynamic readiness breakdown and overall score for a participant.
     */
    public function calculateReadiness(ParticipantProfile $participant): array
    {
        $regIds = $participant->registrations()->pluck('id');

        // 1. Documents Readiness
        $totalDocs = ParticipantDocument::whereIn('registration_id', $regIds)->count();
        $verifiedDocs = ParticipantDocument::whereIn('registration_id', $regIds)
            ->where('status', 'VERIFIED')->count();
        $docScore = $totalDocs > 0 ? round(($verifiedDocs / $totalDocs) * 100) : 100;

        // 2. Equipment Readiness
        $totalEquipment = ParticipantEquipmentChecklist::where('participant_profile_id', $participant->id)->count();
        $readyEquipment = ParticipantEquipmentChecklist::where('participant_profile_id', $participant->id)
            ->whereIn('status', ['RECEIVED', 'VERIFIED'])->count();
        $equipScore = $totalEquipment > 0 ? round(($readyEquipment / $totalEquipment) * 100) : 100;

        // 3. Registration Approval Readiness
        $registration = $participant->registrations()->latest()->first();
        $approvalScore = ($registration && in_array($registration->status, ['APPROVED', 'QUALIFIED', 'COMPLETED'])) ? 100 : 50;

        // 4. Overall Weighted Score (Documents 35%, Equipment 35%, Approval 30%)
        $overallScore = round(($docScore * 0.35) + ($equipScore * 0.35) + ($approvalScore * 0.30));

        return [
            'overall_score' => $overallScore,
            'documents_score' => $docScore,
            'equipment_score' => $equipScore,
            'approval_score' => $approvalScore,
            'is_ready' => $overallScore >= 80,
        ];
    }
}
