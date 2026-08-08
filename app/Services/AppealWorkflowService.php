<?php

namespace App\Services;

use App\Models\TechnicalAppeal;
use App\Models\TechnicalAppealDecision;
use App\Models\TechnicalAppealEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * AppealWorkflowService
 *
 * Governs the strict multi-step Technical Appeals workflow.
 * All state transitions are validated and emit immutable audit events.
 *
 * Workflow: SUBMITTED → ELIGIBILITY_CHECK → UNDER_REVIEW → HEARING
 *           → DECISION_PENDING → UPHELD | REJECTED | PARTIALLY_UPHELD → CLOSED
 */
class AppealWorkflowService
{
    private const ALLOWED_TRANSITIONS = [
        'SUBMITTED'        => ['ELIGIBILITY_CHECK'],
        'ELIGIBILITY_CHECK'=> ['UNDER_REVIEW'],
        'UNDER_REVIEW'     => ['HEARING', 'DECISION_PENDING'],
        'HEARING'          => ['DECISION_PENDING'],
        'DECISION_PENDING' => ['UPHELD', 'REJECTED', 'PARTIALLY_UPHELD'],
        'UPHELD'           => ['CLOSED'],
        'REJECTED'         => ['CLOSED'],
        'PARTIALLY_UPHELD' => ['CLOSED'],
        'CLOSED'           => [],
    ];

    /** Advance the appeal to the next status. */
    public function transition(TechnicalAppeal $appeal, string $newStatus, int $userId, string $details = ''): void
    {
        $allowed = self::ALLOWED_TRANSITIONS[$appeal->status] ?? [];

        if (! in_array($newStatus, $allowed, true)) {
            throw new \DomainException(
                "لا يمكن الانتقال من الحالة [{$appeal->status}] إلى [{$newStatus}]."
            );
        }

        DB::transaction(function () use ($appeal, $newStatus, $userId, $details) {
            $previousStatus = $appeal->status;

            $appeal->update([
                'status'      => $newStatus,
                'reviewed_at' => in_array($newStatus, ['UNDER_REVIEW', 'HEARING']) ? now() : $appeal->reviewed_at,
                'decided_at'  => in_array($newStatus, ['UPHELD', 'REJECTED', 'PARTIALLY_UPHELD']) ? now() : $appeal->decided_at,
                'closed_at'   => $newStatus === 'CLOSED' ? now() : $appeal->closed_at,
            ]);

            TechnicalAppealEvent::create([
                'appeal_id'    => $appeal->id,
                'user_id'      => $userId,
                'event_type'   => 'STATUS_CHANGE',
                'event_details'=> "الحالة تغيرت من [{$previousStatus}] إلى [{$newStatus}]. {$details}",
            ]);

            Log::info('Appeal:StatusTransition', [
                'appeal_id'   => $appeal->id,
                'appeal_uuid' => $appeal->appeal_uuid,
                'from'        => $previousStatus,
                'to'          => $newStatus,
                'by'          => $userId,
                'at'          => now()->toIso8601String(),
            ]);
        });
    }

    /** Issue the final immutable decision on an appeal. */
    public function issueDecision(
        TechnicalAppeal $appeal,
        string $decision,
        string $reasoning,
        int $decidedByUserId
    ): TechnicalAppealDecision {
        $allowedDecisions = ['UPHELD', 'REJECTED', 'PARTIALLY_UPHELD'];

        if (! in_array($decision, $allowedDecisions, true)) {
            throw new \DomainException("القرار [{$decision}] غير صالح.");
        }

        if ($appeal->decision()->exists()) {
            throw new \DomainException('تم إصدار القرار مسبقاً. قرارات الطعون ثابتة ولا يمكن تعديلها.');
        }

        return DB::transaction(function () use ($appeal, $decision, $reasoning, $decidedByUserId) {
            $decisionRecord = TechnicalAppealDecision::create([
                'appeal_id'          => $appeal->id,
                'decided_by_user_id' => $decidedByUserId,
                'decision'           => $decision,
                'reasoning'          => $reasoning,
            ]);

            $this->transition($appeal, $decision, $decidedByUserId, "القرار: {$reasoning}");

            Log::info('Appeal:DecisionIssued', [
                'appeal_id'    => $appeal->id,
                'decision'     => $decision,
                'decided_by'   => $decidedByUserId,
                'at'           => now()->toIso8601String(),
            ]);

            return $decisionRecord;
        });
    }

    /** Add a comment event to the appeal audit trail. */
    public function addComment(TechnicalAppeal $appeal, int $userId, string $comment): void
    {
        if ($appeal->status === 'CLOSED') {
            throw new \DomainException('لا يمكن إضافة تعليق على طعن مغلق.');
        }

        TechnicalAppealEvent::create([
            'appeal_id'     => $appeal->id,
            'user_id'       => $userId,
            'event_type'    => 'COMMENT',
            'event_details' => $comment,
        ]);
    }

    public function statusLabel(string $status): string
    {
        return match ($status) {
            'SUBMITTED'         => 'تم الإيداع',
            'ELIGIBILITY_CHECK' => 'فحص الأهلية',
            'UNDER_REVIEW'      => 'قيد الدراسة',
            'HEARING'           => 'جلسة الاستماع',
            'DECISION_PENDING'  => 'في انتظار القرار',
            'UPHELD'            => 'مقبول',
            'REJECTED'          => 'مرفوض',
            'PARTIALLY_UPHELD'  => 'مقبول جزئياً',
            'CLOSED'            => 'مغلق',
            default             => $status,
        };
    }
}
