<?php

namespace App\Repositories;

use App\Models\TourCalculation;

class TourCalculationRepository
{
    protected $model;

    public function __construct(TourCalculation $model)
    {
        $this->model = $model;
    }

    public function query()
    {
        return $this->model->with([
            'agent',
            'destination',
            'package',
            'vehicle'
        ])->latest();
    }

    public function getFiltered(array $filters = [], $perPage = 2)
    {
        $query = $this->query();

        if (!empty($filters['agent_id'])) {
            $query->where('agent_id', $filters['agent_id']);
        }

        if (!empty($filters['destination_id'])) {
            $query->where('destination_id', $filters['destination_id']);
        }

        if (!empty($filters['travel_date'])) {
            $query->whereDate('travel_date', $filters['travel_date']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function findById($id)
    {
        return $this->model->with([
            'agent',
            'destination',          
            'hotelCategory',
            'vehicle'
        ])->findOrFail($id);
    }
}
