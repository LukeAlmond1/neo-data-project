<?php

declare(strict_types=1);

namespace App\Collections;

use App\Models\NeoObject;
use Illuminate\Support\Collection;

class NeoDataAnalysisCollection extends Collection
{

    public function totalNeoCount(): int
    {
        return $this->count();
    }

    public function avgEstimatedDiameterMin(): float
    {
        return $this->avg('estimated_diameter_min') ?? 0.0;
    }

    public function avgEstimatedDiameterMax(): float
    {
        return $this->avg('estimated_diameter_max') ?? 0.0;
    }

    public function maxVelocity(): float
    {
        return $this->flatMap(function (NeoObject $neo) {
            return $neo->closeApproaches->pluck('relative_velocity');
        })->max() ?? 0.0;
    }

    public function minMissDistance(): float
    {
        return $this->flatMap(function (NeoObject $neo) {
            return $neo->closeApproaches->pluck('miss_distance');
        })->min() ?? 0.0;
    }
}
