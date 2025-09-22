<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CategoryController extends Controller
{
    // Display a listing of categories.
    public function index(): JsonResponse
    {
        try {
            $categories = Category::withCount(['tasks', 'tasks as completed_tasks_count' => function ($query) {
                    $query->where('completed', true);
                }
            ])->orderBy('name')->paginate(15);

            return response()->json([
                'success' => true,
                'message' => 'Categories retrieved successfully',
                'data' => CategoryResource::collection($categories)->collection,
                'pagination' => [
                    'current_page' => $categories->currentPage(),
                    'last_page' => $categories->lastPage(),
                    'per_page' => $categories->perPage(),
                    'total' => $categories->total(),
                ],
            ], ResponseAlias::HTTP_OK);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve categories',
                'errors' => [$e->getMessage()],
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
