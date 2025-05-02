<?php

namespace Feature\Controllers;

use App\Models\CloseApproachData;
use App\Models\NeoObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NeoObjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowsNeoObjectWithCloseApproachData(): void
    {
        $neo = NeoObject::factory()->create([
            'reference_id' => '999',
            'name' => 'Test NEO',
            'absolute_magnitude' => '22.1',
            'estimated_diameter_min' => '0.1234567890',
            'estimated_diameter_max' => '0.9876543210',
            'is_hazardous' => true,
        ]);

        CloseApproachData::factory()->create([
            'neo_object_id' => $neo->id,
            'relative_velocity' => '1234.56789',
            'miss_distance' => '987654.321',
            'close_approach_date_full' => now(),
        ]);

        $response = $this->getJson("/neo-objects/{$neo->id}");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'reference_id',
                'name',
                'absolute_magnitude',
                'estimated_diameter_min',
                'estimated_diameter_max',
                'is_hazardous',
                'created_at',
                'updated_at',
                'close_approaches' => [
                    ['id', 'close_approach_date_full', 'relative_velocity', 'miss_distance', 'created_at', 'updated_at'],
                ],
            ],
        ]);

        $response->assertJsonFragment([
            'reference_id' => '999',
            'name' => 'Test NEO',
        ]);
    }
}
