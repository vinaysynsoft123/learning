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

      public function get_calculation_report($agentId)
        {
            return TourCalculation::where('agent_id', $agentId)
                ->orderBy('created_at', 'desc')
                ->get();
        }

}