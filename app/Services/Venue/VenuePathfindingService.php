<?php

namespace App\Services\Venue;

use App\Models\VenueEdge;
use App\Models\VenueNode;
use Illuminate\Support\Collection;

class VenuePathfindingService
{
    /**
     * Compute path using Dijkstra's shortest path algorithm over spatial graph.
     * Generates Turn-by-Turn Navigation DTO with structured steps.
     */
    public function findPath(
        int $originNodeId,
        int $destinationNodeId,
        bool $requireAccessible = false,
        bool $emergencyEvacuation = false
    ): array {
        $nodes = VenueNode::all()->keyBy('id');
        $edgesQuery = VenueEdge::query();

        if ($requireAccessible) {
            $edgesQuery->where('is_accessible', true);
        }

        $edges = $edgesQuery->get();

        // Build adjacency graph
        $graph = [];
        foreach ($edges as $edge) {
            $graph[$edge->from_node_id][] = [
                'to'       => $edge->to_node_id,
                'distance' => (float) $edge->distance_meters,
                'seconds'  => (int) $edge->walk_seconds,
            ];
            // Undirected graph (bidirectional walking paths)
            $graph[$edge->to_node_id][] = [
                'to'       => $edge->from_node_id,
                'distance' => (float) $edge->distance_meters,
                'seconds'  => (int) $edge->walk_seconds,
            ];
        }

        // Emergency Mode Override: Find nearest emergency exit node if requested
        if ($emergencyEvacuation) {
            $exitNode = VenueNode::where('is_emergency_exit', true)->first();
            if ($exitNode) {
                $destinationNodeId = $exitNode->id;
            }
        }

        if (!isset($nodes[$originNodeId]) || !isset($nodes[$destinationNodeId])) {
            return [
                'found'            => false,
                'message'          => 'عفواً، تعذر تحديد عقد البداية أو النهاية في الخريطة المكانية.',
                'total_distance_m' => 0,
                'total_walk_sec'   => 0,
                'path_nodes'       => [],
                'steps'            => [],
            ];
        }

        // Dijkstra implementation
        $distances = [];
        $walkTimes = [];
        $previous = [];
        $queue = new \SplPriorityQueue();

        foreach ($nodes as $id => $node) {
            $distances[$id] = INF;
            $walkTimes[$id] = INF;
            $previous[$id] = null;
        }

        $distances[$originNodeId] = 0;
        $walkTimes[$originNodeId] = 0;
        $queue->insert($originNodeId, 0);

        while (!$queue->isEmpty()) {
            $current = $queue->extract();

            if ($current === $destinationNodeId) {
                break;
            }

            if (!isset($graph[$current])) {
                continue;
            }

            foreach ($graph[$current] as $neighbor) {
                $altDistance = $distances[$current] + $neighbor['distance'];
                $altSeconds  = $walkTimes[$current] + $neighbor['seconds'];

                if ($altDistance < $distances[$neighbor['to']]) {
                    $distances[$neighbor['to']] = $altDistance;
                    $walkTimes[$neighbor['to']] = $altSeconds;
                    $previous[$neighbor['to']]  = $current;
                    $queue->insert($neighbor['to'], -$altDistance);
                }
            }
        }

        if ($distances[$destinationNodeId] === INF) {
            return [
                'found'            => false,
                'message'          => 'لا يوجد مسار مشاة متاح حالياً بين هاتين النقطتين.',
                'total_distance_m' => 0,
                'total_walk_sec'   => 0,
                'path_nodes'       => [],
                'steps'            => [],
            ];
        }

        // Reconstruct path
        $path = [];
        $curr = $destinationNodeId;
        while ($curr !== null) {
            $nodeObj = $nodes[$curr];
            array_unshift($path, [
                'id'            => $nodeObj->id,
                'node_code'     => $nodeObj->node_code,
                'pos_x'         => $nodeObj->pos_x,
                'pos_y'         => $nodeObj->pos_y,
                'pos_z'         => $nodeObj->pos_z,
                'is_accessible' => $nodeObj->is_accessible,
            ]);
            $curr = $previous[$curr];
        }

        $totalMeters = round($distances[$destinationNodeId], 1);
        $totalSeconds = (int) $walkTimes[$destinationNodeId];
        $minutes = max(1, (int) ceil($totalSeconds / 60));

        // Generate Turn-by-Turn Navigation Steps Array
        $steps = [];
        for ($i = 0; $i < count($path); $i++) {
            $seq = $i + 1;
            $nodeCode = $path[$i]['node_code'];
            $instruction = "مرحلة {$seq}: انطلق عبر {$nodeCode}";
            if ($i === 0) {
                $instruction = "مرحلة 1: الانطلاق من موقعك الحالي ({$nodeCode})";
            } elseif ($i === count($path) - 1) {
                $instruction = "مرحلة {$seq}: الوصول إلى وجهتك الأخيرة ({$nodeCode})";
            }

            $steps[] = [
                'sequence'        => $seq,
                'node_code'       => $nodeCode,
                'instruction'     => $instruction,
                'distance_meters' => round($totalMeters / max(1, count($path) - 1), 1),
                'accessible'      => $path[$i]['is_accessible'],
            ];
        }

        return [
            'found'            => true,
            'message'          => "مسار متاح ({$totalMeters} متر - حوالي {$minutes} دقائق مشياً)",
            'total_distance_m' => $totalMeters,
            'total_walk_sec'   => $totalSeconds,
            'total_walk_min'   => $minutes,
            'is_accessible'    => $requireAccessible,
            'is_emergency'     => $emergencyEvacuation,
            'path_nodes'       => $path,
            'steps'            => $steps,
        ];
    }
}
