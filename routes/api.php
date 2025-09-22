<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


Route::apiResource('tasks', TaskController::class)->except(['update', 'destroy']);
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API is running',
        'timestamp' => now()
    ]);
});
