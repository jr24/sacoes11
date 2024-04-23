<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Detail>
 */
class DetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'typeGarment' => fake()->randomElement(['saco', 'pantalon', 'chaleco', 'camisa']),
            'quantity' => fake()->numberBetween(1, 4),
            'costUnit' => fake()->numberBetween(50, 300),
            'idOrder' => fake()->randomElement([1, 2, 3, 4, 5]),
        ];
    }
}
