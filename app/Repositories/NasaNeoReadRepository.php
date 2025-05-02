<?php

namespace App\Repositories;

use App\Contracts\NeoReadRepositoryInterface;
use App\Providers\NasaNeoDataProvider;
use Illuminate\Support\Collection;
use \Illuminate\Support\Carbon;

class NasaNeoReadRepository implements NeoReadRepositoryInterface
{
    public function __construct(
        protected NasaNeoDataProvider $provider
    ) {}

    /**
     * Get NEO data for a specific day.
     */
    public function getDataForDateRange(Carbon $startDate, Carbon $endDate): Collection
    {
        return $this->provider->fetchForDateRange($startDate, $endDate);
    }
}
