<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            // 'VAT' => fake()->unique()->numberBetween($min = 1, $max = 50),
            'VAT' => fake()->unique()->numberBetween(00000, 99999),
            'address' => fake()->address(),
        ];
    }
}
