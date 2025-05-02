<?php

namespace Tests\Feature\Commands;

use App\Contracts\NeoDataAnalysisCollectionInterface;
use App\Models\NeoDataAnalysis;
use App\Models\NeoObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\MockNasaNeoClient;

class ImportNeoDailyCommandJobTest extends TestCase
{
    use RefreshDatabase;
    use MockNasaNeoClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fakeNasaNeoApiResponse();
    }

    public function testCommandMakesInsertsIntoDatabase(): void
    {
        $this->assertDatabaseCount('neo_objects', 0);

        $this->artisan('app:import-neo-daily-command')->assertExitCode(0);

        $this->assertDatabaseHas('neo_objects', [
            'reference_id' => '123456',
            'name' => 'Mock Asteroid',
            'absolute_magnitude' => 20.5,
            'estimated_diameter_min' => 50.0,
            'estimated_diameter_max' => 150.0,
            'is_hazardous' => 0,
        ]);

        $neo = NeoObject::where('reference_id', '123456')->firstOrFail();

        $this->assertDatabaseHas('close_approach_data', [
            'neo_object_id' => $neo->id,
            'relative_velocity' => 12340,
            'miss_distance' => 123456780,
        ]);

        $this->assertDatabaseCount('neo_data_analyses', 1);

        $analysis = NeoDataAnalysis::first();
        $collection = app(NeoDataAnalysisCollectionInterface::class)::make([$neo]);

        $this->assertEquals($collection->totalNeoCount(), $analysis->total_neo_count);
        $this->assertEquals($collection->avgEstimatedDiameterMin(), $analysis->avg_estimated_diameter_min);
        $this->assertEquals($collection->avgEstimatedDiameterMax(), $analysis->avg_estimated_diameter_max);
        $this->assertEquals($collection->maxVelocity(), $analysis->max_velocity);
        $this->assertEquals($collection->minMissDistance(), $analysis->min_miss_distance);
    }
}
