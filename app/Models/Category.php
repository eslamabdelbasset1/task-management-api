<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    // Get the tasks for the category.
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    // Get the count of tasks for this category.
    public function getTasksCountAttribute(): int
    {
        return $this->tasks()->count();
    }

    // Get the count of completed tasks for this category.
    public function getCompletedTasksCountAttribute(): int
    {
        return $this->tasks()->where('completed', true)->count();
    }

    public function scopeWithTaskCount($query)
    {
        return $query->withCount('tasks');
    }
}
