<?php

use App\Enums\Priority;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->enum('priority', Priority::values())->default(Priority::MEDIUM->value);
            $table->boolean('completed')->default(false);
            $table->string('image_url')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index(['completed', 'priority']);
            $table->index(['category_id', 'created_at']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
