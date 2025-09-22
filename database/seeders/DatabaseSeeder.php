<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Random categories
        Category::factory(5)->create();

        // Tasks linked to existing categories
        Task::factory(20)->create();
    }
}
