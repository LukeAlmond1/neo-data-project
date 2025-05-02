<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Contracts\NeoApiDataInterface;
use Illuminate\Support\Collection;

class NasaNeoApi implements NeoApiDataInterface
{
    /**
     * @param Collection<int, NasaCloseApproachData> $closeApproaches
     */
    public function __construct(
        public string $referenceId,
        public string $name,
        public float $absoluteMagnitude,
        public float $estimatedDiameterMin,
        public float $estimatedDiameterMax,
        public bool $isHazardous,
        public Collection $closeApproaches,
    ) {}

    public static function createFromApi(array $data): self
    {
        $approaches = collect($data['close_approach_data'] ?? [])
            ->map(fn (array $a) => NasaCloseApproachData::createFromApi($a));

        return new self(
            $data['neo_reference_id'],
            $data['name'],
            $data['absolute_magnitude_h'],
            $data['estimated_diameter']['meters']['estimated_diameter_min'],
            $data['estimated_diameter']['meters']['estimated_diameter_max'],
            $data['is_potentially_hazardous_asteroid'],
            $approaches,
        );
    }
}
