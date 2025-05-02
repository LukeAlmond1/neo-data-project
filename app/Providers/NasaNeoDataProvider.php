<?php

namespace App\Providers;

use App\Clients\NasaNeoClient;
use App\Contracts\NeoDataProviderInterface;
use App\Dtos\NasaNeoApi;
use App\Enums\NasaNeoDataEndpointsEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

class NasaNeoDataProvider implements NeoDataProviderInterface
{
    public function __construct(protected NasaNeoClient $client) {}

    public function fetchForDateRange(Carbon $startDate, Carbon $endDate): Collection
    {
        $response = $this->client->client()->get(NasaNeoDataEndpointsEnum::FEED->uri(), [
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
        ]);

        return $response
            ->collect('near_earth_objects')
            ->flatMap(fn ($objects) => $objects)
            ->map(fn ($neo) => NasaNeoApi::createFromApi($neo));
    }
}
