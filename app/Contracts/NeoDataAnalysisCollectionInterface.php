<?php

namespace App\Contracts;

use App\Models\NeoObject;

interface NeoDataAnalysisCollectionInterface
{
    public function totalNeoCount(): int;

    public function avgEstimatedDiameterMin(): float;

    public function avgEstimatedDiameterMax(): float;

    public function maxVelocity(): float;

    public function minMissDistance(): float;

}
