<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_tasks()
    {
        // Create categories first, then tasks
        Category::factory(3)->create();
        Task::factory(3)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'priority',
                        'completed',
                        'image_url',
                        'category' => [
                            'id',
                            'name',
                            'color'
                        ]
                    ]
                ],
            ]);
    }

    public function test_can_create_task()
    {
        $category = Category::factory()->create();

        $taskData = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'category_id' => $category->id,
            'priority' => 'high'
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Task created successfully'
            ])
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'description',
                    'priority',
                    'completed',
                    'image_url',
                    'category'
                ]
            ]);

        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    public function test_can_toggle_task_status()
    {
        $category = Category::factory()->create();
        $task = Task::factory()->create([
            'category_id' => $category->id,
            'completed' => false
        ]);

        $response = $this->patchJson("/api/tasks/{$task->id}/toggle");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertTrue($task->fresh()->completed);

        // Test toggle back to pending
        $response = $this->patchJson("/api/tasks/{$task->id}/toggle");
        $this->assertFalse($task->fresh()->completed);
    }

    public function test_can_show_single_task()
    {
        $category = Category::factory()->create();
        $task = Task::factory()->create(['category_id' => $category->id]);

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $task->id,
                    'title' => $task->title
                ]
            ]);
    }

    public function test_validation_for_creating_task()
    {
        $response = $this->postJson('/api/tasks', []);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validation failed'
            ])
            ->assertJsonValidationErrors(['title', 'category_id', 'priority']);
    }

    public function test_filter_tasks_by_completed_status()
    {
        Category::factory(2)->create();
        Task::factory(2)->create(['completed' => true]);
        Task::factory(3)->create(['completed' => false]);

        $response = $this->getJson('/api/tasks?completed=true');

        $response->assertStatus(200);
        $completedTasks = collect($response->json('data'))->filter(fn($task) => $task['completed']);
        $this->assertCount(2, $completedTasks);
    }

    public function test_filter_tasks_by_priority()
    {
        Category::factory(2)->create();
        Task::factory(2)->create(['priority' => 'high']);
        Task::factory(3)->create(['priority' => 'low']);

        $response = $this->getJson('/api/tasks?priority=high');

        $response->assertStatus(200);
        $highPriorityTasks = collect($response->json('data'))->filter(fn($task) => $task['priority'] === 'high');
        $this->assertCount(2, $highPriorityTasks);
    }
}
