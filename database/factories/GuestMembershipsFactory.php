<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GuestMembershipsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'spending_required' => $this->faker->randomFloat(2, 0, 1000),
            'point_required' => $this->faker->numberBetween(0, 1000),
            'discount' => $this->faker->randomFloat(2, 0, 100)
        ];
    }
}
