<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Task::with('category');

            // Apply filters
            if ($request->filled('completed')) {
                $completed = filter_var($request->completed, FILTER_VALIDATE_BOOLEAN);
                $query = $completed ? $query->completed() : $query->pending();
            }

            if ($request->filled('priority')) {
                $query->byPriority($request->priority);
            }

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            $tasks = $query->orderByDesc('created_at')->paginate(15);

            return response()->json([
                'success' => true,
                'message' => 'Tasks retrieved successfully',
                'data' => TaskResource::collection($tasks),
                'pagination' => [
                    'current_page' => $tasks->currentPage(),
                    'last_page' => $tasks->lastPage(),
                    'per_page' => $tasks->perPage(),
                    'total' => $tasks->total(),
                ],
            ], Response::HTTP_OK);


        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve tasks',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            $task = Task::create($request->validated());
            $task->load('category');

            return response()->json([
                'success' => true,
                'message' => 'Task created successfully',
                'data' => new TaskResource($task),
            ], Response::HTTP_CREATED);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create task',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Task $task): JsonResponse
    {
        try {
            $task->load('category');

            return response()->json([
                'success' => true,
                'message' => 'Task retrieved successfully',
                'data' => new TaskResource($task),
            ], Response::HTTP_OK);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve task',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function toggle(Task $task): JsonResponse
    {
        try {
            $task->toggleComplete();
            $task->load('category');

            return response()->json([
                'success' => true,
                'message' => 'Task status updated successfully',
                'data' => new TaskResource($task),
            ], Response::HTTP_OK);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update task status',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
