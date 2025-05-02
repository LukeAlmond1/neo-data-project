<?php

namespace Tests\Unit\Jobs;

use App\Jobs\ImportNeoObjectsJob;
use App\Models\NeoObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Tests\Traits\MockNasaNeoClient;

class ImportNeoObjectsJobTest  extends TestCase
{
    use RefreshDatabase;
    use MockNasaNeoClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fakeNasaNeoApiResponse();
    }

    public function testItImportsNeoObjectAndCloseApproach(): void
    {
        $date = Carbon::today();

        $job = new ImportNeoObjectsJob($date);
        $job->handle(
            app(\App\Contracts\NeoReadRepositoryInterface::class),
            app(\App\Contracts\NeoWriteRepositoryInterface::class)
        );

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
    }
}
