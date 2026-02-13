<?php

namespace App\Services;

use App\Models\TourCalculation;
use Carbon\Carbon;

class AgentService
{
    public function tourCounts(int $agentId): array
    {
        return [
            'total_tour_calculations' => TourCalculation::where('agent_id', $agentId)->count(),

            'total_revenue' => TourCalculation::where('agent_id', $agentId)
                ->sum('total_price'),

            'monthly_revenue' => TourCalculation::where('agent_id', $agentId)
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('total_price'),

            'recentCalculations' => TourCalculation::where('agent_id', $agentId)
                ->latest()
                ->take(10)
                ->get(),
        ];
    }

      public function get_calculation_report($agentId, $startDate = null, $endDate = null)
    {
        $query = TourCalculation::with(['destination', 'theme', 'package'])
            ->where('agent_id', $agentId);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function getActivityStats(int $agentId): array
    {
        $now = Carbon::now();
        
        $stats = [
            'current_month' => $this->getStatsForPeriod($agentId, $now->copy()->startOfMonth(), $now->copy()->endOfMonth()),
            'last_6_months' => $this->getStatsForPeriod($agentId, $now->copy()->subMonths(6)->startOfMonth(), $now->copy()->endOfMonth()),
            'this_year'     => $this->getStatsForPeriod($agentId, $now->copy()->startOfYear(), $now->copy()->endOfYear()),
            'last_year'     => $this->getStatsForPeriod($agentId, $now->copy()->subYear()->startOfYear(), $now->copy()->subYear()->endOfYear()),
        ];

        return $stats;
    }

    private function getStatsForPeriod(int $agentId, $startDate, $endDate): array
    {
        $query = TourCalculation::where('agent_id', $agentId)
            ->whereBetween('created_at', [$startDate, $endDate]);

        return [
            'count'   => (clone $query)->count(),
            'revenue' => (clone $query)->sum('total_price'),
        ];
    }

    public function getTargetData(int $agentId): array
    {
        $now = Carbon::now();
        
        // Mock targets for demonstration
        $monthlyTarget = 1000000; // 10 Lakhs
        $yearlyTarget = 10000000; // 1 Crore
        
        $currentMonthRevenue = TourCalculation::where('agent_id', $agentId)
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('total_price');
            
        $currentYearRevenue = TourCalculation::where('agent_id', $agentId)
            ->whereYear('created_at', $now->year)
            ->sum('total_price');
            
        $lastMonthRevenue = TourCalculation::where('agent_id', $agentId)
            ->whereMonth('created_at', $now->copy()->subMonth()->month)
            ->whereYear('created_at', $now->copy()->subMonth()->year)
            ->sum('total_price');

        // Timeline of recent activities
        $timeline = TourCalculation::with(['destination', 'package'])
            ->where('agent_id', $agentId)
            ->latest()
            ->take(20)
            ->get();

        return [
            'monthly' => [
                'target'   => $monthlyTarget,
                'achieved' => (float)$currentMonthRevenue,
                'percent'  => $monthlyTarget > 0 ? round(min(100, ($currentMonthRevenue / $monthlyTarget) * 100), 1) : 0
            ],
            'yearly' => [
                'target'   => $yearlyTarget,
                'achieved' => (float)$currentYearRevenue,
                'percent'  => $yearlyTarget > 0 ? round(min(100, ($currentYearRevenue / $yearlyTarget) * 100), 1) : 0
            ],
            'comparison' => [
                'current' => (float)$currentMonthRevenue,
                'last'    => (float)$lastMonthRevenue,
            ],
            'timeline' => $timeline
        ];
    }
}