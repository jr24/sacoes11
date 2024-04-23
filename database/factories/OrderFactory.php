<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'startDate' => fake()->date(),
            'endDate' => fake()->date(),
            'description' => fake()->text(),
            'priority' => fake()->randomElement(['low', 'regular', 'high']),
            'idAdminRecepcionista' => fake()->randomElement([ 3, 4]),
            'idCliente' => fake()->randomElement([ 8, 9, 10, 11, 12]),
            'idSastre' => fake()->randomElement([ 5, 6, 7]),
        ];
    }
}
