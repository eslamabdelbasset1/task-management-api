<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        // Create a category if none exists, then use it
        $category = Category::inRandomOrder()->first() ?? Category::factory()->create();

        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'category_id' => $category->id,
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'completed' => $this->faker->boolean(30),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => ['completed' => true]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => ['completed' => false]);
    }

    public function highPriority(): static
    {
        return $this->state(fn (array $attributes) => ['priority' => 'high']);
    }
}
