<?php

namespace App\Services;

use App\Repositories\TourCalculationRepository;

class TourCalculationService
{
    protected $repo;

    public function __construct(TourCalculationRepository $repo)
    {
        $this->repo = $repo;
    }

    public function listCalculations(array $filters = [])
    {
        return $this->repo->getFiltered($filters);
    }

    public function getCalculation($id)
    {
        return $this->repo->findById($id);
    }
}
