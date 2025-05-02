<?php

namespace Tests\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

trait MockNasaNeoClient
{
    protected function fakeNasaNeoApiResponse(?Carbon $date = null): void
    {
        $date = $date ?? now();

        Http::fake([
            'https://api.nasa.gov/neo/*' => Http::response([
                'near_earth_objects' => [
                    $date->toDateString() => [
                        [
                            'neo_reference_id' => '123456',
                            'name' => 'Mock Asteroid',
                            'nasa_jpl_url' => 'https://example.com',
                            'absolute_magnitude_h' => 20.5,
                            'estimated_diameter' => [
                                'meters' => [
                                    'estimated_diameter_min' => 50.0,
                                    'estimated_diameter_max' => 150.0,
                                ],
                            ],
                            'is_potentially_hazardous_asteroid' => false,
                            'is_sentry_object' => false,
                            'close_approach_data' => [
                                [
                                    'close_approach_date' => $date->toDateString(),
                                    'close_approach_date_full' => $date->toDateTimeString(),
                                    'epoch_date_close_approach' => $date->timestamp * 1000,
                                    'relative_velocity' => [
                                        'kilometers_per_second' => '12.34',
                                    ],
                                    'miss_distance' => [
                                        'kilometers' => '123456.78',
                                    ],
                                    'orbiting_body' => 'Earth',
                                ],
                            ],
                        ]
                    ]
                ]
            ], 200),
        ]);
    }
}
