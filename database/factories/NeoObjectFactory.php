<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NeoObject>
 */
class NeoObjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reference_id' => $this->faker->unique()->numerify('#########'),
            'name' => $this->faker->words(3, true),
            'absolute_magnitude' => $this->faker->randomFloat(2, 15, 25),
            'estimated_diameter_min' => $this->faker->randomFloat(10, 0.1, 1),
            'estimated_diameter_max' => $this->faker->randomFloat(10, 1, 2),
            'is_hazardous' => $this->faker->boolean(),
        ];
    }
}
