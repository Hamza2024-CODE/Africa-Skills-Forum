<?php

namespace App\Services;

use App\Models\CompetitionAssessmentModule;
use App\Models\ParticipantAssessment;
use App\Models\ParticipantScore;
use App\Models\CompetitionResult;
use App\Models\ScoreModeration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * CisScoringService
 *
 * Domain service for competition scoring, validation, ranking, and medal determination.
 * All business logic is encapsulated here — Livewire/Blade are consumers only.
 */
class CisScoringService
{
    /* ------------------------------------------------------------------ */
    /* Medal Thresholds (WSI Standard)                                      */
    /* ------------------------------------------------------------------ */
    const GOLD_THRESHOLD                = 90.0;
    const SILVER_THRESHOLD              = 85.0;
    const BRONZE_THRESHOLD              = 80.0;
    const MEDALLION_EXCELLENCE_THRESHOLD = 75.0;

    /* ------------------------------------------------------------------ */
    /* Score Submission                                                     */
    /* ------------------------------------------------------------------ */

    /**
     * Submit a score for one criterion by a judge.
     * Validates bounds, checks assessment lock, and records an audit entry.
     *
     * @throws \DomainException if assessment is locked or score is out of bounds
     */
    public function submitScore(
        int    $assessmentId,
        int    $criterionId,
        int    $judgeUserId,
        float  $score,
        string $notes = ''
    ): ParticipantScore {
        $assessment = ParticipantAssessment::findOrFail($assessmentId);

        if ($assessment->is_locked) {
            throw new \DomainException('لا يمكن تعديل التقييم بعد قفله من قِبل رئيس الخبراء.');
        }

        $criterion = $assessment->module->criteria()->findOrFail($criterionId);

        $score = $this->validateScoreBounds($score, $criterion->max_score);

        return DB::transaction(function () use ($assessment, $criterionId, $judgeUserId, $score, $notes) {
            $participantScore = ParticipantScore::updateOrCreate(
                [
                    'assessment_id'  => $assessment->id,
                    'criterion_id'   => $criterionId,
                    'judge_user_id'  => $judgeUserId,
                ],
                [
                    'score' => $score,
                    'notes' => $notes,
                ]
            );

            $this->recalculateAssessmentTotal($assessment);

            Log::info('CIS:ScoreSubmitted', [
                'assessment_id' => $assessment->id,
                'criterion_id'  => $criterionId,
                'judge_id'      => $judgeUserId,
                'score'         => $score,
                'user_id'       => Auth::id(),
            ]);

            return $participantScore;
        });
    }

    /* ------------------------------------------------------------------ */
    /* Score Moderation (Chief Expert Only)                                 */
    /* ------------------------------------------------------------------ */

    /**
     * Chief Expert moderates (adjusts) an assessment total and records versioned adjustment.
     *
     * @throws \DomainException if assessment is already locked
     */
    public function moderateScore(
        int    $assessmentId,
        int    $chiefExpertUserId,
        float  $adjustedScore,
        string $reason
    ): ScoreModeration {
        $assessment = ParticipantAssessment::findOrFail($assessmentId);

        if ($assessment->is_locked) {
            throw new \DomainException('التقييم محقون (مقفل) ولا يمكن تعديله. استخدم صلاحية إعادة الفتح أولاً.');
        }

        $adjustedScore = $this->validateScoreBounds(
            $adjustedScore,
            $assessment->module->max_score
        );

        return DB::transaction(function () use ($assessment, $chiefExpertUserId, $adjustedScore, $reason) {
            $moderation = ScoreModeration::create([
                'assessment_id'           => $assessment->id,
                'chief_expert_user_id'    => $chiefExpertUserId,
                'previous_score'          => $assessment->total_score,
                'adjusted_score'          => $adjustedScore,
                'reason'                  => $reason,
            ]);

            $assessment->update(['total_score' => $adjustedScore]);

            Log::info('CIS:ScoreModerated', [
                'assessment_id'  => $assessment->id,
                'previous_score' => $moderation->previous_score,
                'adjusted_score' => $adjustedScore,
                'chief_id'       => $chiefExpertUserId,
            ]);

            return $moderation;
        });
    }

    /* ------------------------------------------------------------------ */
    /* Score Locking (Chief Expert)                                         */
    /* ------------------------------------------------------------------ */

    public function lockAssessment(int $assessmentId, int $chiefExpertUserId): void
    {
        $assessment = ParticipantAssessment::findOrFail($assessmentId);

        if ($assessment->is_locked) {
            throw new \DomainException('التقييم مقفل مسبقاً.');
        }

        $assessment->update([
            'is_locked'          => true,
            'locked_at'          => now(),
            'locked_by_user_id'  => $chiefExpertUserId,
        ]);

        Log::info('CIS:AssessmentLocked', [
            'assessment_id'  => $assessmentId,
            'locked_by'      => $chiefExpertUserId,
            'locked_at'      => now()->toIso8601String(),
        ]);
    }

    /**
     * Re-open a locked assessment — requires SUPER_ADMIN or CHIEF_EXPERT privilege.
     * Always creates an immutable audit log entry.
     */
    public function reopenAssessment(int $assessmentId, int $userId, string $reason): void
    {
        $assessment = ParticipantAssessment::findOrFail($assessmentId);

        $assessment->update([
            'is_locked'         => false,
            'locked_at'         => null,
            'locked_by_user_id' => null,
        ]);

        Log::info('CIS:AssessmentReopened', [
            'assessment_id' => $assessmentId,
            'reopened_by'   => $userId,
            'reason'        => $reason,
            'reopened_at'   => now()->toIso8601String(),
        ]);
    }

    /* ------------------------------------------------------------------ */
    /* Ranking & Medal Calculation                                          */
    /* ------------------------------------------------------------------ */

    /**
     * Calculate and persist competition results (ranking + awards) for a skill in an edition.
     * Fetches all locked assessments grouped by participant, computes final scores,
     * assigns ranks and medal awards.
     */
    public function calculateResultsForSkill(int $skillId, int $editionId): void
    {
        $modules = CompetitionAssessmentModule::where('skill_id', $skillId)
            ->where('edition_id', $editionId)
            ->get();

        if ($modules->isEmpty()) {
            throw new \DomainException('لم يتم تحديد وحدات التقييم لهذا التخصص والدورة.');
        }

        $maxTotalScore = $modules->sum('max_score');

        // Aggregate participant total scores across all locked modules
        $participantScores = ParticipantAssessment::whereIn('module_id', $modules->pluck('id'))
            ->where('is_locked', true)
            ->selectRaw('registration_id, SUM(total_score) as aggregate_score')
            ->groupBy('registration_id')
            ->orderByDesc('aggregate_score')
            ->get();

        DB::transaction(function () use ($participantScores, $skillId, $maxTotalScore) {
            $rank = 1;
            foreach ($participantScores as $row) {
                $pct   = $maxTotalScore > 0 ? ($row->aggregate_score / $maxTotalScore) * 100 : 0;
                $award = $this->determineAward($pct);

                CompetitionResult::updateOrCreate(
                    ['registration_id' => $row->registration_id, 'skill_id' => $skillId],
                    [
                        'final_score'  => round($row->aggregate_score, 3),
                        'rank'         => $rank,
                        'award'        => $award,
                        'is_published' => false,
                    ]
                );

                $rank++;
            }

            Log::info('CIS:ResultsCalculated', [
                'skill_id'       => $skillId,
                'participant_ct' => $participantScores->count(),
                'calculated_by'  => Auth::id(),
                'at'             => now()->toIso8601String(),
            ]);
        });
    }

    /**
     * Detect score discrepancies among judges for an assessment.
     * Flags any criterion where score range (MAX - MIN) across judges exceeds 1.0.
     */
    public function detectDiscrepancies(int $assessmentId): array
    {
        $scores = ParticipantScore::with('criterion')
            ->where('assessment_id', $assessmentId)
            ->get()
            ->groupBy('criterion_id');

        $discrepancies = [];

        foreach ($scores as $criterionId => $criterionScores) {
            if ($criterionScores->count() < 2) {
                continue;
            }

            $min = $criterionScores->min('score');
            $max = $criterionScores->max('score');
            $range = $max - $min;

            if ($range > 1.0) {
                $criterion = $criterionScores->first()->criterion;
                $discrepancies[] = [
                    'criterion_id' => $criterionId,
                    'title'        => $criterion?->title_ar ?? "Criterion #{$criterionId}",
                    'type'         => $criterion?->type ?? 'JUDGEMENT',
                    'range'        => round($range, 2),
                    'min_score'    => $min,
                    'max_score'    => $max,
                    'judge_count'  => $criterionScores->count(),
                ];
            }
        }

        return $discrepancies;
    }

    /* ------------------------------------------------------------------ */
    /* Private Helpers                                                      */
    /* ------------------------------------------------------------------ */

    private function validateScoreBounds(float $score, float $maxScore): float
    {
        if ($score < 0) {
            throw new \DomainException('لا يمكن أن تكون العلامة سالبة.');
        }

        if ($score > $maxScore) {
            throw new \DomainException("العلامة {$score} تتجاوز الحد الأقصى المسموح به ({$maxScore}).");
        }

        return round($score, 3);
    }

    private function recalculateAssessmentTotal(ParticipantAssessment $assessment): void
    {
        $total = $assessment->scores()->sum('score');
        $assessment->update(['total_score' => round($total, 3)]);
    }

    private function determineAward(float $percentage): string
    {
        return match (true) {
            $percentage >= self::GOLD_THRESHOLD                 => 'GOLD',
            $percentage >= self::SILVER_THRESHOLD               => 'SILVER',
            $percentage >= self::BRONZE_THRESHOLD               => 'BRONZE',
            $percentage >= self::MEDALLION_EXCELLENCE_THRESHOLD => 'MEDALLION_FOR_EXCELLENCE',
            default                                             => 'NONE',
        };
    }
}
