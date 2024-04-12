<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'lastname' => fake()->lastName(),
            'address' => fake()->streetAddress(),
            'phone' => fake()->numerify('4######'),
            'cellPhone' => fake()->numerify('7#######'),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('123456789'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): Factory{
        return $this->afterCreating(function (User $user) {
            $adminRole = Role::where('name', 'admin')->firstOrFail();
            $user->assignRole($adminRole);
        });
    }

    public function recepcionista(): Factory{
        return $this->afterCreating(function (User $user) {
            $recepcionistatRole = Role::where('name', 'recepcionista')->firstOrFail();
            $user->assignRole($recepcionistatRole);
        });
    }

    public function sastre(): Factory{
        return $this->afterCreating(function (User $user) {
            $sastreRole = Role::where('name', 'sastre')->firstOrFail();
            $user->assignRole($sastreRole);
        });
    }

    public function cliente(): Factory{
        return $this->afterCreating(function (User $user) {
            $clienteRole = Role::where('name', 'cliente')->firstOrFail();
            $user->assignRole($clienteRole);
        });
    }
}
