<?php

namespace Tests\Unit\Jobs;

use App\Jobs\RunDailyNeoAnalysisJob;
use App\Models\CloseApproachData;
use App\Models\NeoDataAnalysis;
use App\Models\NeoObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use \Tests\TestCase;
use Tests\Traits\MockNasaNeoClient;

class RunDailyNeoAnalysisJobTest extends TestCase
{
    use RefreshDatabase;
    use MockNasaNeoClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fakeNasaNeoApiResponse();
    }

    public function testItCreatesNeoDataAnalysisFromNeoObjects(): void
    {
        $date = Carbon::today();

        $neo = NeoObject::factory()->create([
            'estimated_diameter_min' => 50.0,
            'estimated_diameter_max' => 150.0,
            'created_at' => $date->copy()->startOfDay(),
        ]);

        CloseApproachData::factory()->create([
            'neo_object_id' => $neo->id,
            'relative_velocity' => 12340.0,
            'miss_distance' => 123456780.0,
        ]);

        $job = new RunDailyNeoAnalysisJob($date);
        $job->handle();

        $this->assertDatabaseCount('neo_data_analyses', 1);

        $analysis = NeoDataAnalysis::first();

        $this->assertEquals(1, $analysis->total_neo_count);
        $this->assertEquals(50.0, $analysis->avg_estimated_diameter_min);
        $this->assertEquals(150.0, $analysis->avg_estimated_diameter_max);
        $this->assertEquals(12340.0, $analysis->max_velocity);
        $this->assertEquals(123456780.0, $analysis->min_miss_distance);

        $this->assertTrue($analysis->neoObjects->contains($neo));
    }
}
