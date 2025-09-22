<?php

namespace App\Models;

use App\Enums\Priority;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;


class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'priority',
        'completed',
        'image_url',
    ];

    protected $casts = [
        'priority' => Priority::class,
        'completed' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected static function booted(): void
    {
        static::creating(function (Task $task) {
            if (empty($task->image_url)) {
                $task->image_url = $task->generateImageUrl();
            }
        });

        static::created(function (Task $task) {
            // Update with actual ID if needed
            if (str_contains($task->image_url, 'seed/')) {
                $task->updateQuietly([
                    'image_url' => $task->generateImageUrl($task->id),
                ]);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Accessor for formatted priority
    public function getFormattedPriorityAttribute(): string
    {
        return $this->priority?->label() ?? '';
    }

    // Accessor for image URL
    public function getImageUrlAttribute($value): string
    {
        return $value ?: $this->generateImageUrl($this->id);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    public function scopePending($query)
    {
        return $query->where('completed', false);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function toggleComplete(): void
    {
        $this->update(['completed' => !$this->completed]);
    }

    // Central method to generate image URL
    public function generateImageUrl($seed = null): string
    {
        $seed = $seed ?? $this->id ?? uniqid('', true);
        return "https://picsum.photos/seed/task{$seed}/400/300";
    }
}

