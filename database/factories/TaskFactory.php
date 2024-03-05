<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = Array("opened","closed","pending");
        $status = $statuses[array_rand($statuses)];
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'deadline' => fake()->dateTimeBetween('now','+1 years'),
            'project_id' => rand(1, 10),
            'user_id' => rand(1, 11),
            'status' => $status,
        ];
    }
}
