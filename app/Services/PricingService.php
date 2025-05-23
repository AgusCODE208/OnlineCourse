<?php

namespace App\Services;

use App\Models\Pricing;
use App\Repositories\PricingRepositoryInterface;

class PricingService
{
    protected $pricingRepository;

    public function __construct(PricingRepositoryInterface $pricingRepository)
    {
        $this->pricingRepository = $pricingRepository;
    }

    public function getAllPackage()
    {
        return $this->pricingRepository->getAll();
    }
}
