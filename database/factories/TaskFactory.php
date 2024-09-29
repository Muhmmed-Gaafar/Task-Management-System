<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['pending', 'in-progress', 'completed']),
            'due_date' => $this->faker->format('Y-m-d'),
            'user_id' => User::factory(),
            'assigned_to' => User::factory(),
        ];
    }
}

