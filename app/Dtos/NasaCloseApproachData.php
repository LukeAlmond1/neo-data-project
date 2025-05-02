<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Contracts\NeoApiDataInterface;
use App\Enums\UnitsEnum;
use App\Services\UnitService;
use Illuminate\Support\Carbon;

class NasaCloseApproachData implements NeoApiDataInterface
{
    public function __construct(
        public float $relativeVelocity,
        public float $missDistance,
        public Carbon $closeApproachDateFull
    )
    {
    }

    public static function createFromApi (array $data): self
    {
        return new self (
            UnitService::convertToMetres(
                UnitsEnum::KILOMETERS,
                (float) $data['relative_velocity']['kilometers_per_second']
            ),
            UnitService::convertToMetres(
                UnitsEnum::KILOMETERS,
                (float) $data['miss_distance']['kilometers']
            ),
            Carbon::parse($data['close_approach_date_full'])
        );
    }

}
