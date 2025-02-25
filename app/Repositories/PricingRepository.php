<?php

namespace App\Repositories;

use App\Models\Pricing;
use illuminate\Support\Collection;

class PricingRepository implements PricingRepositoryInterface
{
    public function findByID(int $id): ?Pricing
    {
        return Pricing::find($id);
    }

    public function getAll(): Collection
    {
        return Pricing::all();
    }
}
