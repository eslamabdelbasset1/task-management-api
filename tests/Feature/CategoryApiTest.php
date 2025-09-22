<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_categories()
    {
        Category::factory(3)->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'color',
                        'tasks_count',
                        'created_at',
                        'updated_at'
                    ]
                ],
            ]);
    }

    public function test_categories_include_task_counts()
    {
        $category = Category::factory()->create();
        Task::factory(3)->create(['category_id' => $category->id]);

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'tasks_count' => 3
            ]);
    }
}
