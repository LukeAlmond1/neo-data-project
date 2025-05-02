<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NeoDataAnalysis>
 */
class NeoDataAnalysisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total_neo_count' => $this->faker->numberBetween(10, 20),
            'avg_estimated_diameter_min' => $this->faker->randomFloat(10, 0.1, 1),
            'avg_estimated_diameter_max' => $this->faker->randomFloat(10, 1, 2),
            'max_velocity' => $this->faker->randomFloat(10, 5000, 20000),
            'min_miss_distance' => $this->faker->randomFloat(2, 1000000, 50000000),
        ];
    }
}
