<?php

namespace Database\Factories;

use App\Models\NeoObject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CloseApproachData>
 */
class CloseApproachDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'neo_object_id' => NeoObject::factory(),
            'close_approach_date_full' => $this->faker->date('Y-M-d') . ' ' . $this->faker->time('H:i'),
            'relative_velocity' => $this->faker->randomFloat(10, 5000, 20000),
            'miss_distance' => $this->faker->randomFloat(2, 1000000, 50000000)
        ];
    }
}
