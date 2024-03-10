<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tasks>
 */
class TasksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => fake()->randomElement(\App\Models\Companies::all('id')),
            'name' => fake()->name(),
            'description' => fake()->sentence(45),
            'user_id' => fake()->randomElement(\App\Models\User::all('id')),
            'is_completed' => fake()->boolean(),
            'start_at' => now(),
            'expired_at' => now()
        ];
    }
}
