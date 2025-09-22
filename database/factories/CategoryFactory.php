<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Work', 'Personal', 'Shopping', 'Health', 'Education',
                'Finance', 'Travel', 'Home', 'Fitness', 'Entertainment'
            ]),
            'color' => $this->faker->hexColor(),
        ];
    }
}
