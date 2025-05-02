<?php

namespace Tests\Feature\Controllers;

use App\Models\NeoDataAnalysis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\MockNasaNeoClient;

class NeoDataAnalysisControllerTest extends TestCase
{
    use RefreshDatabase;
    use MockNasaNeoClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fakeNasaNeoApiResponse();
    }

    public function testReturnsPaginatedNeoDataAnalysisList(): void
    {
        NeoDataAnalysis::factory()->count(15)->create();

        $response = $this->getJson('/neo-analysis');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'analysis_date',
                    'total_neo_count',
                    'avg_estimated_diameter_min',
                    'avg_estimated_diameter_max',
                    'max_velocity',
                    'min_miss_distance',
                    'created_at',
                    'updated_at',
                ]
            ],
            'meta' => ['current_page', 'last_page', 'total'],
        ]);
    }

    public function testFiltersResultsByDateRange(): void
    {
        $inside = NeoDataAnalysis::forceCreate([
            'total_neo_count' => 1,
            'avg_estimated_diameter_min' => 1.0,
            'avg_estimated_diameter_max' => 1.0,
            'max_velocity' => 1.0,
            'min_miss_distance' => 1.0,
            'created_at' => now()->startOfDay(),
        ]);

        $outside = NeoDataAnalysis::forceCreate([
            'total_neo_count' => 1,
            'avg_estimated_diameter_min' => 1.0,
            'avg_estimated_diameter_max' => 1.0,
            'max_velocity' => 1.0,
            'min_miss_distance' => 1.0,
            'created_at' => now()->subDays(10)->startOfDay(),
        ]);

        $response = $this->getJson('/neo-analysis?start_date=' . now()->toDateString() . '&end_date=' . now()->toDateString());

        $response->assertOk();
        $response->assertJsonFragment(['id' => $inside->id]);
        $response->assertJsonMissing(['id' => $outside->id]);
    }
}
